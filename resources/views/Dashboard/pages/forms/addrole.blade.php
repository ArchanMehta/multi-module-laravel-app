
<x-adminheader />

<!-- partial -->
<div class="container-fluid page-body-wrapper" style="display: contents ;background:#F5F7FF">
  <!-- partial -->
  <div class="main-panel">        
    <div class="content-wrapper" style="height: 722px">
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card shadow-lg">
            <div class="card-body">
              <h4 class="card-title">Add/Update Role</h4>
              <p class="card-description">
                Fill the form as per guidelines
              </p>
              <form class="forms-sample" id="roleForm" action="{{ route('add_role_data') }}" method="POST">
                @csrf
                
                <!-- Title Input Field -->
                <div class="form-group">
                  <label for="exampleInputTitle">Title</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    id="exampleInputTitle" 
                    name="roletitle" 
                    placeholder="Enter Title of Role..." 
                   >
                  <!-- Error Message for Title -->
                  <span class="error text-danger" id="titleError"></span>
                </div>
                
                <!-- Status Dropdown -->
                <div class="form-group">
                  <label for="exampleInputStatus">Status</label>
                  <select 
                    class="form-control styled-select" 
                    name="rolestatus" 
                    id="exampleInputStatus" 
                    >
                    <option disabled selected>Select the status for the Role ---</option>
                    <option value="Inactive">Inactive</option>
                    <option value="Active">Active</option>
                  </select>
                  <!-- Error Message for Status -->
                  <span class="error text-danger" id="statusError"></span>
                </div>

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mr-2" style="width: 20%;font-size:16px">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    
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
  $(document).ready(function () {
    // Form submission handler
    $('#roleForm').on('submit', function (e) {
      e.preventDefault(); // Prevent form submission to handle validation first

      // Clear previous error messages
      $('.error').text('');

      let isValid = true;

      // Validate Title
      const title = $('#exampleInputTitle').val().trim();
      if (title.length < 3) {
        isValid = false;
        $('#titleError').text('Title must be at least 3 characters.');
      }

      // Validate Status
      const status = $('#exampleInputStatus').val();
      if (!status) {
        isValid = false;
        $('#statusError').text('Please select a status.');
      }

      // If the form is valid, submit it
      if (isValid) {
        this.submit(); // Form will submit to the backend route
      }
    });
  });
</script>
