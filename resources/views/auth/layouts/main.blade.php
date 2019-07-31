<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>@yield('title', 'System') | {{ env('APP_NAME', 'System') }}</title>

  <!--Import Google Icon Font-->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!--Import materialize.css-->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/css/materialize.min.css" rel="stylesheet" media="screen,projection" />
  <link href="{{ asset('auth/css/style.css') }}" type="text/css" rel="stylesheet" media="screen,projection" />
  @yield('header-scripts')
</head>
<body>
  <div class="container">
    <div class="section">
      @yield('content')

      <div class="footer-copy-right">
          <p>{{ __('All rights reserved') }} © {{date('Y')}}, {{ env('APP_NAME', 'System') }}.</p>
      </div>
    </div>
  </div>

  <!--JavaScript at end of body for optimized loading-->
  <!--===============================================================================================-->
  <script src="{{ asset('auth/js/jquery/jquery-3.2.1.min.js') }}"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/materialize/1.0.0/js/materialize.min.js"></script>
  <script src="{{ asset('auth/js/main.js') }}"></script>
  @yield('footer-scripts')
</body>
</html>
