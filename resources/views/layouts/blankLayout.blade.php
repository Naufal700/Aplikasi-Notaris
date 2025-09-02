<!DOCTYPE html>
<html class="light-style" 
      data-theme="theme-default" 
      data-assets-path="{{ asset('/assets') . '/' }}" 
      data-base-url="{{ url('/') }}" 
      data-framework="laravel" 
      data-template="vertical-menu-laravel-template-free">

<head>
  <meta charset="utf-8" />
  <meta name="viewport"
        content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>@yield('title', 'Auth') | Notasys</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <!-- Styles -->
  @stack('before-styles')
  @include('layouts.sections.styles')
  @stack('after-styles')
</head>

<body class="@yield('body-class', 'authentication-bg')">
  <div class="authentication-wrapper">
    <div class="authentication-inner">
      @yield('content')
    </div>
  </div>

  <!-- Scripts -->
  @stack('before-scripts')
  @include('layouts.sections.scripts')
  @stack('after-scripts')
</body>
</html>
