<x-adminheader />
<!-- partial -->
<div class="container-fluid page-body-wrapper" style="display: contents">
    <!-- partial -->
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-8 grid-margin stretch-card">
                    <div class="card">
                        <div class="card-body">
                            <h4 class="card-title">Add/Update Contact</h4>
                            <p class="card-description">
                                Fill the form as per guidelines
                            </p>
                            <form class="forms-sample" action="{{ route('update_contact', $contact->id) }}"
                                method="POST">
                                @csrf

                                <div class="form-group">
                                    <label for="exampleInputName1">Name</label>
                                    <input type="text" class="form-control" id="exampleInputName1" name="contactname"
                                        value="{{ $contact->name }}" placeholder="Enter Name ...">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputEmail3">Email address</label>
                                    <input type="email" class="form-control" id="exampleInputEmail3"
                                        name="contactemail" value="{{ $contact->email }}" placeholder="Enter Email ...">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputPassword4">Phone No. </label>
                                    <input type="number" class="form-control" id="exampleInputPassword4"
                                        name="contactphoneno" value="{{ $contact->phoneno }}"
                                        placeholder="Enter Phone Number ...">
                                </div>
                                <div class="form-group">
                                    <label for="exampleInputCity1">City</label>
                                    <input type="text" class="form-control" id="exampleInputCity1" name="contactcity"
                                        placeholder="Enter Name of the City ..." value="{{$contact->city}}">
                                    <span class="error text-danger" id="cityError"></span>
                                </div>

                                <div class="form-group">
                                    <label for="exampleInputCity1">Country</label>
                                    <input type="text" class="form-control" id="exampleInputCity1"
                                        name="contactcountry" value="{{ $contact->country }}"
                                        placeholder="Enter Name of the Country ...">
                                </div>


                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
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



