<x-adminheader />
<!-- partial -->
<div class="container-fluid page-body-wrapper" style="display: contents; background: #F5F7FF">
  <!-- partial -->
  <div class="main-panel">        
    <div class="content-wrapper">
      <div class="row">
        <div class="col-12 grid-margin stretch-card">
          <div class="card shadow-lg">
            <div class="card-body">
              <h4 class="card-title">Add/Update CMS</h4>
              <p class="card-description">
                Fill the form to add or update an CMS entry.
              </p>
              <form class="forms-sample" id="cmsForm" action="{{ route('add_cms_data') }}" method="POST">
                @csrf
                
                <!-- Question Input Field -->
                <div class="form-group">
                  <label for="cmsQuestion">CMS</label>
                  <input 
                    type="text" 
                    class="form-control" 
                    id="cmsQuestion" 
                    name="cmsquestion" 
                    placeholder="Enter the Title ..." 
                  >
                  <!-- Error Message for Question -->
                  <span class="error text-danger" id="questionError"></span>
                </div>


                  <!-- Answer Input Field -->
                  <div class="form-group">
                    <label for="faqAnswer">Answer</label>
                    <textarea 
                      class="form-control" 
                      id="faqAnswer" 
                      name="cmsdescription" 
                      rows="4" 
                      placeholder="Enter the FAQ answer...">
                    </textarea>
                    <!-- Error Message for Answer -->
                    <span class="error text-danger" id="answerError"></span>
                  </div>
                
           

            

                <!-- Submit Button -->
                <button type="submit" class="btn btn-primary mr-2" style="width: 20%; font-size: 16px">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- content-wrapper ends -->
    <x-adminfooter />
  </div>
</div>

<script src="https://cdn.ckeditor.com/4.20.2/full/ckeditor.js"></script>
<script>
    // Initialize CKEditor for the description field
    CKEDITOR.replace('cmsdescription');
</script>'

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