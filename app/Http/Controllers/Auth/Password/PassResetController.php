<?php

namespace App\Http\Controllers\Auth\Password;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Carbon\Carbon;
use App\User;
use App\Notifications\Password\PassRequestReset;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Hash;

class PassResetController extends Controller
{
  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  public function requestForm()
  {
    return view('auth.password.request');
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function storeRequest(Request $request)
  {
    $validator = Validator::make($request->all(), [
      'identity' => ['required','min:5'],
    ]);

    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput();
    }

    $identity = $request->identity;
    $fieldName = filter_var($identity, FILTER_VALIDATE_EMAIL) ? 'email' : (is_numeric($identity) ? 'phone_number' : 'username');
    if ($fieldName == 'phone_number') {
      $phone_prefix = support_current_user_country_phone_prefix();
      $prefix_from_input = mb_substr($identity, 0, strlen($phone_prefix));
      if ($phone_prefix != $prefix_from_input) {
        $number = $identity;
        if (mb_substr($identity, 0, 1) == 0) {
            $number = mb_substr($identity, 1);
        }
        $identity = $phone_prefix . $number;
      }
    }

    $user_id = DB::table('users')
    ->where($fieldName, '=', $identity)
    ->value('id');

    if (!is_numeric($user_id)) {
      return redirect()->back()->with('error', __('User account is not exist in our system.'));
    }

    $email = DB::table('users')
    ->where('id', '=', $user_id)
    ->value('email');

    $phone_number = DB::table('users')
    ->where('id', '=', $user_id)
    ->value('phone_number');

    if (empty($email) && empty($phone_number)) {
      return redirect()->back()->with('error', __('There is no email or phone number associated with this account.'));
    }

    //create a new token to be sent to the user.
    $token = hash_hmac('sha256', Str::random(40), Str::random(10));

    $verify_code = '';
    for ($i = 1; $i <= 6; $i++) {
      $verify_code .= rand(1, 9);
    }

    DB::table('reset_password')->updateOrInsert(
      ['user_id' => $user_id],
      ['token' => $token, 'verify_code' => (int) $verify_code, 'verified' => 0, 'created_at' => Carbon::now()]
    );

    // send SMS/Email
    $user = User::where('id', '=', $user_id)->first();

    $user->verify_token = $token;
    $user->code = $verify_code;

    Notification::send([$user], new PassRequestReset($user));

    return redirect()->route('reset.pass.verify', ['token' => $token])->with('success', __('The password reset verification code is sent to your contact.'));

  }

  /**
  * Determine if the token has expired.
  *
  * @param  string  $createdAt
  * @return bool
  */
  protected function resetTokenExpired($createdAt)
  {
    $seconds = 15 * 60;
    return Carbon::parse($createdAt)->addSeconds($seconds)->isPast();
  }

  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  public function verifyForm($token)
  {
    $user_id = DB::table('reset_password')
    ->where('token', '=', $token)
    ->value('user_id');
    if (empty($user_id)) {
      return redirect()->route('request.reset.pass')->with('error', __('Invalid reset password token.'));
    } else {
      $created_at = DB::table('reset_password')
      ->where('token', '=', $token)
      ->where('verified', '=', 0)
      ->value('created_at');
      if (!$created_at or ($created_at and $this->resetTokenExpired($created_at))) {
        DB::table('reset_password')->where('token', '=', $token)->delete();
        return redirect()->route('request.reset.pass')->with('error', __('Reset password token is invalid or expired, please request password reset again.'));
      }
    }
    return view('auth.password.verify', compact('token'));
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function verifyCode(Request $request, $token)
  {
    $data = $request->all();
    $verify_code = '';
    for ($i = 1; $i <= 6; $i++) {
      $verify_code .= $data['verification_code' . $i];
    }

    $stored_verify_code = DB::table('reset_password')
    ->where('token', '=', $token)
    ->value('verify_code');
    if (empty($verify_code) or $verify_code != $stored_verify_code) {
      return redirect()->back()->withInput()->with('error', __('Invalid verification code, please check again.'));
    }

    $user_id = DB::table('reset_password')
    ->where('token', '=', $token)
    ->value('user_id');

    //create a new token
    $token = hash_hmac('sha256', Str::random(40), Str::random(10));

    // Update to make sure the code is already verified
    DB::table('reset_password')
    ->where('user_id', $user_id)
    ->update(['verified' => 1, 'token' => $token]);
    return redirect()->route('reset.pass', ['token' => $token])->with('success', __('Please reset your password.'));
  }

  /**
  *
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function resetForm($token)
  {
    $request_info = DB::table('reset_password')
    ->where('token', $token)->first();

    if (empty($request_info) or !is_numeric($request_info->verified) or (isset($request_info->created_at) and $this->resetTokenExpired($request_info->created_at))) {
      DB::table('reset_password')->where('token', '=', $token)->delete();
      return redirect()->route('request.reset.pass')->with('error', __('Reset password token is invalid or expired, please request password reset again.'));
    } elseif ($request_info->verified == 0) {
      return redirect()->route('reset.pass.verify', ['token' => $token])->with('warning', __('Please enter verification code before you reset the password.'));
    }

    return view('auth.password.reset', compact('token'));
  }

  /**
  * Update the specified resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function resetPass(Request $request, $token)
  {
    $validator = Validator::make($request->all(), [
      'password' => 'required|min:8|confirmed'
    ]);

    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput();
    }

    $created_at = DB::table('reset_password')
    ->where('token', '=', $token)
    ->where('verified', '=', 1)
    ->value('created_at');

    if ($created_at) {
      if ($this->resetTokenExpired($created_at)) {
        DB::table('reset_password')->where('token', '=', $token)->delete();
        return redirect()->route('request.reset.pass')->with('error', __('Reset password token is expired, please request password reset again.'));
      }

      $input = $request->only('password');
      $input['password'] = Hash::make($input['password']);

      $user_id = DB::table('reset_password')
      ->where('token', '=', $token)
      ->value('user_id');

      // Update password
      $user = User::find($user_id);
      $user->update($input);

      // Delete reset token
      DB::table('reset_password')->where('token', '=', $token)->delete();

      return redirect()->route('login')->with('success', __('Your password is successfully reset, please login with new password.'));
    }

    // Delete reset token
    DB::table('reset_password')->where('token', '=', $token)->delete();

    return redirect()->route('request.reset.pass')->with('error', __('There was an error, please submit to reset password again.'));
  }
}
