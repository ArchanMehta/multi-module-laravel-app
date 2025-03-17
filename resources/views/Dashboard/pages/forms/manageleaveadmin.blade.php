<x-adminheader title="Manage leaveadmin" />

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <!-- Include Bootstrap CSS for styling -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Include Bootstrap JS for functionality -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>

    <!-- Include DataTables CSS for styling the table -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <!-- Include RowReorder CSS for drag-and-drop functionality -->
    <link href="https://cdn.datatables.net/rowreorder/1.5.0/css/rowReorder.bootstrap5.min.css" rel="stylesheet">
    <!-- Include ColReorder CSS for column reordering -->
    <link href="https://cdn.datatables.net/colreorder/2.0.4/css/colReorder.bootstrap5.min.css" rel="stylesheet">
    <script src="{{ asset('dashboard/vendors/js/vendor.bundle.base.js') }}"></script>
</head>

<body style="background-color:#F4F6FF;">
    <div class="container py-5 px-5" style="background-color:#F4F6FF;margin:0;">


        <!-- Card structure for the DataTable -->
        <div class="card shadow-lg" style="display:flex">
            <div
                style="background: #4B49AC; color: #ffffff; font-weight: 600; font-size: 1.4rem; text-align: center; margin: 0; border-radius: 4px;">
                <h5 style="margin: 0; font-size: 1.6rem; line-height: 1.5;">
                    Leave Admin Data
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <!-- DataTable will be placed here -->
                    <table class="table table-striped datatable">
                        <thead>
                            <tr>
                                <!-- Table Headers -->
                                <th>Sr No.</th>
                                <th>Start Date</th>
                                <th>Start Day Type</th>
                                <th>End Date</th>
                                <th>End Day Type</th>
                                <th>Reason</th>
                                <th>Status</th>
                                @if (auth()->user()->hasRole('Admin'))
                                    <th>Applied By</th> <!-- Only visible to admin -->
                                @endif
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>



    <!-- jQuery for DataTable and AJAX functionality -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <!-- Popper.js for Bootstrap functionality -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>

    <!-- Bootstrap JS for interactivity -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <!-- DataTables JS for table functionality -->
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>

    <!-- RowReorder JS for drag-and-drop row functionality -->
    <script src="https://cdn.datatables.net/rowreorder/1.5.0/js/dataTables.rowReorder.min.js"></script>

    <!-- ColReorder JS for column reordering functionality -->
    <script src="https://cdn.datatables.net/colreorder/2.0.4/js/dataTables.colReorder.min.js"></script>


    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>



    <script>
        // Check for a success message in the session
        @if (session('success'))
            toastr.success('{{ session('success') }}', 'Success', {
                closeButton: true,
                progressBar: true,
                timeOut: 3000
            });
        @endif
    </script>

    <script>
        // Initialize the DataTable
        $(document).ready(function() {
            const table = $('.datatable').DataTable({
                colReorder: true, // Enable column reordering
                rowReorder: {
                    update: false, // Disable auto-update of row order
                    selector: 'tr' // Enable row reordering on 'tr' elements
                },
                serverSide: true, // Enable server-side processing
                processing: true, // Show processing indicator
                ajax: {
                    // Specify the URL for AJAX data fetching
                    url: "http://localhost:8000/leavesss",
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false, // Disable ordering for this column
                        searchable: false // Disable searching for this column
                    },
                    {
                        data: 'start_date', // Name column
                        name: 'start_date'
                    },
                    {
                        data: 'start_day_type', // Email column
                        name: 'start_day_type'
                    },
                    {
                        data: 'end_date', // Email column
                        name: 'end_date'
                    },
                    {
                        data: 'end_day_type', // Email column
                        name: 'end_day_type'
                    },
                    {
                        data: 'reason', // Email column
                        name: 'reason'
                    },

                    {
                        data: 'status', // Email column
                        name: 'status'
                    },
                    @if (auth()->user()->hasRole('Admin'))
                        {
                            data: 'applied_by',
                            name: 'applied_by'
                        }, // Visible only to admin
                    @endif {
                        data: 'created_at', // Created At column
                        name: 'created_at'
                    },
                    {
                        data: 'action', // Action buttons column (edit, delete)
                        name: 'action',
                        orderable: false, // Disable ordering for this column
                        searchable: false // Disable searching for this column
                    },
                ],
            });

            // Disable row reordering when a button is pressed
            $('table').on('mousedown', 'button', function(e) {
                table.rowReorder.disable();
            });

            // Re-enable row reordering when the button press ends
            $('table').on('mouseup', 'button', function(e) {
                table.rowReorder.enable();
            });


            // Handle Approve Button Click
            $('table').on('click', '.approve-leave', function() {
                const leaveId = $(this).data('id'); // Get leave ID

                // Send AJAX request to approve the leave
                $.ajax({
                    url: `{{ url('leaves/approve') }}/${leaveId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            table.ajax.reload(null,
                                false); // Reload the table without resetting pagination
                            toastr.success(response.message); // Display success message
                        } else {
                            toastr.error(response.message); // Display error message
                        }
                    },
                    error: function() {
                        toastr.error(
                            'Something went wrong!'); // Show error message if AJAX fails
                    }
                });
            });

            // Handle Reject Button Click
            $('table').on('click', '.reject-leave', function() {
                const leaveId = $(this).data('id'); // Get leave ID

                // Send AJAX request to reject the leave
                $.ajax({
                    url: `{{ url('leaves/reject') }}/${leaveId}`,
                    method: 'POST',
                    data: {
                        _token: '{{ csrf_token() }}', // CSRF token for security
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            table.ajax.reload(null,
                                false); // Reload the table without resetting pagination
                            toastr.success(response.message); // Display success message
                        } else {
                            toastr.error(response.message); // Display error message
                        }
                    },
                    error: function() {
                        toastr.error(
                            'Something went wrong!'); // Show error message if AJAX fails
                    }
                });
            });

        });
    </script>

    <!-- partial -->
    </div>
    <footer class="footer" style="margin-left: 247px">

        <div class="d-sm-flex justify-content-center justify-content-sm-between">
            <span class="text-muted text-center text-sm-left d-block ">Copyright © 2024. All rights reserved.</span>

        </div>

    </footer>
    <!-- main-panel ends -->

    </div>
    <!-- page-body-wrapper ends -->
    </div>
    <!-- container-scroller -->


    <!-- Plugin js for this page -->
    <script src="{{ asset('dashboard/vendors/chart.js/Chart.min.js') }}"></script>


    <!-- End plugin js for this page -->
    <!-- inject:js -->
    <script src="{{ asset('dashboard/js/off-canvas.js') }}"></script>
    <script src="{{ asset('dashboard/js/hoverable-collapse.js') }}"></script>
    <script src="{{ asset('dashboard/js/template.js') }}"></script>
    <script src="{{ asset('dashboard/js/settings.js') }}"></script>
    <script src="{{ asset('dashboard/js/todolist.js') }}"></script>
    <!-- endinject -->
    <!-- Custom js for this page-->
    <script src="{{ asset('dashboard/js/dashboard.js') }}"></script>
    <script src="{{ asset('dashboard/js/Chart.roundedBarCharts.js') }}"></script>
    <!-- End custom js for this page-->
</body>

</html>
