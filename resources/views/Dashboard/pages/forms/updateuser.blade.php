<x-adminheader />
    <!-- partial -->
    <div class="container-fluid page-body-wrapper"  style="display: contents">
      <!-- partial -->
      <div class="main-panel">        
        <div class="content-wrapper">
          <div class="row">
            <div class="col-8 grid-margin stretch-card">
              <div class="card">
                <div class="card-body">
                  <h4 class="card-title">Add/Update User</h4>
                  <p class="card-description">
                    Fill the form as per guidelines
                  </p>
                  <form class="forms-sample" action="{{route("update_user",$user->id)}}" method="POST">
                    @csrf

                    <div class="form-group">
                      <label for="exampleInputName1">Name</label>
                      <input type="text" class="form-control" id="exampleInputName1" name="username" value="{{$user->name}}" placeholder="Enter Name ...">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail3">Email address</label>
                      <input type="email" class="form-control" id="exampleInputEmail3" name="useremail" value="{{$user->email}}" placeholder="Enter Email ...">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Phone No. </label>
                      <input type="number" class="form-control" id="exampleInputPassword4" name="userphoneno" value="{{$user->phone}}" placeholder="Enter Phone Number ...">
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword4">Age </label>
                      <input type="number" class="form-control" id="exampleInputPassword4" name="userage" value="{{$user->age}}" placeholder="Enter Age ...">
                    </div>
                   
                    <div class="form-group">
                      <label for="exampleInputCity1">City</label>
                      <input type="text" class="form-control" id="exampleInputCity1" name="usercity" value="{{$user->city}}" placeholder="Enter Name of the City ...">
                    </div>

                    <div class="form-group">
                      <label for="exampleInputRole">Role</label>
                      <select class="form-control styled-select" name="userrole"
                          id="exampleInputRole">
                          <option disabled selected>Select the Role for user ---</option>
                          
                 
                    @foreach($allroles as $role)

                    <option value="{{$role->title}}" {{$user->role === $role->title ?"selected":""}}>{{$role->title}}</option>

                    @endforeach
                  </select>
                      <!-- Error Message for Status -->
                      <span class="error text-danger" id="statusError"></span>
                  </div>
                  
                    <button type="submit" class="btn btn-primary mr-2">Submit</button>
                    <button class="btn btn-light">Cancel</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <x-adminfooter />
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->