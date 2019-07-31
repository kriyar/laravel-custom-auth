@extends('auth.layouts.main')

@section('title')
{{ __('Login') }}
@endsection

@section('content')

<form method="POST" action="{{ route('login') }}">
  @csrf
  <div id="authForm">
    <div class="form-title">{{ __('Sign in') }}</div>

    @include('auth.flash-message')

    <div class="input-field">
      <input type="text" id="identity" name="identity" autocomplete="off" required autofocus value="{{ old('identity') ? old('identity') : '' }}" />
      <i class="material-icons">person</i>
      <label for="identity">{{ __('Username or Email or Phone') }}</label>
    </div>

    <div class="input-field">
      <input type="password" id="password" name="password" required />
      <i class="material-icons">lock</i>
      <label for="password">{{ __('Password') }}</label>
    </div>

    <div class="md-checkbox" style="margin: 35px 0; height: 50px;">
			<input id="i12" type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
			<label for="i12">{{ __('Remember Me') }} </label>

      <a href="{{ route('request.reset.pass') }}" class="forgot-pw">{{ __('Forgot Password?') }}</a>

		</div>

    <div style="margin-top: 65px;">
      <button class="submit-form">{{ __('Login') }}</button>
    </div>
  </div>
</form>
@endsection
