<x-adminheader />

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
        <div style="display: flex;justify-content:space-between;width:100%">
            <a style="all: unset;" href="{{ route('add_contact_view') }}">
                <button type="submit" class="btn w-100 mr-2 my-3"
                    style="background-color: #4B49AC; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">
                    Add Contact
                </button>
            </a>
          
                {{-- <a style="all: unset" href="{{route("restoredeletecontact")}}"> 
                    <button type="submit" class="btn w-100 mr-2 my-3"
                    style="background-color: #000000; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">
                    Restore Deleted Data
                </button>
            </a> --}}
          
            <div class="my-3">
                <form id="csvUploadForm" method="POST" enctype="multipart/form-data"
                action="{{ route('csvupload') }}">
                @csrf
                <div class="input-group mb-3">
                    <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".csv"
                    required style="height:38px;margin-top:4px">
                    <button class="btn btn-primary" type="submit" id="uploadBtn"
                    style="background-color: #4B49AC;color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">Upload .csv</button>
                </div>
            </form>
        </div>
        
        <!-- Import Form -->
        <div class="my-3">
        <form id="csvUploadForm" method="POST" enctype="multipart/form-data" action="{{ route('contacts.import') }}">
            @csrf
            <div class="input-group mb-3">
                <input type="file" class="form-control" id="csvFile" name="csvFile" accept=".xlsx,.csv" required style="height:38px;margin-top:4px">
                <button class="btn btn-primary" type="submit" id="uploadBtn"
                    style="background-color: #4B49AC;color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">Upload .xlsx </button>
            </div>
        </form>
            </div>


        </div>





        <!-- Card structure for the DataTable -->
        <div class="card shadow-lg" style="display:flex">
            <div
                style="background: #4B49AC; color: #ffffff; font-weight: 600; font-size: 1.4rem; text-align: center; margin: 0; border-radius: 4px;">
                <h5 style="margin: 0; font-size: 1.6rem; line-height: 1.5;">
                    Contact Data
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
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone Number</th>
                                <th>City</th>
                                <th>Country</th>
                                <th>Created At</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">

    <!-- Toastr JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>


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
                    url: '{{ route('contacts.index') }}',
                    type: 'GET',
                    data: function(d) {
                        d.role = $('#rolefilter').val(); // Add the selected role filter to the request
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        orderable: false, // Disable ordering for this column
                        searchable: false // Disable searching for this column
                    },
                    {
                        data: 'name', // Name column
                        name: 'name'
                    },
                    {
                        data: 'email', // Email column
                        name: 'email'
                    },
                    {
                        data: 'phoneno', // Phone number column
                        name: 'phoneno'
                    },

                    {
                        data: 'city',
                        name: 'city'
                    },
                    {
                        data: 'country',
                        name: 'country'
                    },

                    {
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

            $('#rolefilter').on('change', function() {
                table.ajax.reload(); // Reload the table with the new filter
            });


            // Disable row reordering when a button is pressed
            $('table').on('mousedown', 'button', function(e) {
                table.rowReorder.disable();
            });

            // Re-enable row reordering when the button press ends
            $('table').on('mouseup', 'button', function(e) {
                table.rowReorder.enable();
            });

            // Handle Delete Button Click
            $('table').on('click', '.delete-contact', function() {
                const contactId = $(this).data('id'); // Get contact ID from data attribute

                // Confirm if contact wants to delete
                if (contactId) {
                    if (true) {
                        $.ajax({
                            url: `{{ url('contacts/delete') }}/${contactId}`, // Delete URL
                            method: 'DELETE',
                            data: {
                                _token: '{{ csrf_token() }}', // CSRF token for security
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    table.ajax.reload(null,
                                        false); // Reload table without resetting pagination
                                } else {
                                    alert(response.message); // Show error message
                                }
                            },
                            error: function(error) {
                                alert('Something went wrong !!'); // Show error if AJAX fails
                            },
                        });
                    }
                }
            });





            // Edit contact Functionality
            const editablecolumns = [1, 2, 3, 4]; // Columns that are editable
            let currentEditableRow = null;

            // Handle Edit Button Click
            $('table').on('click', '.edit-contact', function() {
                const contactId = $(this).data('id'); // Get contact ID
                if (contactId) {
                    window.location.href = `{{ url('addcontact') }}/${contactId}/edit`;
                }
            });

            // Make the current row editable
            function makeEditableRow(currentRow) {
                currentRow.find('td').each(function(index) {
                    const currentCell = $(this);
                    const currentText = currentCell.text().trim();

                    if (editablecolumns.includes(index)) {
                        currentCell.html(
                            `<input type="text" class="form-control editable-input" value="${currentText}">`
                        ); // Make cells editable by replacing text with input
                    }
                });
            }

            // Reset the editable row back to a non-editable state
            function resetEditableRow(currentEditableRow) {
                currentEditableRow.find('td').each(function(index) {
                    const currentCell = $(this);

                    if (editablecolumns.includes(index)) {
                        const currentValue = currentCell.find('input').val();
                        currentCell.html(`${currentValue}`); // Replace input with the updated value
                    }
                });

                const contactId = currentEditableRow.find('.btn-update').data('id');

                currentEditableRow.find('td:last').html(`
                <button class="btn btn-success btn-sm edit-contact" data-id="${contactId}">Edit</button>
                <button class="btn btn-danger btn-sm delete-contact" data-id="${contactId}">Delete</button>
            `); // Restore action buttons

                currentEditableRow = null; // Clear the current editable row
            }

            // Handle the Update button click
            $('table').on('click', '.btn-update', function() {
                const contactId = $(this).data('id'); // Get contact ID
                const currentRow = $(this).closest('tr'); // Get the current row
                const updatedcontactData = {}; // Store updated data

                // Collect updated data from input fields
                currentRow.find('td').each(function(index) {
                    if (editablecolumns.includes(index)) {
                        const inputValue = $(this).find('input').val();

                        if (index === 1) updatedcontactData.name = inputValue;
                        if (index === 2) updatedcontactData.email = inputValue;
                        if (index === 3) updatedcontactData.phone = inputValue;
                        if (index === 4) updatedcontactData.city = inputValue;
                        if (index === 5) updatedcontactData.country = inputValue;
                    }
                });

                // Send the updated data to the server via AJAX
                // $.ajax({
                //    
                //     type: 'POST',
                //     data: {
                //         _method: "POST",
                //         id: contactId,
                //         name: updatedcontactData.name,
                //         email: updatedcontactData.email,
                //         phoneno: updatedcontactData.phoneno,
                //         city: updatedcontactData.city,
                //         _token: "{{ csrf_token() }}"
                //     },
                //     success: function(response) {
                //         if (response.status === 'success') {
                //             table.ajax.reload(null,
                //             false); // Reload table without resetting pagination
                //             table.rowReorder.enable(); // Re-enable row reordering
                //             alert('contact updated successfully!'); // Show success message
                //         } else {
                //             alert(response.message ||
                //             'Failed to update contact.'); // Show error message
                //         }
                //     },
                //     error: function(error) {
                //         console.error(error);
                //         alert(
                //         'Error occurred while updating the contact.'); // Show error if AJAX fails
                //     }
                // });

                // // Reset the row regardless of success or failure
                // resetEditableRow(currentRow);
                // currentEditableRow = null; // Clear the current editable row
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