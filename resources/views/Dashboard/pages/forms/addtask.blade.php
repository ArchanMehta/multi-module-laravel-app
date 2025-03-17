<x-adminheader />
@extends('Dashboard.pages.forms.select2')
<div class="container-fluid page-body-wrapper" style="display: contents">
    <div class="main-panel">
        <div class="content-wrapper" style="height: 825px">
            <div class="row">
                <div class  ="col-8 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title">Add/Update Task</h4>
                            <p class="card-description">
                                Fill the form as per guidelines to create or update a task.
                            </p>
                            <form class="forms-sample" id="taskForm" action="{{ route('add_task_data') }}"
                                method="POST">
                                @csrf
                                <div class="form-group">
                                     <label for="taskName">Task Name</label>
                                            <input type="text" class="form-control" id="taskName" name="taskname"
                                        placeholder="Enter Task Name ...">
                                    <span class="error text-danger" id="taskNameError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="taskDescription">Description</label>
                                    <textarea class="form-control" id="taskDescription" name="taskdescription" placeholder="Enter Task Description ..."></textarea>
                                    <span class="error text-danger" id="taskDescriptionError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="dueDate">Due Date</label>
                                    <input type="date" class="form-control" id="dueDate" name="duedate">
                                    <span class="error text-danger" id="dueDateError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="taskPriority">Priority</label>
                                    <select class="form-control" id="taskPriority" name="priority">
                                        @foreach (\App\Enums\TaskPriority::cases() as $priority)
                                            <option value="{{ $priority->value }}"
                                                {{ old('priority') == $priority->value ? 'selected' : '' }}>
                                                {{ $priority->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger" id="priorityError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="assignee">Assignee(s)</label>
                                    <select class="form-control select2" id="assignee" name="assignee[]"
                                        multiple="multiple">
                                        <option disabled>Select the Assignee ---</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}"
                                                {{ in_array($user->id, old('assignee', [])) ? 'selected' : '' }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <span class="error text-danger" id="assigneeError"></span>
                                </div>


                                <button type="submit" class="btn btn-primary mr-2"
                                    style="width: 25%;font-size:16px">Submit</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>






        <script>
            $(document).ready(function() {
                // Initialize Select2 for multiple assignees
                $('#assignee').select2();

                $('#taskForm').on('submit', function(e) {

                    $('.error').text(''); // Clear all error messages
                    let isValid = true;

                    // Task Name validation
                    const taskName = $('#taskName').val().trim();
                    if (taskName.length < 3) {
                        isValid = false;
                        $('#taskNameError').text('Task name must be at least 3 characters.');
                    }

                    // Task Description validation
                    const taskDescription = $('#taskDescription').val().trim();
                    if (taskDescription.length < 5) {
                        isValid = false;
                        $('#taskDescriptionError').text('Description must be at least 5 characters.');
                    }

                    // Due Date validation
                    const dueDate = $('#dueDate').val().trim();
                    if (!dueDate) {
                        isValid = false;
                        $('#dueDateError').text('Due date is required.');
                    }

                    // Priority validation
                    const priority = $('#taskPriority').val();
                    if (!priority) {
                        isValid = false;
                        $('#priorityError').text('Please select a priority.');
                    }

                    // Assignee validation (check if at least one assignee is selected)
                    const assignee = $('#assignee').val();
                    if (!assignee || assignee.length === 0) {
                        isValid = false;
                        $('#assigneeError').text('Please select at least one assignee.');
                    }

                    // If valid, submit the form
                    if (isValid) {
                        this.submit();
                    }
                });
            });
        </script>


        <x-adminfooter />
    </div>
</div>
