<!DOCTYPE html>
<html lang="en">

<head>
  <!-- Required meta tags -->
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <title>Register | Skydash Admin</title>
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
              <h4>New here?</h4>
              <h6 class="font-weight-light">Signing up is easy. It only takes a few steps.</h6>

              <!-- Fortify Registration Form -->
              <form method="POST" action="{{ route('register') }}" class="pt-3">
                @csrf

                <!-- Name -->
                <div class="form-group">
                  <input type="text" name="name" class="form-control form-control-lg" id="name" placeholder="Name" value="{{ old('name') }}" autofocus>
                  @error('name')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Email -->
                <div class="form-group">
                  <input type="email" name="email" class="form-control form-control-lg" id="email" placeholder="Email" value="{{ old('email') }}">
                  @error('email')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Phone -->
                <div class="form-group">
                  <input type="text" name="phone" class="form-control form-control-lg" id="phone" placeholder="Phone" value="{{ old('phone') }}">
                  @error('phone')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Age -->
                <div class="form-group">
                  <input type="number" name="age" class="form-control form-control-lg" id="age" placeholder="Age" value="{{ old('age') }}">
                  @error('age')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- City -->
                <div class="form-group">
                  <input type="text" name="city" class="form-control form-control-lg" id="city" placeholder="City" value="{{ old('city') }}">
                  @error('city')
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

                <!-- Confirm Password -->
                <div class="form-group">
                  <input type="password" name="password_confirmation" class="form-control form-control-lg" id="password_confirmation" placeholder="Confirm Password">
                  @error('password_confirmation')
                  <div class="text-danger mt-1">{{ $message }}</div>
                  @enderror
                </div>

                <!-- Submit Button -->
                <div class="mt-3">
                  <button type="submit" class="btn btn-block btn-primary btn-lg font-weight-medium auth-form-btn">
                    SIGN UP
                  </button>
                </div>

                <!-- Footer Links -->
                <div class="text-center mt-4 font-weight-light">
                  Already have an account? <a href="{{ route('thmlogin') }}" class="text-primary">Login</a>
                </div>
              </form>
              <!-- End Fortify Registration Form -->
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
