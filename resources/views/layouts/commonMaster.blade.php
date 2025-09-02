<!DOCTYPE html>
<html class="light-style layout-menu-fixed" 
      data-theme="theme-default" 
      data-assets-path="{{ asset('/assets') . '/' }}" 
      data-base-url="{{ url('/') }}" 
      data-framework="laravel" 
      data-template="vertical-menu-laravel-template-free">

<head>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />
  <title>@yield('title', 'Dashboard') | Notasys</title>
  <meta name="csrf-token" content="{{ csrf_token() }}">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Styles -->
  @stack('before-styles')
  @include('layouts.sections.styles')
  @stack('after-styles')

  <!-- Scripts (includes dari section khusus, kalau ada library tambahan) -->
  @stack('before-scripts-includes')
  @include('layouts.sections.scriptsIncludes')
  @stack('after-scripts-includes')
</head>

<body class="@yield('body-class', '')">
  <div class="layout-wrapper layout-content-navbar">
    <div class="layout-container">

      <!-- Sidebar -->
      @include('layouts.sections.menu.verticalMenu')
      <!-- /Sidebar -->

      <!-- Layout page -->
      <div class="layout-page">

        <!-- Navbar -->
        @include('layouts.sections.navbar.navbar')
        <!-- /Navbar -->

        <!-- Content wrapper -->
        <div class="content-wrapper">
          <div class="container-xxl flex-grow-1 container-p-y">
            @yield('content') <!-- Halaman spesifik muncul di sini -->
          </div>

          <!-- Footer -->
          @include('layouts.sections.footer.footer')
        </div>
        <!-- /Content wrapper -->

      </div>
      <!-- /Layout page -->

    </div>
  </div>

  <!-- Vendor & Core JS -->
  <script src="{{ asset('assets/vendor/js/helpers.js') }}"></script>
  <script src="{{ asset('assets/js/config.js') }}"></script>
  <script src="{{ asset('assets/js/menu.js') }}"></script>

  <!-- Bootstrap Bundle (sudah termasuk Popper.js) -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- SweetAlert2 -->
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Github button optional -->
  <script async defer src="https://buttons.github.io/buttons.js"></script>

  @stack('before-scripts')
  @include('layouts.sections.scripts')
  @stack('after-scripts')
</body>
</html>
