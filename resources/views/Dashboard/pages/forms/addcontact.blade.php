<x-adminheader />
<div class="container-fluid page-body-wrapper" style="display: contents">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-8 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title">Add/Update Contact</h4>
                            <p class="card-description">
                                Fill the form as per guidelines
                            </p>
                            <form class="forms-sample" id="contactForm" action="{{ route('add_contact_data') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="exampleInputName1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputName1" name="contactname"
                                        placeholder="Enter Name ...">
                                    <span class="error text-danger" id="nameError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail3"
                                        name="contactemail" placeholder="Enter Email ...">
                                    <span class="error text-danger" id="emailError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Phone No. </label>
                                    <input type="number" class="form-control" id="exampleInputPassword4"
                                        name="contactphoneno" placeholder="Enter Phone Number ...">
                                    <span class="error text-danger" id="phoneError"></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputCity1">City</label>
                                    <input type="text" class="form-control" id="exampleInputCity1" name="contactcity"
                                        placeholder="Enter Name of the City ...">
                                    <span class="error text-danger" id="cityError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputCity1">Country</label>
                                    <input type="text" class="form-control" id="exampleInputCity1"
                                        name="contactcountry" placeholder="Enter Name of the Country ...">
                                    <span class="error text-danger" id="countryError"></span>
                                </div>

                                <button type="submit" class="btn btn-primary mr-2"
                                    style="width: 25%;font-size:16px">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-adminfooter />

        <script>
            $(document).ready(function() {
                $('#contactForm').on('submit', function(e) {
                    e.preventDefault();
                    $('.error').text('');
                    let isValid = true;

                    // Name validation
                    const name = $('#exampleInputName1').val().trim();
                    if (name.length < 3) {
                        isValid = false;
                        $('#nameError').text('Name must be at least 3 characters.');
                    }

                    // Email validation
                    const email = $('#exampleInputEmail3').val().trim();
                    const emailPattern = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;
                    if (!emailPattern.test(email)) {
                        isValid = false;
                        $('#emailError').text('Please enter a valid email address.');
                    }

                    // Phone validation
                    const phone = $('#exampleInputPassword4').val().trim();
                    if (!/^\d{10,15}$/.test(phone)) {
                        isValid = false;
                        $('#phoneError').text('Phone number must be between 10 and 15 digits.');
                    }

                

                    // City validation
                    const city = $('#exampleInputCity1').val().trim();
                    if (city.length < 2) {
                        isValid = false;
                        $('#cityError').text('City name must be at least 2 characters.');
                    }

                    // Submit form if valid
                    if (isValid) {
                        this.submit();
                    }
                });
            });
        </script>

   
