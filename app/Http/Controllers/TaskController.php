<?php

namespace App\Http\Controllers;

use App\Events\TaskAssigned;
use App\Models\Task;
use App\Models\User;
use App\Notifications\NewMessageNotification;
use App\Services\NotificationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Yajra\DataTables\Facades\DataTables;

class TaskController extends Controller
{

    public function editTask($id)
    {
        $task = Task::with("users:id,name")->find($id);
        $users = User::all();
        // Fetch all users (or filter as needed)
        // return $task;
        return view('Dashboard.pages.forms.updatetask', compact('task', 'users'));
    }

    public function showTaskForm()
    {
        $users = User::all();
        return view('Dashboard.pages.forms.addtask', compact('users'));
    }


    public function addtaskdata(Request $request)
    {
        // Validate incoming data
        $validated = $request->validate([
            'taskname' => 'required|min:3',
            'taskdescription' => 'required|min:5',
            'duedate' => 'required|date',
            'priority' => 'required|in:High,Medium,Low',
            'assignee' => 'required|array', // Assignee should be an array
            'assignee.*' => 'exists:users,id', // Each assignee must exist in the users table
        ]);

        $task = Task::create([
            'name' => $request->taskname,
            'description' => $request->taskdescription,
            'due_date' => $request->duedate,
            'priority' => $request->priority,
            'created_by' => Auth::user()->name,
        ]);



        $task->users()->attach($request->assignee, ['assigned_at' => now()]);


        foreach ($request->assignee as $userId) {
            NotificationService::createNotification(
                auth()->id(),
                $userId,
                'task',
                'New Task Assigned',
                "Task Assigned: {$task->name}",
                "Task Details: {$task->description}",
                $task->id
            );
        }


        session()->flash('success', 'Task has been added successfully!');
        return redirect()->route('managetask');
    }

    public function index(Request $request)
    {
        $tasks = Task::with('users')->get();

        return DataTables::of($tasks)
            ->addIndexColumn()
            ->addColumn('assigned_users', function ($task) {
                return $task->users->pluck('name')->join(', ');
            })

            ->addColumn('action', function ($task) {
                // The "View" button with the task ID as a link to the View page
                return '
                    <a href="' . route('viewtask', $task->id) . '" class="btn btn-info btn-sm" style="padding: 5px 10px;border-radius: 15px;font-size: 16px;font-weight:500;border: none;cursor: pointer; filter: invert(100%) sepia(100%) saturate(500%) hue-rotate(180deg);">
                        <img width="50" height="50" src="https://img.icons8.com/fluency-systems-filled/96/visible.png" alt="visible"/>
                    </a>
                    <button data-id="' . $task->id . '" class="btn btn-success btn-sm edit-task">
                        <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" alt="Edit">
                    </button>
                    <button data-id="' . $task->id . '" class="btn btn-danger btn-sm delete-task">
                        <img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" alt="Delete">
                    </button>
                ';
            })
            ->make(true);
    }
    public function usertaskindex(Request $request)
    {
        $authUser = Auth::user();

        $tasks = Task::whereHas('users', function ($query) use ($authUser) {
            $query->where('users.id', $authUser->id);
        })->with('users')->get();

        return DataTables::of($tasks)
            ->addIndexColumn()
            ->addColumn('assigned_users', function ($task) {
                return $task->users->pluck('name')->join(', ');
            })
            ->addColumn('action', function ($task) {
                return '
                    <a href="' . route('viewtask', $task->id) . '" class="btn btn-info btn-sm" style="padding: 5px 10px;border-radius: 15px;font-size: 16px;font-weight:500;border: none;cursor: pointer; filter: invert(100%) sepia(100%) saturate(500%) hue-rotate(180deg);">
                        <img width="50" height="50" src="https://img.icons8.com/fluency-systems-filled/96/visible.png" alt="visible"/>
                    </a>';
            })
            ->make(true);
    }




    public function destroy($id)
    {
        $task = Task::findOrFail($id);
        if ($task) {
            $task->delete();
            return response()->json(['status' => 'success', 'message' => 'Task deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to delete task']);
    }




    public function viewusertask($id, Request $request)
    {
        if ($request->has('notification_id')) {

            $notification = auth()->user()->notifications()->find($request->notification_id);

            if ($notification) {
                $notification->markAsRead();
            }
        }


        $task = Task::findOrFail($id);


        return view('Dashboard.pages.forms.viewtask', compact('task'));
    }




    public function update(Request $request)
    {

        try {
            $task = Task::findOrFail($request->id);

            if ($task) {
                // Update basic task fields
                $task->name = $request->taskname;
                $task->description = $request->taskdescription;
                $task->due_date = $request->duedate;
                $task->priority = $request->priority;

                // Save task updates
                $task->save();

                // Update the many-to-many relationship for assignees
                if ($request->has('assignee')) {
                    $task->users()->sync($request->assignee); // Sync the assignees
                }

                return redirect()->route("managetask")->with(['status' => 'success', 'message' => 'Task updated successfully, including assignees.']);
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to find task!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to update task - ' . $e->getMessage()]);
        }
    }


    public function viewcomment($id)
    {
        $task = Task::with(['users', 'comments.user'])->findOrFail($id);
        // dd($task);
        return view('Dashboard.pages.forms.viewtask', compact('task'));
    }

    public function addComment(Request $request, $id)
    {
        $task = Task::findOrFail($id);

        // Check if the user is authorized to comment
        if (!auth()->user() && !$task->users->contains(auth()->id())) {
            abort(403, 'Unauthorized action.');
        }

        $request->validate(['content' => 'required|string']);

        $task->comments()->create([
            'user_id' => auth()->id(),
            'content' => $request->input('content'),
        ]);

        return redirect()->route('taskscomment.view', $id)->with('success', 'Comment added successfully!');
    }

    public function updateStatus(Request $request, Task $task)
    {
        // Ensure the task status is updated only for the authenticated user
        $request->validate([
            'status' => 'required|in:' . implode(',', array_map(fn($status) => $status->value, \App\Enums\TaskStatus::cases())),
        ]);

        $task->users()->updateExistingPivot(auth()->id(), [
            'status' => $request->status,
        ]);

        return back()->with('status', 'Task status updated successfully!');
    }
}
