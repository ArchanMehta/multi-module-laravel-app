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
                            <h4 class="card-title">Add/Update leave</h4>
                            <p class="card-description">
                                Fill the form as per guidelines
                            </p>
                            <form class="forms-sample" action="{{ route('update_leave', $leave->id) }}" method="POST">
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
                                        <input type="date" class="form-control me-2" id="startDate"
                                            name="leavestartdate" required value="{{ $leave->start_date }}">
                                        <select class="form-control" name="leavestartdaytype" required>
                                            <option value="" disabled selected>Select Leave Type</option>
                                            <option value="full_day"
                                                {{ $leave->start_day_type == 'full_day' ? 'selected' : '' }}>Full Day
                                            </option>
                                            <option value="first_half"
                                                {{ $leave->start_day_type == 'first_half' ? 'selected' : '' }}>1st Half
                                            </option>
                                            <option value="second_half"
                                                {{ $leave->start_day_type == 'second_half' ? 'selected' : '' }}>2nd Half
                                            </option>
                                        </select>
                                    </div>
                                    <span class="error text-danger" id="startDateError"></span>
                                </div>


                                <!-- End Date -->
                                <div class="form-group">
                                    <label for="endDate">End Date</label>
                                    <div class="d-flex">
                                        <input type="date" class="form-control me-2" id="endDate"
                                            name="leaveenddate" required value="{{ $leave->end_date }}">
                                        <select class="form-control" name="leaveenddaytype" required>
                                            <option value="" disabled selected>Select Leave Type</option>
                                            <option value="full_day"
                                                {{ $leave->end_day_type == 'full_day' ? 'selected' : '' }}>Full Day
                                            </option>
                                            <option value="first_half"
                                                {{ $leave->end_day_type == 'first_half' ? 'selected' : '' }}>1st Half
                                            </option>
                                            <option value="second_half"
                                                {{ $leave->end_day_type == 'second_half' ? 'selected' : '' }}>2nd Half
                                            </option>
                                        </select>
                                    </div>
                                    <span class="error text-danger" id="endDateError"></span>
                                </div>

                                <!-- Reason for Leave -->
                                <div class="form-group">
                                    <label for="reason">Reason</label>
                                    <textarea class="form-control" id="reason" name="leavereason" rows="3"
                                        placeholder="Provide a reason for the leave...">{{ $leave->reason }}</textarea>
                                    <span class="error text-danger" id="reasonError"></span>
                                </div>


                                <button type="submit" class="btn btn-primary mr-2">Submit</button>
                                <button type="reset" class="btn btn-light">Cancel</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <x-adminfooter />
        </div>
        <!-- content-wrapper ends -->
        <!-- partial:../../partials/_footer.html -->
