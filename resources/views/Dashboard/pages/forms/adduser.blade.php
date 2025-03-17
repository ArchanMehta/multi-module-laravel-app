<x-adminheader />
<!-- partial -->
<div class="container-fluid page-body-wrapper" style="display: contents">
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-8 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title">Add/Update User</h4>
                            <p class="card-description">
                                Fill the form as per guidelines
                            </p>
                            <form class="forms-sample" id="userForm" action="{{ route('add_user_data') }}"
                                method="POST">
                                @csrf

                                <!-- Name Field -->
                                <div class="form-group">
                                    <label for="exampleInputName1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputName1" name="username"
                                        placeholder="Enter Name ...">
                                    <span class="error text-danger" id="nameError"></span>
                                </div>

                                <!-- Email Field -->
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail3" name="useremail"
                                        placeholder="Enter Email ...">
                                    <span class="error text-danger" id="emailError"></span>
                                </div>

                                <!-- Phone Number Field -->
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Phone No. </label>
                                    <input type="number" class="form-control" id="exampleInputPassword4"
                                        name="userphoneno" placeholder="Enter Phone Number ...">
                                    <span class="error text-danger" id="phoneError"></span>
                                </div>

                                <!-- Age Field -->
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Age </label>
                                    <input type="number" class="form-control" id="exampleInputAge" name="userage"
                                        placeholder="Enter Age ...">
                                    <span class="error text-danger" id="ageError"></span>
                                </div>

                                <!-- City Field -->
                                <div class="form-group">
                                    <label for="exampleInputCity1">City</label>
                                    <input type="text" class="form-control" id="exampleInputCity1" name="usercity"
                                        placeholder="Enter Name of the City ...">
                                    <span class="error text-danger" id="cityError"></span>
                                </div>

                                <!-- Role Dropdown -->
                                <div class="form-group">
                                    <label for="exampleInputRole">Role</label>
                                    <select class="form-control styled-select" name="userrole"
                                        id="exampleInputRole">
                                        <option disabled selected>Select the Role for user ---</option>
                               
                                  @foreach($allroles as $role)

                                  <option value="{{$role->title}}">{{$role->title}}</option>

                                  @endforeach
                                </select>
                                    <!-- Error Message for Status -->
                                    <span class="error text-danger" id="statusError"></span>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary mr-2"
                                    style="width: 25%;font-size:16px">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
        <x-adminfooter />
    </div>
</div>


<script>
  // Check for a success message in the session
  @if (session('success'))
      toastr.success('{{ session('success') }}', 'Success', {
          closeButton: true,
          progressBar: true,
          timeOut: 3000
      });
  @endif
  @if (session('error'))
        toastr.error('{{ session('error') }}', 'Error', {
            closeButton: true,
            progressBar: true,
            timeOut: 3000
        });
    @endif
</script>

<!-- jQuery Validation Script -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Form submission handler
        $('#userForm').on('submit', function(e) {
            e.preventDefault(); // Prevent form submission to handle validation first

            // Clear previous error messages
            $('.error').text('');

            let isValid = true;

            // Validate Name
            const name = $('#exampleInputName1').val().trim();
            if (name.length < 3) {
                isValid = false;
                $('#nameError').text('Name must be at least 3 characters.');
            }

            // Validate Email
            const email = $('#exampleInputEmail3').val().trim();
            const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
            if (!emailPattern.test(email)) {
                isValid = false;
                $('#emailError').text('Please enter a valid email address.');
            }

            // Validate Phone Number
            const phone = $('#exampleInputPassword4').val().trim();
            if (!/^\d{10,15}$/.test(phone)) {
                isValid = false;
                $('#phoneError').text('Phone number must be between 10 and 15 digits.');
            }

            // Validate Age
            const age = $('#exampleInputAge').val().trim();
            if (age < 1 || age > 120 || !Number.isInteger(Number(age))) {
                isValid = false;
                $('#ageError').text('Age must be a number between 1 and 120.');
            }

            // Validate City
            const city = $('#exampleInputCity1').val().trim();
            if (city.length < 2) {
                isValid = false;
                $('#cityError').text('City name must be at least 2 characters.');
            }

            // If the form is valid, submit it
            if (isValid) {
                this.submit(); // Form will submit to the backend route
            }
        });
    });
</script>
