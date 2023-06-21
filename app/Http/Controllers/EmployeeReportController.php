<?php

namespace App\Http\Controllers;

use App\Models\EmployeeReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\User;

class EmployeeReportController extends Controller
{

    public function showCheck_InOut(){
        $currentDate = Carbon::now()->toDateString();
        $user = auth()->user();
        $checkInTime = null;
        $checkedIn = false;

        if ($user) {
            $employeeReport = EmployeeReport::where('employee_id', $user->id)
                ->whereDate('created_at', $currentDate)
                ->first();

            if ($employeeReport) {
                $checkedIn = $employeeReport->check_in_time !== null;
                $checkInTime = $employeeReport->check_in_time;
            }
        }

        return view('employeeCheckInOut', compact('currentDate', 'checkedIn', 'checkInTime'));


    }
    public function checkIn(Request $request)
    {
        // Get the authenticated employee
        $employee = Auth::user();

        // Check if the employee has already checked in today
        $existingReport = EmployeeReport::where('employee_id', $employee->id)
            ->whereDate('created_at', Carbon::today())
            ->first();

        if ($existingReport) {
            // Employee has already checked in, do not allow multiple check-ins in a day
            return redirect()->back()->with('message', 'You have already checked in today.');
        }

        // Create a new employee report record
        EmployeeReport::create([
            'employee_id' => $employee->id,
            'check_in_time' => Carbon::now(),
            'date' => Carbon::today(),
        ]);

        return redirect()->back()->with('message', 'Check-in successful.');
    }

    public function checkOut(Request $request)
    {
        // Get the authenticated employee
        $employee = Auth::user();

        // Find the employee's latest report record for today
        $report = EmployeeReport::where('employee_id', $employee->id)
            ->whereDate('created_at', Carbon::today())
            ->latest()
            ->first();

        if (!$report || $report->check_out_time) {
            // Employee has not checked in today or has already checked out
            return redirect()->back()->with('message', 'Invalid check-out request.');
        }

        // Update the check-out time
        $report->check_out_time = Carbon::now();
        $report->save();

        return redirect()->back()->with('message', 'Check-out successful.');
    }
    public function employeeReport(Request $request)
    {
        $selectedDate = $request->input('reportDate', Carbon::now()->toDateString());

        // Retrieve the available dates for the employee reports
        $availableDates = EmployeeReport::pluck('created_at')->map(function ($date) {
            return $date->format('Y-m-d');
        })->unique();

        // Retrieve the employee report data for the selected date
        $employeeReport = EmployeeReport::whereDate('created_at', $selectedDate)
            ->with('employee') // Eager load the associated employee
            ->get();

        $noDataMessage = '';

        if ($selectedDate == Carbon::now()->toDateString() && $employeeReport->isEmpty()) {
            $noDataMessage = 'No data for current date.';
        }

        $currentDate = Carbon::now()->toDateString();
        //dd($currentDate);

        return view('employeeReport', compact('selectedDate', 'availableDates', 'employeeReport', 'noDataMessage', 'currentDate'));
    }


    public function individualReport($employeeId)
{
    // Retrieve the employee's information
    $employee = User::findOrFail($employeeId);

    // Retrieve the individual report data for the employee
    $individualReport = EmployeeReport::where('employee_id', $employeeId)
        ->orderBy('created_at', 'desc')
        ->get();

    return view('individualReport', compact('employee', 'individualReport'));
}




}
