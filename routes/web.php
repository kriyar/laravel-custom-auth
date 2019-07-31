<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/home', 'HomeController@index')->name('home');

Auth::routes([
  'register' => false,
  'verify' => false,
  'reset' => false
]);

Route::get('/reset/pass', 'Auth\Password\PassResetController@requestForm')->middleware('guest')->name('request.reset.pass');
Route::post('/reset/pass', 'Auth\Password\PassResetController@storeRequest')->middleware('guest')->name('request.reset.pass');
Route::get('/reset/pass/{token}/verify', 'Auth\Password\PassResetController@verifyForm')->middleware('guest')->name('reset.pass.verify');
Route::post('/reset/pass/{token}/verify', 'Auth\Password\PassResetController@verifyCode')->middleware('guest')->name('reset.pass.verify');
Route::get('/reset/pass/{token}', 'Auth\Password\PassResetController@resetForm')->middleware('guest')->name('reset.pass');
Route::post('/reset/pass/{token}', 'Auth\Password\PassResetController@resetPass')->middleware('guest')->name('reset.pass');
Route::get('/user/register', 'Auth\RegisterController@showRegistrationForm')->name('user.register');
Route::post('/user/register', 'Auth\RegisterController@register')->name('user.register');

// Email verify
Route::get('/email/verify/{token}', 'Auth\Verify\EmailVerifyController@emailVerify')->name('email.verify');

Route::group(['middleware' => ['auth']], function() {
  // Email verify
  Route::get('/email/verify', 'Auth\Verify\EmailVerifyController@verifyRedirect')->name('email.verify.redirect');

  // Phone verify
  if (config('support.nexmo_sms_enabled')) {
    Route::get('/phone/verify', 'Auth\Verify\PhoneVerifyController@verifyRedirect')->name('phone.verify.redirect');
    Route::get('/phone/verify/{token}', 'Auth\Verify\PhoneVerifyController@phoneVerifyForm')->name('phone.verify');
    Route::post('/phone/verify/{token}', 'Auth\Verify\PhoneVerifyController@phoneVerify')->name('phone.verify');
  }
});
