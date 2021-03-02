<?php

namespace App\Http\Controllers;

use App\Models\Department\Department;
use App\Models\Employee\Employee;
use App\Models\AttendanceRegister\AttendanceRegister;
use App\Models\EmployeeType\EmployeeType;
use App\Models\LeaveCalculation\LeaveCalculation;
use App\Models\LeaveType\LeaveType;
use App\Models\Role\Role;
use App\Models\Team\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Session;

class AttendanceRegisterController extends Controller
{
    /**
     * Define your validation rules in a property in
     * the controller to reuse the rules.
     */
    protected $validationRules=[
        'employeeType_id' => 'required|numeric|digits_between:1,9999',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }
    /**
     * Show the form for creating a new resources.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($employee) {
            $departments = Department::where('company_id', '=', $employee->company_id)->get();
            $teams = Team::where('company_id', '=', $employee->company_id)->get();
        } else {
            $departments = DB::table('departments')->get();
            $teams = DB::table('teams')->get();
        }
        $employeeTypes = EmployeeType::all();
        return view('attendanceRegister.search', compact('departments', 'teams', 'employeeTypes'));
    }
    public function add(Request $request)
    {
        $v = Validator::make($request->all(), $this->validationRules);
        if ($v->fails())
            return redirect()->back()->withErrors($v->errors())->withInput();
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->input('defaultValue') == null)
            return Redirect::route('attendanceRegister.add')->with('warning', 'You have to choose between employee types to capture register!');

        $pageDate = Carbon::now();
        $endDate = $pageDate->format('Y-m-d');

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
            $attendanceRegister->employee_id = $employees[$i];
            $employee = Employee::find($employees[$i]);

            if ($employee->start_date <= $request->input('day1')) {
                $attendanceRegister->day1 = $request->input('day1');
                $attendanceRegister->day1Register = $day1Register[$i];
            } else {
                $attendanceRegister->day1 = null;
                $attendanceRegister->day1Register = null;
            }
            if ($employee->start_date <= $request->input('day2')) {
                $attendanceRegister->day2 = $request->input('day2');
                $attendanceRegister->day2Register = $day2Register[$i];
            } else {
                $attendanceRegister->day2 = null;
                $attendanceRegister->day2Register = null;
            }
            if ($employee->start_date <= $request->input('day3')) {
                $attendanceRegister->day3 = $request->input('day3');
                $attendanceRegister->day3Register = $day3Register[$i];
            } else {
                $attendanceRegister->day3 = null;
                $attendanceRegister->day3Register = null;
            }
            if ($employee->start_date <= $request->input('day4')) {
                $attendanceRegister->day4 = $request->input('day4');
                $attendanceRegister->day4Register = $day4Register[$i];
            } else {
                $attendanceRegister->day4 = null;
                $attendanceRegister->day4Register = null;
            }
            if ($employee->start_date <= $request->input('day5')) {
                $attendanceRegister->day5 = $request->input('day5');
                $attendanceRegister->day5Register = $day5Register[$i];
            } else {
                $attendanceRegister->day5 = null;
                $attendanceRegister->day5Register = null;
            }
            if ($employee->start_date <= $request->input('day6')) {
                $attendanceRegister->day6 = $request->input('day6');
                $attendanceRegister->day6Register = $day6Register[$i];
            } else {
                $attendanceRegister->day6 = null;
                $attendanceRegister->day6Register = null;
            }
            if ($employee->start_date <= $request->input('day7')) {
                $attendanceRegister->day7 = $request->input('day7');
                $attendanceRegister->day7Register = $day7Register[$i];
            } else {
                $attendanceRegister->day7 = null;
                $attendanceRegister->day7Register = null;
            }

            if ($employee->employeeType_id = EmployeeType::where('employee_type', 'like', '%' . 'hift' . '%')->first() ) {
                if ($day7Register[$i] == 'P')
                    $attendanceRegister->last_captureDate = $request->input('day7');
                elseif ($day6Register[$i] == 'P')
                    $attendanceRegister->last_captureDate = $request->input('day6');
                elseif ($day5Register[$i] == 'P')
                    $attendanceRegister->last_captureDate = $request->input('day5');
                elseif ($day4Register[$i] == 'P')
                    $attendanceRegister->last_captureDate = $request->input('day4');
                elseif ($day3Register[$i] == 'P')
                    $attendanceRegister->last_captureDate = $request->input('day3');
                elseif ($day2Register[$i] == 'P')
                    $attendanceRegister->last_captureDate = $request->input('day2');
                else
                    $attendanceRegister->last_captureDate = $request->input('day1');
            } else {
                if ($day7Register[$i] == '8')
                    $attendanceRegister->last_captureDate = $request->input('day7');
                elseif ($day6Register[$i] == '8')
                    $attendanceRegister->last_captureDate = $request->input('day6');
                elseif ($day5Register[$i] == '8')
                    $attendanceRegister->last_captureDate = $request->input('day5');
                elseif ($day4Register[$i] == '8')
                    $attendanceRegister->last_captureDate = $request->input('day4');
                elseif ($day3Register[$i] == '8')
                    $attendanceRegister->last_captureDate = $request->input('day3');
                elseif ($day2Register[$i] == '8')
                    $attendanceRegister->last_captureDate = $request->input('day2');
                else
                    $attendanceRegister->last_captureDate = $request->input('day1');
            }
            $attendanceRegister->save();
            $this->calculateLeave($employees[$i]);
        }
        if ($endDate > $request->input('day7') && $request->input('day7') != null) {
            $defaultValue = $request->defaultValue;
            $day1 = $request->day1;
            $day2 = $request->day2;
            $day3 = $request->day3;
            $day4 = $request->day4;
            $day5 = $request->day5;
            $day6 = $request->day6;
            $day7 = $request->day7;
            $str_day1 = $request->str_day1;
            return Redirect::route('paginateRight', compact('defaultValue', 'day1', 'day2', 'day3', 'day4', 'day5',
                'day6', 'day7', 'str_day1'));
        } else
            return Redirect::route('reports.annualLeave')->with('success', 'Successfully captured employees" register!');
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

        foreach ($attendanceRegister as $register)
        {
            $type = EmployeeType::where('employee_type', 'like', '%' . 'hift' . '%')->first();
            if ($employee->employeeType_id == $type->id)
            {
                if ($register->day1Register == 'P')
                    ++$total_days;
                if ($register->day2Register == 'P')
                    ++$total_days;
                if ($register->day3Register == 'P')
                    ++$total_days;
                if ($register->day4Register == 'P')
                    ++$total_days;
                if ($register->day5Register == 'P')
                    ++$total_days;
                if ($register->day6Register == 'P')
                    ++$total_days;
                if ($register->day7Register == 'P')
                    ++$total_days;
            } else {
                $total_hours = $register->day1Register + $register->day2Register + $register->day3Register +
                    $register->day4Register + $register->day5Register + $register->day6Register + $register->day7Register;
            }
            $grandTotalDays = $grandTotalDays + $total_days;
            $grandTotalHours = $grandTotalHours + $total_hours;
            $total_days = 0;
            $total_hours = 0;
        }
        if ($employee->employeeType_id = EmployeeType::where('employee_type', 'like', '%' . 'hift' . '%')->first() ) {
            $calculated_leave = $grandTotalDays / 17;
        } else {
            $grandTotalDays = $grandTotalHours / 8;
            $calculated_leave = $grandTotalDays / 17;
        }

        //store Leave Calculation table
        $type = LeaveType::where('type', 'like', '%' . 'nnua' . '%')->first();
        $leaveCalcEmployee = LeaveCalculation::where('leaveType_id', '=', $type->id)
            ->where('employee_id', '=', $employee->id)->first();

        $leaveCalculation = new LeaveCalculation();

        $leaveCalculation->work_daysPerWeek = $leaveCalcEmployee->work_daysPerWeek;
        $leaveCalculation->leaveDays_available = $leaveCalcEmployee->leaveDays_available + $calculated_leave;
        $leaveCalculation->leaveDays_taken = $leaveCalcEmployee->leaveDays_taken;
        $leaveCalculation->leaveType_id = $type->id;
        $leaveCalculation->employee_id = $employee->id;
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
        $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($employee)
            $employees = Employee::where('company_id', '=', $employee->company_id)
                ->where('employeeType_id', '=', $employee->employeeType_id)->get();
        else
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
        $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($employee)
            $employees = Employee::where('company_id', '=', $employee->company_id)
                ->where('employeeType_id', '=', $employee->employeeType_id)->get();
        else
            $employees = Employee::where('employeeType_id', '=', 1)->get();

        $defaultValue = "8";
        return $this->editEmployees($employees, $defaultValue);
    }
    public function editEmployees($employees, $defaultValue)
    {
        $employeesRegisterArray = array();
        foreach ($employees as $employee)
        {
            $employeesRegister = new EmployeesRegister();
            $employeesRegister->id = $employee->id;
            $employeesRegister->employeeNo = $employee->employee_no;
            $employeesRegister->surname = $employee->surname;
            $employeesRegister->name = $employee->name;
            $employeeType = EmployeeType::find($employee->employeeType_id);
            $employeesRegister->employeeType = $employeeType->employee_type;
            array_push($employeesRegisterArray, $employeesRegister);
        }
        $day1 = null;
        $day2 = null;
        $day3 = null;
        $day4 = null;
        $day5 = null;
        $day6 = null;
        $day7 = null;
        $str_day1 = null;
        $last_date = null;
        $leftPagination = 'No';
        $rightPagination = 'No';
        $datePagination = Carbon::now();
        $checkPagination = $datePagination->format('Y-m-d');

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
                $str_day1 = $create_date->format('Y-m-d');
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
        if ($day1 > $last_date)
            $leftPagination = 'Yes';

        if ($day7 < $checkPagination && $day7 != null)
            $rightPagination = 'Yes';

        return view('attendanceRegister.add', compact('employeesRegisterArray', 'day1', 'day2', 'day3', 'day4',
            'day5', 'day6', 'day7', 'defaultValue', 'rightPagination', 'leftPagination', 'str_day1'));
    }
    public function paginateRight(Request $request)
    {
        $defaultValue = $request->defaultValue;
        $leftPagination = 'Yes';
        $rightPagination = 'No';
        $str_day1 = $request->str_day1;
        $day7 = $request->day7;

        $employee_type = EmployeeType::where('employee_type', 'like', '%'. 'hift' . '%')->first();

        if ($defaultValue == 'P')
            $employees = Employee::where('employeeType_id', '=', $employee_type->id)->get();
        else
            $employees = Employee::where('employeeType_id', '!=', $employee_type->id)->get();

        $employeesRegisterArray = array();
        foreach ($employees as $employee)
        {
            $employeeRegisterArray = new Employee();
            $employeeRegisterArray->id = $employee->id;
            $employeeRegisterArray->employeeNo = $employee->employee_no;
            $employeeRegisterArray->surname = $employee->surname;
            $employeeRegisterArray->name = $employee->name;
            $employeeType = EmployeeType::find($employee->employeeType_id);
            $employeeRegisterArray->employeeType = $employeeType->employee_type;
            array_push($employeesRegisterArray, $employeeRegisterArray);
        }
        $pageDate = Carbon::now();
        $endDate = $pageDate->format('Y-m-d');

        while ($request->day7 < $endDate && $day7 == $request->day7)
        {
            $day1 = Carbon::parse($day7)->addDays(1);
            $day1 = $day1->format('Y-m-d');

            if ($day1 < $endDate && $day1 != null) {
                $day2 = Carbon::parse($day1)->addDays(1);
                $day2 = $day2->format('Y-m-d');
            } else
                $day2 = null;

            if ($day2 < $endDate && $day2 != null) {
                $day3 = Carbon::parse($day2)->addDays(1);
                $day3 = $day3->format('Y-m-d');
            } else
                $day3 = null;

            if ($day3 < $endDate && $day3 != null) {
                $day4 = Carbon::parse($day3)->addDays(1);
                $day4 = $day4->format('Y-m-d');
            } else
                $day4 = null;

            if ($day4 < $endDate && $day4 != null) {
                $day5 = Carbon::parse($day4)->addDays(1);
                $day5 = $day5->format('Y-m-d');
            } else
                $day5 = null;

            if ($day5 < $endDate && $day5 != null) {
                $day6 = Carbon::parse($day5)->addDays(1);
                $day6 = $day6->format('Y-m-d');
            } else
                $day6 = null;

            if ($day6 < $endDate && $day6 != null) {
                $day7 = Carbon::parse($day6)->addDays(1);
                $day7 = $day7->format('Y-m-d');
            } else
                $day7 = null;
        }
        if ($day7 < $endDate && $day7 != null)
            $rightPagination = 'Yes';

        return view('attendanceRegister.add', compact('employeesRegisterArray', 'day1', 'day2', 'day3', 'day4',
            'day5', 'day6', 'day7', 'defaultValue', 'rightPagination', 'leftPagination', 'str_day1'));
    }
}
class EmployeesRegister
{
    public $id;
    public $employeeNo;
    public $surname;
    public $name;
    public $employeeType;
}

