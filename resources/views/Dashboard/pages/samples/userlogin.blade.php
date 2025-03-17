<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Login | Skydash Admin</title>
  <!-- plugins:css -->
  <link rel="stylesheet" href="{{ asset('dashboard/vendors/feather/feather.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/vendors/ti-icons/css/themify-icons.css') }}">
  <link rel="stylesheet" href="{{ asset('dashboard/vendors/css/vendor.bundle.base.css') }}">
  <!-- End inject -->
  <!-- inject:css -->
  <link rel="stylesheet" href="{{ asset('dashboard/css/vertical-layout-light/style.css') }}">
  <!-- endinject -->
  <link rel="shortcut icon" href="{{ asset('dashboard/images/favicon.png') }}" />
</head>

<body>
  <div class="container-scroller">
    <div class="container-fluid page-body-wrapper full-page-wrapper">
      <div class="content-wrapper d-flex align-items-center auth px-0">
        <div class="row w-100 mx-0">
          <div class="col-lg-4 mx-auto">
            <div class="auth-form-light text-left py-5 px-4 px-sm-5">
              <div class="brand-logo">
                <img src="{{ asset('dashboard/images/logo.svg') }}" alt="logo">
              </div>
              <h4>Welcome</h4>
              <h6 class="font-weight-light">Sign in to continue.</h6>

              <!-- Fortify Login Form -->
              <form method="POST" action="{{ route('login') }}" class="pt-3">
                @csrf

                <!-- Email Address -->
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Email" value="{{ old('email') }}" autofocus>
                  @error('email')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Password -->
                <div class="form-group">
                  <input type="password" name="password" class="form-control form-control-lg" id="password" placeholder="Password">
                  @error('password')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Remember Me -->
                <div class="my-2 d-flex justify-content-between align-items-center">
                  <div class="form-check">
                    <label class="form-check-label text-muted">
                      <input type="checkbox" name="remember" class="form-check-input">
                      Keep me signed in
                    </label>
                  </div>
                  @if (Route::has('password.request'))
                  <a href="{{ route('password.request') }}" class="auth-link text-black" style="color: #4B49AC">Forgot password?</a>
                  @endif
                </div>

                <!-- Submit Button -->
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    SIGN IN
                  </button>
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-4 font-weight-light">
                  Don't have an account? <a href="{{ route('thmreg') }}" class="text-primary">Create</a>
                </div>
              </form>
              <!-- End Fortify Login Form -->
            </div>
          </div>
        </div>
      </div>
      <!-- content-wrapper ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <!-- plugins:js -->
  <script src="{{ asset('dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
  <!-- endinject -->
  <script src="{{ asset('dashboard/js/off-canvas.js') }}"></script>
  <script src="{{ asset('dashboard/js/hoverable-collapse.js') }}"></script>
  <script src="{{ asset('dashboard/js/template.js') }}"></script>
  <script src="{{ asset('dashboard/js/settings.js') }}"></script>
  <script src="{{ asset('dashboard/js/todolist.js') }}"></script>
  <!-- endinject -->
</body>

</html>
