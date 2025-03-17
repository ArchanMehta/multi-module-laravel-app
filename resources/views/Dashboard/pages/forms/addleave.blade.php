<x-adminheader />

<div class="container-fluid page-body-wrapper" style="display: contents">
    <div class="main-panel" style="height: 1050px">
        <div class="content-wrapper" >
            <div class="row">
                <div class="col-12 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title">Add/Update Leave Request</h4>
                            <p class="card-description">
                                Fill in the leave details below
                            </p>
                            <form class="forms-sample" id="leaveForm" action="{{ route('add_leave_data') }}" method="POST">
                                @csrf

                                <!-- User Name -->
                                <div class="form-group">
                                    <label for="userName">User Name</label>
                                    <input type="text" class="form-control" id="userName" name="username" 
                                        value="{{ auth()->user()->name }}" readonly>
                                </div>

                                <!-- Start Date -->
                                <div class="form-group">
                                    <label for="startDate">Start Date</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control me-2" id="startDate" name="leavestartdate" required>
                                        <select class="form-control" name="leavestartdaytype" required>
                                            <option value="" disabled selected>Select Leave Type</option>
                                            <option value="full_day">Full Day</option>
                                            <option value="first_half">1st Half</option>
                                            <option value="second_half">2nd Half</option>
                                        </select>
                                    </div>
                                    <span class="error text-danger" id="startDateError"></span>
                                </div>

                                
                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="endDate">End Date</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control me-2" id="endDate" name="leaveenddate" required>
                                        <select class="form-control" name="leaveenddaytype" required>
                                            <option value="" disabled selected>Select Leave Type</option>
                                            <option value="full_day">Full Day</option>
                                            <option value="first_half">1st Half</option>
                                            <option value="second_half">2nd Half</option>
                                        </select>
                                    </div>
                                    <span class="error text-danger" id="endDateError"></span>
                                </div>

                                <!-- Reason for Leave -->
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" id="reason" name="leavereason" rows="3" placeholder="Provide a reason for the leave..."></textarea>
                                    <span class="error text-danger" id="reasonError"></span>
                                </div>

                                <!-- Submit Button -->
                                <button type="submit" class="btn btn-primary mr-2" style="width: 25%;font-size:16px">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-adminfooter />
    </div>
</div>
