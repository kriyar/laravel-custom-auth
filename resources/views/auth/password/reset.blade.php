@extends('auth.layouts.main')

@section('title')
{{ __('Reset password') }}
@endsection

@section('content')
<form method="POST" action="{{ route('reset.pass', ['token' => $token]) }}" id="resetForm">
	@csrf
	<div id="authForm">
		<div class="form-title">{{ __('Reset Password') }}</div>
		@if ($errors->has('password'))
		<div class="alert alert-danger alert-block">
				<strong>{{ $errors->first('password') }}</strong>
		</div>
		@else
			@include('auth.flash-message')
		@endif

		<div class="input-field">
			<input class="pass-strength" type="password" id="password" name="password" required autofocus />
			<i class="material-icons">lock</i>
			<label for="password">{{ __('Password') }}</label>
		</div>

		<div class="input-field">
			<input type="password" name="password_confirmation"  id="ConfirmPassword">
			<i class="material-icons">lock</i>
			<label for="ConfirmPassword">{{ __('Confirm new password') }}</label>
		</div>

		<div style="margin-top: 65px;">
			<button class="submit-form">{{ __('Save Password') }}</button>
		</div>
	</div>
</form>
@endsection
