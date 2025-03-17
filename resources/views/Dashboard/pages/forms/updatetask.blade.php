<x-adminheader />
@extends('Dashboard.pages.forms.select2')
<div class="container-fluid page-body-wrapper" style="display: contents">
    <div class="main-panel">
        <div class="content-wrapper">
            <div class="row">
                <div class="col-8 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title">Update Task</h4>
                            <p class="card-description">Update the details of the task as needed.</p>
                            <form class="forms-sample" id="updateTaskForm"
                                action="{{ route('update_task', $task->id) }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label for="taskName">Task Name</label>
                                    <input type="text" class="form-control" id="taskName" name="taskname"
                                        value="{{ $task->name }}" placeholder="Enter Task Name ...">
                                    <span class="error text-danger" id="taskNameError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="taskDescription">Description</label>
                                    <textarea class="form-control" id="taskDescription" name="taskdescription" placeholder="Enter Task Description ...">{{ $task->description }}</textarea>
                                    <span class="error text-danger" id="taskDescriptionError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="dueDate">Due Date</label>
                                    <input type="date" class="form-control" id="dueDate" name="duedate"
                                        value="{{ $task->due_date }}">
                                    <span class="error text-danger" id="dueDateError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="taskPriority">Priority</label>
                                    <select class="form-control" id="taskPriority" name="priority">
                                        @foreach (\App\Enums\TaskPriority::cases() as $priority)
                                            <option value="{{ $priority->value }}"
                                                {{ $task->priority == $priority->value ? 'selected' : '' }}>
                                                {{ $priority->value }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <span class="error text-danger" id="priorityError"></span>
                                </div>
                                <div class="form-group">
                                    <label for="assignee">Assignee(s)</label>
                                    <select class="form-control select2" id="assignee" name="assignee[]" multiple="multiple">
                                        <option disabled>Select the Assignee ---</option>
                                        @foreach ($users as $user)
                                            <option value="{{ $user->id }}" 
                                                {{ $task->users->pluck('id')->contains($user->id) ? "selected" : "" }}>
                                                {{ $user->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    

                                    <span class="error text-danger" id="assigneeError"></span>
                                </div>
                                <button type="submit" class="btn btn-primary mr-2"
                                    style="width: 25%; font-size:16px">Update</button>
                                <a href="{{ route('managetask') }}" class="btn btn-light">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-adminfooter />
    </div>
</div>

<script>
    $(document).ready(function() {
        $('#assignee').select2();
        console.log('Select2 Initialized:', $('#assignee').data('select2'));
        $('#updateTaskForm').on('submit', function(e) {
            e.preventDefault();
            $('.error').text('');
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

            // Assignee validation
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
