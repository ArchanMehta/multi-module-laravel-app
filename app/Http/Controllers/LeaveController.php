<?php

namespace App\Http\Controllers;

use App\Exports\UsersExport;
use App\Models\Leave;
use App\Models\User;
use App\Services\NotificationService;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Symfony\Component\HttpFoundation\StreamedResponse;
use Yajra\DataTables\Facades\DataTables;

class LeaveController extends Controller
{


    public function exportToCsv(Request $request)
    {
        // Fetch all leave requests with user relation
        $leaves = Leave::with('user')->get();

        // Create a streamed response to output the CSV file
        $response = new StreamedResponse(function () use ($leaves) {
            // Open output stream
            $handle = fopen('php://output', 'w');

            // Add the CSV headers
            fputcsv($handle, ['Leave ID', 'User ID', 'User Name', 'Start Date', 'End Date', 'Status', 'Created At']);

            // Loop through each leave and write it to the CSV file
            foreach ($leaves as $leave) {
                fputcsv($handle, [
                    $leave->id,
                    $leave->user_id,
                    $leave->user->name,
                    Carbon::parse($leave->start_date)->format('Y-m-d'),
                    Carbon::parse($leave->end_date)->format('Y-m-d'),
                    $leave->status,

                    Carbon::parse($leave->created_at)->format('Y-m-d H:i:s'),
                ]);
            }

            fclose($handle);
        });

        // Set headers to download the CSV file
        $response->headers->set('Content-Type', 'text/csv');
        $response->headers->set('Content-Disposition', 'attachment; filename="leave_requests.csv"');

        return $response;
    }

    public function exportExcel()
    {
        return Excel::download(new UsersExport, 'leaves.xlsx');
    }


    public function editleave(Request $request, String $id)
    {
        $leave = Leave::find($id);
        if ($leave->status === "Approved" || $leave->status === "Rejected") {
            return back();
        } else {

            session()->flash('success', 'leave updated successfully!');
            return view("Dashboard.pages.forms.updateleave", compact("leave"));
        }
    }

    public function addleavedata(Request $request)
    {
        $admin = User::where('role', 'admin')->first();

        $leave = Leave::create([
            'user_id' => Auth::user()->id,
            'start_date' => $request->leavestartdate,
            'start_day_type' => $request->leavestartdaytype,
            'end_date' => $request->leaveenddate,
            'end_day_type' => $request->leaveenddaytype,
            'reason' => $request->leavereason,


        ]);

        NotificationService::createNotification(
            auth()->id(),
            $admin->id,
            'leave',
            'Leave Application Submitted',
            "{$leave->user->name} has submitted a leave application.",
            "Leave Details: From {$leave->start_date} to {$leave->end_date}",
            $leave->id,
        );

        session()->flash('success', 'New leave has been added successfully!');

        return redirect()->route("manageleave");
    }


    public function approve($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave) {
            $leave->approved_by = Auth::user()->name;
            $leave->status = 'Approved';
            $leave->save();

            // Send notification to the user about the approval
            NotificationService::createNotification(
                auth()->id(), // Admin ID
                $leave->user_id, // User who requested leave
                'leave', // Notification type
                'Leave Approved', // Title
                'Your leave has been approved by ' . Auth::user()->name, // Message
                'Leave Details: ' . $leave->reason, // Description
                $leave->id,
            );

            session()->flash('success', 'Leave approved successfully!');
            return response()->json(['status' => 'success', 'message' => 'Leave approved successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Unable to approve leave!']);
    }


    public function reject($id)
    {
        $leave = Leave::findOrFail($id);

        if ($leave) {
            $leave->approved_by = "N/A";
            $leave->status = 'Rejected';
            $leave->save();

            NotificationService::createNotification(
                auth()->id(),
                $leave->user_id,
                'leave',
                'Leave Rejected',
                'Your leave has been rejected by ' . Auth::user()->name,
                'Leave Details: ' . $leave->reason,
                $leave->id,
            );

            session()->flash('success', 'Leave rejected successfully!');
            return response()->json(['status' => 'success', 'message' => 'Leave rejected successfully!']);
        }

        return response()->json(['status' => 'error', 'message' => 'Unable to reject leave!']);
    }


    public function adminindex(Request $request)
    {


        if ($request->ajax()) {
            $leaves = Leave::query();


            return DataTables::eloquent($leaves)


                ->addIndexColumn()
                ->addColumn('applied_by', function ($leave) {
                    return $leave->user->name; // Fetch user name dynamically
                })
                ->addColumn('created_at', function ($leaves) {
                    return Carbon::parse($leaves->created_at)->format('Y-m-d');
                })
                ->addColumn('action', function ($leaves) {
                    return '<button data-id="' . $leaves->id . '" class="btn btn-success btn-sm approve-leave" style="background-color: green; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer;">Approve</button>
                       <button data-id="' . $leaves->id . '" class="btn btn-danger btn-sm reject-leave" style="background-color: red; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; cursor: pointer;">Reject</button>';
                })


                ->rawColumns(['action'])
                ->make(true);
        }
    }



    public function index(Request $request)
    {
        if ($request->ajax()) {
            // Get the currently authenticated user
            $userId = auth()->id();

            // Filter leaves based on the authenticated user
            $leaves = Leave::where('user_id', $userId); // Assuming `user_id` field exists in `leaves` table

            return DataTables::eloquent($leaves)
                ->addIndexColumn()
                ->addColumn('created_at', function ($leaves) {
                    return Carbon::parse($leaves->created_at)->format('Y-m-d');
                })
                ->addColumn('action', function ($leaves) {
                    // Check if status is not 'Pending' and disable the button
                    $disabled = $leaves->status !== 'Pending' ? 'disabled' : '';
                    $cursorStyle = $leaves->status !== 'Pending' ? 'cursor: not-allowed;' : 'cursor: pointer;';

                    return '<button data-id="' . $leaves->id . '" class="btn btn-success btn-sm edit-leave" style="background-color: #374151; color: white; padding: 5px 10px; border-radius: 5px; font-size: 14px; border: none; ' . $cursorStyle . ' transition: background-color 0.3s;" ' . $disabled . '>
                                <img src="' . asset('dashboard/images/edit_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" alt="Edit">
                            </button>
                
                <button style="border-radius: 5px; " data-id="' . $leaves->id . '" class="btn btn-danger btn-sm delete-leave"><img src="' . asset('dashboard/images/delete_16dp_E8EAED_FILL0_wght400_GRAD0_opsz20.svg') . '" ></button>';
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('Dashboard.pages.forms.addleave');
    }


    public function destroy($id)
    {


        $leave = Leave::findOrFail($id);
        if ($leave) {

            $leave->delete();
            return response()->json(['status' => 'success', 'message' => 'leave deleted successfully']);
        }
        return response()->json(['status' => 'failed', 'message' => 'Unable to delete leave']);
    }


    public function update(Request $request)
    {
        try {
            $leave = Leave::findOrFail($request->id);
            if ($leave) {
                $leave->title = $request->leavetitle;
                $leave->status = $request->leavestatus;

                $leave->save();
                session()->flash('success', 'leave has been updated successfully!');
                return redirect()->route("manageleave");
            } else {
                return response()->json(['status' => 'error', 'message' => 'Unable to Find leave!!']);
            }
        } catch (Exception $e) {
            return response()->json(['status' => 'error', 'message' => 'Unable to Update leave - ' . $e->getMessage()]);
        }
    }
}
