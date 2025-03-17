<x-adminheader />
    <!-- partial -->
    <div class="container-fluid page-body-wrapper" style="display: contents ;background:#F5F7FF">
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper" style="height: 722px">
          <div class="row">
            <div class="col-12 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add/Update Role</h4>
                  <p class="card-description">
                    Fill the form as per guidelines
                  </p>
                  <form class="forms-sample" action="{{route("update_role",$role->id)}}" method="POST">
                    @csrf

                    <div class="form-group">
                      <label for="exampleInputTitle">Title</label>
                      <input 
                        type="text" 
                        class="form-control" 
                        id="exampleInputTitle" 
                        name="roletitle" 
                        value="{{$role->title}}"
                        placeholder="Enter Title of Role..." 
                        required>
                    </div>
                    
                    <div class="form-group">
                      <label for="exampleInputStatus">Status</label>
                      <select 
                        class="form-control "
                        name="rolestatus" 
                        id="exampleInputStatus" 
                        >
                        <option>Select the status for the Role ---</option>
                        <option value="Inactive" {{$role->status === "Inactive" ?"selected":""}} >Inactive</option>
                        <option value="Active" {{$role->status === "Active" ?"selected":""}} >Active</option>
                      </select>
                      
                    </div>
    
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button type="reset" class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
         
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->