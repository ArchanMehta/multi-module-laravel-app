<?php

namespace App\Http\Controllers;

use App\Models\Clockinout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClockInOutController extends Controller
{


    public function showAllLogs()
    {
        // Fetch all clock logs for the authenticated user
        $clockData = Clockinout::where('user_id', Auth::id())
            ->orderBy('date', 'desc') // Sort by most recent date
            ->get();

        // Pass the logs to the view
        return view('Dashboard.pages.forms.alllogs', compact('clockData'));
    }


    public function showWeeklyLogs()
    {
        // Fetch the clock data for the current week
        $clockData = Clockinout::where('user_id', Auth::id())
            ->whereBetween('date', [now()->startOfWeek(), now()->endOfWeek()])
            ->get();

        // Pass the clock data to the view
        return view('Dashboard.pages.forms.weeklylogs', compact('clockData'));
    }


    public function clockIn(Request $request)
    {
        $user = Auth::user();

        // Validate incoming data
        $request->validate([
            'clock_in' => 'required|date_format:H:i',
            'date' => 'required|date_format:Y-m-d',
            'day' => 'required|string', // Added validation for day
        ]);

        // Check if the user has already clocked in today
        $existingClockIn = Clockinout::where('user_id', $user->id)
            ->whereDate('date', $request->date) // Match the current date
            ->first();

        if ($existingClockIn) {
            return response()->json(['message' => 'You have already clocked in today.']);
        }

        // Store clock-in time, including the day of the week
        Clockinout::create([
            'user_id' => $user->id,
            'clock_in' => $request->clock_in,
            'date' => $request->date,
            'day' => $request->day, // Store the day of the week in the database
        ]);


        return response()->json(['message' => 'Clocked in successfully!']);
    }

    public function clockOut(Request $request)
    {
        $user = Auth::user();

        // Validate incoming data
        $request->validate([
            'clock_out' => 'required|date_format:H:i',
            'date' => 'required|date_format:Y-m-d',
            'day' => 'required|string', // Added validation for day
        ]);

        // Find today's clock-in record
        $clockIn = Clockinout::where('user_id', $user->id)
            ->whereDate('date', $request->date)
            ->whereNull('clock_out') // Ensure the clock-out is not already set
            ->first();

        if (!$clockIn) {
            return response()->json(['message' => 'You have not clocked in today or already clocked out.'], 400);
        }

        // Calculate total hours worked
        $clockInTime = Carbon::createFromFormat('H:i', $clockIn->clock_in);
        $clockOutTime = Carbon::createFromFormat('H:i', $request->clock_out);

        $totalHours = $clockInTime->diff($clockOutTime)->format('%H:%I');

        // Update clock-out time and total hours
        $clockIn->update([
            'clock_out' => $request->clock_out,
            'total_hours' => $totalHours,
            'day' => $request->day, // Store the day of the week for clock-out as well
        ]);
        return response()->json(['message' => 'Clocked out successfully!']);
    }
}
