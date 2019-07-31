<?php

namespace App\Http\Controllers\Auth\Verify;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Notifications\Verify\PhoneVerify;
use Illuminate\Support\Facades\Notification;

class PhoneVerifyController extends Controller
{

  /**
  * Register profile
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function verifyRedirect()
  {

    if (!isset(Auth::user()->phone_number) or empty(Auth::user()->phone_number)) {
      return redirect('/')->with('error', __('You do not have phone number in the system, please add phone number to your user profile first.'));
    }

    if (isset(Auth::user()->phone_verified_at) and !empty(Auth::user()->phone_verified_at)) {
      return redirect('/')->with('warning', __('Your phone number is already verified.'));
    }

    //create a new token
    $data = Auth::user()->phone_number;
    $token = support_encrypt_string($data, 12);

    $verify_code = '';
    for ($i = 1; $i <= 6; $i++) {
      $verify_code .= rand(1, 9);
    }

    DB::table('email_phone_verify')->updateOrInsert(
      ['user_id' => Auth::user()->id],
      ['token' => $token, 'verify_code' => (int) $verify_code, 'created_at' => Carbon::now()]
    );

    // Send verification code to phone here, then redirect user
    $user = Auth::user();
    $user->code = $verify_code;

    Notification::send([$user], new PhoneVerify($user));

    return redirect()->route('phone.verify', ['token' => $token]);
  }

  /**
  *
  *
  * @return \Illuminate\Http\Response
  */
  public function phoneVerifyForm($token)
  {
    $check = $this->verifyToken($token);
    if (!$check->status) {
      return redirect('/')->with('error', $check->message);
    }

    return view('auth.verification.phone', compact('token'));
  }

  /**
  * Determine if the token has expired.
  *
  * @param  string  $createdAt
  * @return bool
  */
  protected function verifyTokenExpired($createdAt)
  {
    $seconds = 15 * 60;
    return Carbon::parse($createdAt)->addSeconds($seconds)->isPast();
  }

  /**
  * Determine if the token has expired.
  *
  * @param  string  $createdAt
  * @return bool
  */
  protected function verifyToken($token)
  {
    $return = (object) [
      'status' => TRUE,
      'message' => ''
    ];

    $user_id = DB::table('email_phone_verify')
    ->where('token', '=', $token)
    ->value('user_id');
    if (!is_numeric($user_id)) {
      $return->status = FALSE;
      $return->message = __('Invalid phone verification token.');
    } else {
      $created_at = DB::table('email_phone_verify')
      ->where('token', '=', $token)
      ->value('created_at');
      if (!$created_at or ($created_at and $this->verifyTokenExpired($created_at))) {
        DB::table('email_phone_verify')->where('token', '=', $token)->delete();
        $return->status = FALSE;
        $return->message = __('Phone verification token is invalid or expired, please request new verification.');
      } else {
        $token_phone = support_decrypt_string($token);
        $user = DB::table('users')
        ->where('id', '=', $user_id)->first();
        if ($token_phone != $user->phone_number) {
          $return->status = FALSE;
          $return->message = __('There was something wrong, please contact administrator.');
        } elseif (!empty($user->phone_verified_at)) {
            $return->status = FALSE;
            $return->message = __('Your phone number is already verified.');
        }
      }
    }

    return $return;
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function phoneVerify(Request $request, $token)
  {
    $check = $this->verifyToken($token);
    if (!$check->status) {
      return redirect('/')->with('error', $check->message);
    }

    $data = $request->all();
    $verify_code = '';
    for ($i = 1; $i <= 6; $i++) {
      $verify_code .= $data['verification_code' . $i];
    }

    $stored_verify_code = DB::table('email_phone_verify')
    ->where('token', '=', $token)
    ->value('verify_code');
    if (empty($verify_code) or $verify_code != $stored_verify_code) {
      return redirect()->back()->withInput()->with('error', __('Invalid verification code, please check again.'));
    }

    $user_id = DB::table('email_phone_verify')
    ->where('token', '=', $token)
    ->value('user_id');

    // Update password
    $user = User::find($user_id);
    $input = [];
    $input['phone_verified_at'] = Carbon::now();
    $user->update($input);

    // Delete token
    DB::table('email_phone_verify')->where('token', '=', $token)->delete();

    return redirect()->route('home')->with('success', __('Your phone number is successfully verified.'));
  }
}
