@extends('auth.layouts.main')

@section('title')
{{ __('Request password reset') }}
@endsection

@section('content')
<form method="POST" action="{{ route('request.reset.pass') }}" id="requestForm">
	@csrf
	<div id="authForm">
		<div class="form-title">{{ __('Request password reset') }}</div>

		@include('auth.flash-message')

		<div class="input-field">
			<input type="text" id="identity" name="identity" autocomplete="off" required autofocus value="{{ old('identity') ? old('identity') : '' }}" />
			<i class="material-icons">person</i>
			<label for="identity">{{ __('Username or Email or Phone') }}</label>
		</div>

		<div style="margin-top: 65px;">
			<button class="submit-form">{{ __('Send Password Reset') }}</button>
		</div>
	</div>
</form>
@endsection

@section('footer-scripts')
<script src="{{ asset('js/custom/string-restrict.js') }}"></script>
@endsection
