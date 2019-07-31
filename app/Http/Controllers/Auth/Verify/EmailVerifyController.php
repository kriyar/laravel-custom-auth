<?php

namespace App\Http\Controllers\Auth\Verify;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Notifications\Verify\EmailVerify;
use Illuminate\Support\Facades\Notification;

class EmailVerifyController extends Controller
{
  /**
  * Register profile
  *
  * @param  int  $id
  * @return \Illuminate\Http\Response
  */
  public function verifyRedirect()
  {

    if (!isset(Auth::user()->email) || empty(Auth::user()->email)) {
      return redirect('/')->with('error', __('You do not have email in the system, please add email to your user account first.'));
    }

    if (isset(Auth::user()->email_verified_at) and !empty(Auth::user()->email_verified_at)) {
      return redirect('/')->with('warning', __('Your email address is already verified.'));
    }

    //create a new token
    $data = Auth::user()->email;
    $token = support_encrypt_string($data, 12);

    $verify_code = '';
    for ($i = 1; $i <= 6; $i++) {
      $verify_code .= rand(1, 9);
    }

    DB::table('email_phone_verify')->updateOrInsert(
      ['user_id' => Auth::user()->id],
      ['token' => $token, 'verify_code' => (int) $verify_code, 'created_at' => Carbon::now()]
    );

    // Send verification code to email here, then redirect user back
    $user = Auth::user();
    $user->verify_token = $token;

    Notification::send([$user], new EmailVerify($user));

    return redirect('/')->with('success',  __('We have sent you an email with instructions to verify your email.'));
  }

  /**
  * Determine if the token has expired.
  *
  * @param  string  $createdAt
  * @return bool
  */
  protected function verifyTokenExpired($createdAt)
  {
    $seconds = 24 * 60 * 60; // 24 hours
    return Carbon::parse($createdAt)->addSeconds($seconds)->isPast();
  }

  /**
  * Store a newly created resource in storage.
  *
  * @param  \Illuminate\Http\Request  $request
  * @return \Illuminate\Http\Response
  */
  public function emailVerify($token)
  {
    $user_id = DB::table('email_phone_verify')
    ->where('token', '=', $token)
    ->value('user_id');
    if (!is_numeric($user_id)) {
      return redirect()->route('home')->with('error', __('Invalid email verification token.'));
    } else {
      $created_at = DB::table('email_phone_verify')
      ->where('token', '=', $token)
      ->value('created_at');
      if (!$created_at or ($created_at and $this->verifyTokenExpired($created_at))) {
        DB::table('email_phone_verify')->where('token', '=', $token)->delete();
        return redirect('/')->with('error', __('Email verification token is invalid or expired, please request new verification.'));
      } else {
        $token_email = support_decrypt_string($token);
        $user = DB::table('users')
        ->where('id', '=', $user_id)->first();
        if ($token_email != $user->email) {
          return redirect('/')->with('error', __('There was something wrong, please contact administrator.'));
        } elseif (!empty($user->email_verified_at)) {
          return redirect('/')->with('error', __('Your email address is already verified.'));
        }
      }
    }

    // Set email as verified
    $user = User::find($user_id);
    $input = [];
    $input['email_verified_at'] = Carbon::now();
    $user->update($input);

    // Delete token
    DB::table('email_phone_verify')->where('token', '=', $token)->delete();

    return redirect('/')->with('success', __('Your email address is successfully verified.'));
  }
}
