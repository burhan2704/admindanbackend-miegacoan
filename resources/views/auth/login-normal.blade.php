<!doctype html>

<html
  lang="en"
  class="light-style layout-wide customizer-hide"
  dir="ltr"
  data-theme="theme-default"
  data-assets-path="core-template/assets/"
  data-template="vertical-menu-template"
  data-style="light">
  <head>
    <meta charset="utf-8" />
    <meta
      name="viewport"
      content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0" />

    <title>Login Mie Gacoan</title>

    <meta name="description" content="" />

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('core-template/assets/img/favicon/favicon.ico') }}" />

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />

    @include('auth.plugin.styles')

    <!-- Helpers -->
    <script src="{{ asset('core-template/assets/vendor/js/helpers.js') }}"></script>

    <!-- Template customizer & Theme config files -->
    <script src="{{ asset('core-template/assets/vendor/js/template-customizer.js') }}"></script>
    <script src="{{ asset('core-template/assets/js/config.js') }}"></script>

  </head>

  <body>
    <!-- Content -->

    <div class="position-relative">
      <div class="authentication-wrapper authentication-basic container-p-y p-4 p-sm-0">
        <div class="authentication-inner py-6">
          <!-- Login -->
          <div class="card p-md-7 p-1">
            <!-- Logo -->
            <div class="app-brand justify-content-center mt-5">
              <a href="#" class="app-brand-link gap-2">
                <span class="app-brand-logo-login demo">
                  <span style="color: #666cff">
                    <img src="{{ asset('images/logo/miegacoan.png') }}" alt="Mie Gacoan Logo" style="height: 60px; width: auto;">

                  </span>
                </span>
                <span class="app-brand-login-text demo text-heading fw-semibold" style="font-size: 40px;">Mie Gacoan</span>
              </a>
            </div>
            <!-- /Logo -->

            <div class="card-body mt-1">

              <form id="formAuthentication" class="mb-5" method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-floating form-floating-outline mb-5">
                  <input
                    type="text"
                    class="form-control"
                    id="email"
                    name="email"
                    placeholder="Enter your email"
                    autofocus />
                  <label for="email">Email</label>
                </div>
                <div class="mb-5">
                  <div class="form-password-toggle">
                    <div class="input-group input-group-merge">
                      <div class="form-floating form-floating-outline">
                        <input
                          type="password"
                          id="password"
                          class="form-control"
                          name="password"
                          placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                          aria-describedby="password" />
                        <label for="password">Password</label>
                      </div>
                      <span class="input-group-text cursor-pointer"><i class="ri-eye-off-line"></i></span>
                    </div>
                  </div>
                </div>
                <div class="mb-5 d-flex justify-content-between mt-5">
                  <div class="form-check mt-2">
                    <input class="form-check-input" type="checkbox" name="remember" id="remember-me" {{ old('remember') ? 'checked' : '' }} />


                    <label class="form-check-label" for="remember-me"> Remember Me </label>
                  </div>
                  <a href="auth-forgot-password-basic.html" class="float-end mb-1 mt-2">
                    <span>Forgot Password?</span>
                  </a>
                </div>
                <div class="mb-5">
                  <button class="btn btn-primary d-grid w-100" type="submit">Sign in</button>
                </div>

                @if($errors->any())
                <div class="alert alert-danger mb-4" id="errorAlert">
                  <ul class="mb-0 ps-3">
                    @foreach($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>


                @endif

              </form>


            </div>
          </div>
          <!-- /Login -->
          <img
            alt="mask"
            src="core-template/assets/img/illustrations/auth-basic-login-mask-light.png"
            class="authentication-image d-none d-lg-block"
            data-app-light-img="illustrations/auth-basic-login-mask-light.png"
            data-app-dark-img="illustrations/auth-basic-login-mask-dark.png" />
        </div>
      </div>
    </div>

    <!-- / Content -->

    @include('auth.plugin.scripts')


  </body>
</html>

<script>
  $(document).ready(function() {
    setTimeout(function() {
        $('#errorAlert').fadeOut(500, function() {
          $(this).remove();
        });
      }, 3000);
  });
</script>
