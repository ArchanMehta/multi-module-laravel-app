<?php

namespace App\Exports;

use App\Models\Leave;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\FromCollection;

class UsersExport implements FromCollection
{
      /**
     * Export the data.
     */
    public function collection()
    {
        return Leave::with('user')->where('user_id', Auth::id())->get();
    }
    /**
     * Map data for each row.
     */
    public function map($leave): array
    {
        return [
            $leave->user->name ?? 'N/A', // User name (if exists)
            $leave->start_date,
            $leave->start_day_type,
            $leave->end_date,
            $leave->end_day_type,
            $leave->reason,
            $leave->status,
            $leave->approved_by ?? 'N/A',
            $leave->created_at ?? 'N/A'
        ];
    }

    /**
     * Add headings to the Excel sheet.
     */
    public function headings(): array
    {
        return [
            'User Name',
            'Start Date',
            'Start Day Type',
            'End Date',
            'End Day Type',
            'Reason',
            'Status',
            'Approved By',
            'Created At'
        ];
    }
}
