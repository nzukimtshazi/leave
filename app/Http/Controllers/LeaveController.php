<?php

namespace App\Http\Controllers;


use App\Models\Employee\Employee;
use App\Models\EmployeeType\EmployeeType;
use App\Models\Leave\Leave;
use App\Models\LeaveCalculation\LeaveCalculation;
use App\Models\LeaveType\LeaveType;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;

class LeaveController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employees = Employee::all();
        $employeeTypes = EmployeeType::all();
        $leaveCalculations = LeaveCalculation::all();

        return view('leave.index', compact('employees', 'employeeTypes', 'leaveCalculations'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $leaveTypes = LeaveType::all();
        return view('leave.add', compact('leaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $employee = Employee::where('name', '=', $request->input('name'))
            ->where('surname', '=', $request->input('surname'))->first();

        $date1 = Carbon::createFromFormat('Y-m-d', $request->input('start_date'));
        $date2 = Carbon::createFromFormat('Y-m-d', $request->input('end_date'));
        $days = $date1->diff($date2);

        $leaveType = LeaveType::where('id', '=', $request->input('leaveType_id'))->first();
        $leaveCalculation = LeaveCalculation::where('employee_id', '=', $employee->id)
            ->where('leaveType_id', '=', $leaveType->id)->first();

        if ($leaveCalculation) {
            if ($days > $leaveCalculation->leaveDays_available)
                return Redirect::route('leave.add')->with('warning', 'Available leave days is less than applied days!');
        }

        $input = Input::all();
        $leave = new Leave($input);
        $leave->employee_id = $employee->id;

        if ($leave->save())
            return Redirect::route('leave')->with('success', 'Successfully captured leave for employee!');
        else
            return Redirect::route('leave.add')->withInput()->withErrors($leave->errors());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
