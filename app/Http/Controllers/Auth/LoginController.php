<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    /**
     * Check either username or email or phone.
     * @return string
     */
    public function username()
    {
        $identity  = request()->get('identity');
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
        request()->merge([$fieldName => $identity]);
        return $fieldName;
    }

    /**
     * Valid input from user
     *
     * @var string
     */
    protected function validateLogin(Request $request)
    {
        $this->validate($request, [
            $this->username() => 'required|min:5',
            'password' => 'required'
        ]);
    }

    /**
     * Where to field to validate when login.
     *
     * @var string
     */
    protected function credentials(Request $request)
    {
        return [$this->username() => $request->{$this->username()}, 'password' => $request->password, 'status' => 1];
    }

    /**
     * Get the failed login response instance.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendFailedLoginResponse(Request $request)
    {
        $errors = [$this->username() => trans('auth.failed')];

        // Load user from database
        $user = User::where($this->username(), $request->{$this->username()})->first();

        // Invalid username/email/phone
        if (!$user) {
            $message = __('User account is not exist in our system.');
            $errors = [$this->username() => $message];
            $request->session()->flash('error', $message);
        }

        // Invalid password
        if ($user && !Hash::check($request->password, $user->password)) {
            $message = __('Incorrect password.');
            $errors = [$this->username() => $message];
            $request->session()->flash('error', $message);
        }

        // Check if user was successfully loaded, that the password matches
        // and active is not 1. If so, override the default error message.
        if ($user && Hash::check($request->password, $user->password) && $user->status != 1) {
            $message = __('Your account is not active, please contact administrator.');
            $errors = [$this->username() => $message];
            $request->session()->flash('error', $message);
        }

        if ($request->expectsJson()) {
            return response()->json($errors, 422);
        }

        return redirect()->back()
            ->withInput($request->only('identity', 'remember'))
            ->withErrors($errors);
    }
}
