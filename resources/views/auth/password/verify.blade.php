@extends('auth.layouts.main')

@section('title')
{{ __('Verify password reset') }}
@endsection

@section('header-scripts')
<style>
input {
	outline: none;
	border: 1px solid;
}

input:focus {
	border-color: #529afe !important;
}

.num-input {
	width: 33px !important;
	margin: 5px !important;
	height: 60px !important;
	text-align: center;
	font-weight: bold;
	font-size: 20px;
}

@media only screen and (max-width: 600px) {
	.num-input {
		width: 25px;
		margin: 5px;
		height: 50px;
		text-align: center;
		font-weight: bold;
		font-size: 16px;
	}
}
</style>
@endsection

@section('content')
<form method="POST" action="{{ route('reset.pass.verify', ['token' => $token]) }}" id="verifyForm">
	@csrf
	<div id="authForm">
		<div class="form-title">{{ __('Verification code') }}</div>


		@include('auth.flash-message')

		<div class="form-group" style="display: flex; justify-content: center; height: 100px;">
			<div>
				@for ($i = 1; $i <= 6; $i++)
				<input title="Please enter verification code" id="verify-code{{$i}}" maxlength=1 type="text" autocomplete=off class="num-input @error('verification_code') is-invalid @enderror" name="verification_code{{$i}}" value="{{ old('username') }}" required {{ $i == 1 ? "autofocus" : ""}}>
				@endfor
			</div>
		</div>

		<div style="margin-top: 65px;">
			<button class="submit-form">{{ __('Click here if not automatically submit') }}</button>
		</div>
	</div>
</form>
@endsection

@section('footer-scripts')
<!-- Input number
============================================ -->
<script src="{{ asset('auth/js/input_code.js') }}"></script>
@endsection
