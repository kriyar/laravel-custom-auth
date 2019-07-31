@extends('auth.layouts.main')

@section('title')
{{ __('Register account') }}
@endsection

@section('content')

<form method="POST" action="{{ route('user.register') }}">
  @csrf
  <div id="authForm">
    <div class="form-title">{{ __('Sign Up') }}</div>

    @include('auth.flash-message')

    <div class="input-field">
      <input type="text" id="username" name="username" autocomplete="off" required autofocus value="{{ old('username') ? old('username') : '' }}" />
      <i class="material-icons">person</i>
      <label for="username">{{ __('Username') }}</label>
    </div>
    @if ($errors->has('username'))
    <span class="text-danger">
        <strong id="username-error">{{ __($errors->first('username')) }}</strong>
    </span>
    @endif

    <div class="input-field">
      <input type="email" id="email" name="email" autocomplete="off" value="{{ old('email') ? old('email') : '' }}" />
      <i class="material-icons">email</i>
      <label for="email">{{ __('Email') }}</label>
    </div>
    @if ($errors->has('email'))
    <span class="text-danger">
        <strong id="email-error">{{ __($errors->first('email')) }}</strong>
    </span>
    @endif

    <div class="input-field">
      <input type="number" id="phone_number" name="phone_number" autocomplete="off" value="{{ old('phone_number') ? old('phone_number') : '' }}" />
      <i class="material-icons">phone</i>
      <label for="phone_number">{{ __('Phone Number') }}</label>
    </div>
    @if ($errors->has('phone_number'))
    <span class="text-danger">
        <strong id="phone-number-error">{{ __($errors->first('phone_number')) }}</strong>
    </span>
    @endif

    <div class="input-field">
      <input type="password" id="password" name="password" required />
      <i class="material-icons">lock</i>
      <label for="password">{{ __('Password') }}</label>
    </div>
    @if ($errors->has('password'))
    <span class="text-danger">
        <strong id="password-error">{{ __($errors->first('password')) }}</strong>
    </span>
    @endif

    <div class="input-field">
			<input type="password" name="password_confirmation"  id="ConfirmPassword">
			<i class="material-icons">lock</i>
			<label for="ConfirmPassword">{{ __('Confirm password') }}</label>
		</div>

    <div style="margin-top: 65px;">
      <button class="submit-form">{{ __('Submit') }}</button>
    </div>
  </div>
</form>
@endsection

@section('footer-scripts')
<script>
$("#phone_number").keyup(function(){
    var prefix = "{{ $phone_prefix }}";
    if(this.value.indexOf(prefix) !== 0){
        this.value = prefix + this.value;
    }
});
</script>
@endsection
