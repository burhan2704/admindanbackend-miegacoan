<!doctype html>
<html
  lang="en"
  class="light-style layout-navbar-fixed layout-menu-fixed layout-compact"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="{{ asset('core-template/assets/') }}/"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>ERP | Mie Gacoan</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('images/logo/miegacoan.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
      href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&amp;display=swap"
      rel="stylesheet" />

    @include('layouts.plugin.styles')
    @stack('page-css')

    <!-- Helpers -->
    <script src="{{ asset('core-template/assets/vendor/js/helpers.js') }}"></script>
    <script src="{{ asset('core-template/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('core-template/assets/js/config.js') }}"></script>
  </head>

  <body>

    {{-- loading --}}
    <div id="fullscreen-loader" style="display:none;">
        <div class="loading-container">
            <div class="loader"></div>
            <p>Loading...</p>
        </div>
    </div>

    <!-- Layout wrapper -->
    <div class="layout-wrapper layout-content-navbar">
      <div class="layout-container">
        @include('layouts.sidebar')

        <!-- Layout container -->
        <div class="layout-page">
          @include('layouts.navbar')

          <!-- Content wrapper -->
          <div class="content-wrapper">
            <div class="container-xxl flex-grow-1 container-p-y">
              @yield('content')
            </div>

            @include('layouts.footer')
            <div class="content-backdrop fade"></div>
          </div>
        </div>
      </div>

      <!-- Overlay -->
      <div class="layout-overlay layout-menu-toggle"></div>
      <div class="drag-target"></div>
    </div>

    <!-- Core JS -->
    @include('layouts.plugin.scripts')
    @stack('page-js')
  </body>
</html>
