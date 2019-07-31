<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Rules\ValidPhone;
use App\Rules\ValidEmail;

class RegisterController extends Controller
{
  /**
   * Create a new controller instance.
   *
   * @return void
   */
  public function __construct()
  {
      $this->middleware('guest');
  }

  /**
   * Show register form
   *
   */
  public function showRegistrationForm() {
      $phone_prefix = support_current_user_country_phone_prefix();
      return view('auth.register', compact('phone_prefix'));
  }

  /**
   * Submit register form
   *
   */
  public function register(Request $request)
  {
    $data = $request->all();
    $validator = $this->validator($data);

    if ($validator->fails()) {
      return redirect()->back()
      ->withErrors($validator)
      ->withInput();
    }

    $user = $this->create($data);

    return redirect()->route('login')->with('success', __("User account is successfully created, please login with registered credential."));
  }

  /**
   * Get a validator for an incoming registration request.
   *
   * @param  array  $data
   * @return \Illuminate\Contracts\Validation\Validator
   */
  protected function validator(array $data)
  {
      return Validator::make($data, [
          'username' => ['required', 'string', 'min:5', 'max:255', 'unique:users'],
          'email' => ['nullable', 'string', 'email', 'max:255', 'unique:users', new ValidEmail],
          'phone_number' => ['nullable', 'min:8', 'unique:users', new ValidPhone],
          'password' => ['required', 'string', 'min:8', 'confirmed'],
      ]);
  }

  /**
   * Create a new user instance after a valid registration.
   *
   * @param  array  $data
   * @return \App\User
   */
  protected function create(array $data)
  {
      return User::create([
          'username' => $data['username'],
          'email' => $data['email'],
          'phone_number' => $data['phone_number'],
          'password' => Hash::make($data['password']),
      ]);
  }
}
