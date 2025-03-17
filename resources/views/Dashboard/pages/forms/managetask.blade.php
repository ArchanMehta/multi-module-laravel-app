<x-adminheader />
@include('Dashboard.pages.forms.select2')

<!DOCTYPE html>
<html lang="en">
    
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
        
        <link rel="stylesheet" href="https://cdn.datatables.net/2.1.8/css/dataTables.dataTables.css" />
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    <script src="https://cdn.datatables.net/2.1.8/js/dataTables.js"></script>
    
    <!-- Toastr CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    
    <script>
        $(document).ready(function () {
            const table = $('.datatable').DataTable({
                serverSide: true,
                processing: true,
                ajax: {
                    url: "{{ route('tasks.index') }}",
                },
                columns: [
                    { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                    { data: 'name', name: 'name' },
                    { data: 'description', name: 'description' },
                    { data: 'due_date', name: 'due_date' },
                    { data: 'priority', name: 'priority' },
                    { data: 'assigned_users', name: 'assigned_users' },
                    { data: 'created_by', name: 'created_by' },
                    
                    { data: 'action', name: 'action', orderable: false, searchable: false }
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
            $('table').on('click', '.delete-task', function() {
                const taskId = $(this).data('id'); // Get task ID from data attribute
                
                // Confirm if task wants to delete
                if (taskId) {
                    if (true) {
                        $.ajax({
                            url: `{{ url('tasks/delete') }}/${taskId}`, // Delete URL
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
            
            
            
            
            
            // Edit task Functionality
            const editablecolumns = [1, 2, 3, 4]; // Columns that are editable
            let currentEditableRow = null;

            // Handle Edit Button Click
            $('table').on('click', '.edit-task', function() {
                const taskId = $(this).data('id'); // Get task ID
                if (taskId) {
                    window.location.href = `{{ url('addtask') }}/${taskId}/edit`;
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
                
                const taskId = currentEditableRow.find('.btn-update').data('id');
                
                currentEditableRow.find('td:last').html(`
                <button class="btn btn-success btn-sm edit-task" data-id="${taskId}">Edit</button>
                <button class="btn btn-danger btn-sm delete-task" data-id="${taskId}">Delete</button>
                `); // Restore action buttons
                
                currentEditableRow = null; // Clear the current editable row
            }
            
            // Handle the Update button click
            $('table').on('click', '.btn-update', function() {
                const taskId = $(this).data('id'); // Get task ID
                const currentRow = $(this).closest('tr'); // Get the current row
                const updatedtaskData = {}; // Store updated data
                
                // Collect updated data from input fields
                currentRow.find('td').each(function(index) {
                    if (editablecolumns.includes(index)) {
                        const inputValue = $(this).find('input').val();
                        
                        if (index === 1) updatedtaskData.name = inputValue;
                        if (index === 2) updatedtaskData.description = inputValue;
                        if (index === 3) updatedtaskData.due_date = inputValue;
                        if (index === 4) updatedtaskData.priority = inputValue;
                        if (index === 5) updatedtaskData.assigned_users = inputValue;
                    }
                });
                
                // Send the updated data to the server via AJAX
                // $.ajax({
                    //    
                    //     type: 'POST',
                    //     data: {
                        //         _method: "POST",
                //         id: taskId,
                //         name: updatedtaskData.name,
                //         email: updatedtaskData.email,
                //         phoneno: updatedtaskData.phoneno,
                //         city: updatedtaskData.city,
                //         _token: "{{ csrf_token() }}"
                //     },
                //     success: function(response) {
                //         if (response.status === 'success') {
                //             table.ajax.reload(null,
                //             false); // Reload table without resetting pagination
                //             table.rowReorder.enable(); // Re-enable row reordering
                //             alert('task updated successfully!'); // Show success message
                //         } else {
                    //             alert(response.message ||
                //             'Failed to update task.'); // Show error message
                //         }
                //     },
                //     error: function(error) {
                    //         console.error(error);
                    //         alert(
                        //         'Error occurred while updating the task.'); // Show error if AJAX fails
                        //     }
                        // });
                        
                        // // Reset the row regardless of success or failure
                        // resetEditableRow(currentRow);
                        // currentEditableRow = null; // Clear the current editable row
                    });
        });
        </script>
</head>

<body style="background-color:#F4F6FF;">
    <div class="container py-5 px-5">
        <div class="d-flex justify-content-between">
            <a href="{{ route('add_task_view') }}">
                <button type="button" class="btn btn-primary my-3"  style="background-color: #4B49AC; color: white; border: none; padding: 10px 20px; font-size: 16px; border-radius: 5px; cursor: pointer;">Add Task</button>
            </a>
        </div>
        
        <div class="card shadow-lg">
            <div class="card-header text-center" style="background-color: #4B49AC; color: white;">
                <h5>Manage Task Admin</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped datatable">
                    <thead>
                        <tr>
                            <th>Sr No.</th>
                            <th>Task Name</th>
                            <th>Description</th>
                            <th>Due Date</th>
                            <th>Priority</th>
                            <th>Assigned Users</th>
                            <th>Created By</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
  
</body>

</html>

