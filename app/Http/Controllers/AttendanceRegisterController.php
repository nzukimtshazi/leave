<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\AttendanceRegister\AttendanceRegister;
use App\Models\EmployeeType\EmployeeType;
use App\Models\LeaveCalculation\LeaveCalculation;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Session;

class AttendanceRegisterController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $employees = Employee::all();
        return view('attendanceRegister.index', compact('employees'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $employees = Employee::all();
        $defaultValue = " ";
        return $this->editEmployees($employees, $defaultValue);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $input = Input::all();
        $employees = $request->input('employee_id');
        $day1Register = $request->input('day1Register');
        $day2Register = $request->input('day2Register');
        $day3Register = $request->input('day3Register');
        $day4Register = $request->input('day4Register');
        $day5Register = $request->input('day5Register');
        $day6Register = $request->input('day6Register');
        $day7Register = $request->input('day7Register');

        $arrayLength = count($employees);

        for ($i = 0; $i < $arrayLength; $i++)
        {
            $attendanceRegister = new AttendanceRegister($input);
            $total_hours = null;
            $attendanceRegister->employee_id = $employees[$i];

            $attendanceRegister->day1 = $request->input('day1');
            $attendanceRegister->day1Register = $day1Register[$i];
            $attendanceRegister->day2 = $request->input('day2');
            $attendanceRegister->day2Register = $day2Register[$i];
            $attendanceRegister->day3 = $request->input('day3');
            $attendanceRegister->day3Register = $day3Register[$i];
            $attendanceRegister->day4 = $request->input('day4');
            $attendanceRegister->day4Register = $day4Register[$i];
            $attendanceRegister->day5 = $request->input('day5');
            $attendanceRegister->day5Register = $day5Register[$i];
            $attendanceRegister->day6 = $request->input('day6');
            $attendanceRegister->day6Register = $day6Register[$i];
            $attendanceRegister->day7 = $request->input('day7');
            $attendanceRegister->day7Register = $day7Register[$i];
            $attendanceRegister->last_captureDate = Carbon::now()->format('Y-m-d');
            $attendanceRegister->save();

            $this->calculateLeave($employees[$i]);
            return Redirect::route('leave')->with('success', 'Successfully captured employees" register!');
        }
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
    public function calculateLeave($id)
    {
        $employee = Employee::find($id);
        $attendanceRegister = AttendanceRegister::where('employee_id', '=', $employee->id)->get();
        $total_hours = 0;
        $total_days = 0;
        $grandTotalHours = 0;
        $grandTotalDays = 0;
        $employee_type = "";

        foreach ($attendanceRegister as $register)
        {
            $employeeType = EmployeeType::where('id', '=', $employee->employeeType_id)->first();
            if ($employeeType->employee_type == 'Shift Worker')
            {
                if ($register->day1Register == 'P'){
                    ++$total_days;
                }
                if ($register->day2Register == 'P') {
                    ++$total_days;
                }
                if ($register->day3Register == 'P') {
                    ++$total_days;
                }
                if ($register->day4Register == 'P') {
                    ++$total_days;
                }
                if ($register->day5Register == 'P') {
                    ++$total_days;
                }
                if ($register->day6Register == 'P') {
                    ++$total_days;
                }
                if ($register->day7Register == 'P') {
                    ++$total_days;
                }
            } else {
                $total_hours = $register->day1Register + $register->day2Register + $register->day3Register +
                    $register->day4Register + $register->day5Register + $register->day6Register + $register->day7Register;
            }
            $grandTotalDays = $grandTotalDays + $total_days;
            $grandTotalHours = $grandTotalHours + $total_hours;
            $total_days = 0;
            $employee_type = $employeeType->employee_type;
        }
        if ($employee_type == 'Shift Worker') {
            $calculated_leave = $grandTotalDays / 17;
        } else {
            $grandTotalDays = $grandTotalHours / 8;
            $calculated_leave = $grandTotalDays / 17;
        }

        //store Leave Calculation table
        $leaveCalculation = new LeaveCalculation();

        $leaveCalculation->annualLeaveCnt = $calculated_leave;
        $leaveCalculation->sickLeaveCnt = 0;
        $leaveCalculation->familyRespLeaveCnt = 0;
        $leaveCalculation->employee_id = $employee->id;

        $leaveCalcEmployee = LeaveCalculation::where('employee_id', '=', $employee->id)->first();
        if ($leaveCalcEmployee)
            $leaveCalcEmployee->delete();
        $leaveCalculation->save();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function shiftWorkers(Request $request)
    {
        $employees = Employee::where('employeeType_id', '=', 1)->get();
        $defaultValue = "P";
        return $this->editEmployees($employees, $defaultValue);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function labourers(Request $request)
    {
        $employees = Employee::where('employeeType_id', '=', 2)->get();
        $defaultValue = "8";
        return $this->editEmployees($employees, $defaultValue);
    }
    public function editEmployees($employees, $defaultValue)
    {
        $employeesRegisterArray = array();
        foreach ($employees as $employee)
        {
            $employeeRegisterArray = new Employee();
            $employeeRegisterArray->id = $employee->id;
            $employeeRegisterArray->employeeName = $employee->name . ' ' . $employee->surname;
            $employeeType = EmployeeType::find($employee->employeeType_id);
            $employeeRegisterArray->employeeType = $employeeType->employee_type;
            array_push($employeesRegisterArray, $employeeRegisterArray);
        }
        $day1 = null;
        $day2 = null;
        $day3 = null;
        $day4 = null;
        $day5 = null;
        $day6 = null;
        $day7 = null;

        foreach ($employees as $employee)
        {
            $last_date = AttendanceRegister::where('employee_id', '=', $employee->id)->orderBy('last_captureDate', 'DESC')->first();
            break;
        }

        if ($last_date) {
            $create_date = new Carbon($last_date->last_captureDate);
        } else
            $create_date = Carbon::now()->subDay();

        $calc_date = $create_date->format('Y-m-d');

        $date2 = new Carbon(date('Y-m-d'));
        $diff = $date2->diffInDays($calc_date);

        for ($i = 1; $i <= $diff; $i++)
        {
            if ($last_date)
                $date = new Carbon($last_date->last_captureDate);
            else
                $date = new Carbon($calc_date);

            $create_date = $date->addDays($i);

            if($i == 1) {
                $day1 = $create_date->format('Y-m-d');
            }
            if($i == 2) {
                $day2 = $create_date->format('Y-m-d');
            }
            if($i == 3) {
                $day3 = $create_date->format('Y-m-d');
            }
            if($i == 4) {
                $day4 = $create_date->format('Y-m-d');
            }
            if($i == 5) {
                $day5 = $create_date->format('Y-m-d');
            }
            if($i == 6) {
                $day6 = $create_date->format('Y-m-d');
            }
            if($i == 7) {
                $day7 = $create_date->format('Y-m-d');
            }
        }
        return view('attendanceRegister.add', compact('employeesRegisterArray', 'day1', 'day2', 'day3', 'day4',
            'day5', 'day6', 'day7', 'defaultValue'));
    }
}
class EmployeesRegister
{
    public $id;
    public $employeeName;
    public $employeeType;
}