<x-adminheader />
<script src="{{ asset('dashboard/vendors/js/vendor.bundle.base.js') }}"></script>

<style>
    /* Custom Scrollbar Styles */
    .custom-scrollbar {
        overflow-y: auto;
        max-height: 300px;
    }

    /* Webkit Browsers */
    .custom-scrollbar::-webkit-scrollbar {
        width: 8px;
    }

    .custom-scrollbar::-webkit-scrollbar-track {
        background: #E7E9F2;
        border-radius: 4px;
    }

    .custom-scrollbar::-webkit-scrollbar-thumb {
        background-color: #4b49ac;
        border-radius: 4px;
        border: 2px solid #E7E9F2;
    }

    footer.footer {
        top: 120%;
    }
</style>
<div class="container-fluid page-body-wrapper" style="display: contents;">
    <div class="main-panel">
        <div class="content-wrapper" style="overflow:auto;height:720px">
            <div class="row">
                <!-- Left Column: Task Details -->
                <div class="col-lg-7 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <h4 class="card-title" style="color: rgb(75, 73, 172);">Task Details</h4>
                            <p class="card-description">
                                View the task details and manage its status.
                            </p>

                            <!-- Task Details -->
                            <div class="form-group">
                                <label for="taskName" style="color: rgb(75, 73, 172);">Task Name:</label>
                                <span id="taskName"
                                    style="background-color: #E7E9F2; padding: 8px; border-radius: 4px;">
                                    {{ $task->name }}
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="assignee" style="color: rgb(75, 73, 172);">Assignee:</label>
                                <span id="assignee"
                                    style="background-color: #E7E9F2; padding: 8px; border-radius: 4px;">
                                    {{ $task->users->pluck('name')->join(', ') }}
                                </span>
                            </div>

                            <div class="form-group">
                                <label for="dueDate" style="color: rgb(75, 73, 172);">Due Date:</label>
                                <span id="dueDate"
                                    style="background-color: #E7E9F2; padding: 8px; border-radius: 4px;">
                                    {{ $task->due_date }}
                                </span>
                            </div>

                            <!-- Task Status -->
                            <div class="form-group">
                                <label for="status" style="color: rgb(75, 73, 172); font-weight: bold;">Task Status:</label>
                                <div id="status">
                                    @foreach ($task->users as $user)
                                        <div style="margin-bottom: 12px; background-color: #E7E9F2; padding: 12px; border-radius: 6px;">
                                            <strong style="color: rgb(75, 73, 172);">{{ $user->name }}:</strong>
                                            @if (auth()->user()->id == $user->id) 
                                                <form action="{{ route('tasks.updateStatus', $task->id) }}" method="POST" style="display: inline-block;">
                                                    @csrf
                                                    @method('PATCH')
                                                    <div style="display: flex; align-items: center; gap: 10px;">
                                                        <select name="status" style="background-color: #E7E9F2; padding: 8px 12px; border-radius: 4px;">
                                                            @foreach (\App\Enums\TaskStatus::cases() as $status)
                                                                <option value="{{ $status->value }}" 
                                                                    {{ $user->pivot->status == $status->value ? 'selected' : '' }}>
                                                                    {{ $status->value }}
                                                                </option>
                                                            @endforeach
                                                        </select>
                                                        <button type="submit" class="btn btn-primary" style="background-color: rgb(75, 73, 172);">Update Status</button>
                                                    </div>
                                                </form>
                                            @else
                                                <span style="color: #555;">
                                                    {{ \App\Enums\TaskStatus::from($user->pivot->status)->value }}
                                                </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Comments and Post Comment -->
                <div class="col-lg-5 grid-margin stretch-card">
                    <div class="card shadow-lg">
                        <div class="card-body">
                            <!-- Comments Section -->
                            <h4 class="card-title" style="color: rgb(75, 73, 172);">Comments</h4>
                            <div id="comments" class="custom-scrollbar"
                                style="background-color: #e7e9f2df; padding: 8px; border-radius: 4px;">
                                @forelse ($task->comments as $comment)
                                    <div style="margin-bottom: 10px;">
                                        <strong style="color: rgb(75, 73, 172);">{{ $comment->user->name }}:</strong>
                                        <p>{{ $comment->content }}</p>
                                        <small style="color: rgb(141, 141, 141);font-weight:500">{{ $comment->created_at->diffForHumans() }}</small>
                                        <hr>
                                    </div>
                                @empty
                                    <p>No comments yet</p>
                                @endforelse
                            </div>

                            <!-- Add Comment Section -->
                            @if (auth()->user())
                                <form action="{{ route('tasks.addComment', $task->id) }}" method="POST">
                                    @csrf
                                    <div class="form-group mt-3">
                                        <label for="newComment" style="color: rgb(75, 73, 172);">Add Comment:</label>
                                        <textarea name="content" id="newComment" class="form-control" rows="3" required></textarea>
                                    </div>
                                    <button type="submit" class="btn btn-primary mt-2"
                                        style="background-color: rgb(75, 73, 172);">Post Comment</button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
