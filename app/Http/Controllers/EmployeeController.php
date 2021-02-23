<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Country\Country;
use App\Models\Department\Department;
use App\Models\Employee\Employee;
use App\Models\EmployeeHistory\EmployeeHistory;
use App\Models\EmployeeType\EmployeeType;
use App\Models\LeaveCalculation\LeaveCalculation;
use App\Models\LeaveType\LeaveType;
use App\Models\Team\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->user_role == 'Management') {
            $employees = Employee::all();
        } else {
            $employee = Employee::where('name', '=', Auth::user()->name)
                ->where('surname', '=', Auth::user()->surname)->first();
            $employees = Employee::where('company_id', '=', $employee->company_id)->get();
        }
        $employeesArray = array();

        foreach ($employees as $employee)
        {
            $employeeArray = new Employee();
            $employeeArray->id = $employee->id;
            $employeeArray->name = $employee->name;
            $employeeArray->surname = $employee->surname;
            $employeeArray->employeeNo = $employee->employee_no;
            $employeeArray->dateOfBirth = $employee->dob;
            $employeeArray->idNo = $employee->idNo;
            $employeeArray->gender = $employee->gender;
            $employeeArray->contactNo = $employee->contact_no;
            $employeeArray->emailAddress = $employee->email;
            $employeeArray->startDate = $employee->start_date;
            $employeeArray->occupation = $employee->occupation;
            $employeeType = EmployeeType::find($employee->employeeType_id);
            $employeeArray->employeeType = $employeeType->employee_type;
            array_push($employeesArray, $employeeArray);
        }
        return view('employee.index', ['employeesArray' => $employeesArray]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        if(Auth::user()->user_role == 'Management') {
            $countries = Country::all();
            $companies = Company::all();
            $departments = Department::all();
            $teams = Team::all();
        } else {
            $employee = Employee::where('name', '=', Auth::user()->name)
                ->where('surname', '=', Auth::user()->surname)->first();
            $countries = Country::where('id', '=', $employee->country_id)->get();
            $companies = Company::where('id', '=', $employee->company_id)->get();
            $departments = Department::where('company_id', '=', $employee->company_id)->get();
            $teams = Team::where('company_id', '=', $employee->company_id)->get();
        }
        $employeeTypes = EmployeeType::all();
        $leaveTypes = LeaveType::all();
        return view('employee.add', compact('countries', 'companies', 'departments', 'teams', 'employeeTypes', 'leaveTypes'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Input::get('days') == null)
            return Redirect::route('employee.add')->withInput()->with('warning', 'Number of working days per week not added!');

        $input = Input::all();
        $employee = new Employee($input);

        if ($employee->save()) {
            $employeeId = Employee::where('name', '=', Input::get('name'))
                ->where('surname', '=', Input::get('surname'))->first();

            if (Input::get('annual') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'nnua' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('sick') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'ick' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('public') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'ublic' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('parental') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'arent' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('study') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'tudy' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('family') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'amil' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('maternity') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'mate' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('commissioning') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'sionin' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('unpaid') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'paid' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('adoption') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'dopt' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('paternity') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'pate' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            if (Input::get('covid') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'ovid' . '%')->first();
                $this->leaveCalculation($employeeId->id, $leaveType->id);
            }
            return Redirect::route('employees', ['id' => $employee->id])->with('success', 'Successfully added employee!');
        } else
            return Redirect::route('employee.add')->withInput()->withErrors($employee->errors());
    }
    public function leaveCalculation($id, $typeId)
    {
        $leaveCalculation = new LeaveCalculation();
        if (Input::get('days') == 'five')
            $leaveCalculation->work_daysPerWeek = 5;
        else
            $leaveCalculation->work_daysPerWeek = 6;

        $leaveCalculation->leaveDays_available = 0;
        $leaveCalculation->leaveDays_taken = 0;
        $leaveCalculation->leaveType_id = $typeId;
        $leaveCalculation->employee_id = $id;
        $leaveCalculation->save();
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
        $employee = Employee::find($id);
        if(Auth::user()->user_role == 'Management') {
            $countries = Country::all();
            $companies = Company::all();
            $departments = Department::all();
            $teams = Team::all();
        } else {
            $user = Employee::where('name', '=', Auth::user()->name)
                ->where('surname', '=', Auth::user()->surname)->first();
            $countries = Country::where('id', '=', $user->country_id)->get();
            $companies = Company::where('id', '=', $user->company_id)->get();
            $departments = Department::where('company_id', '=', $user->company_id)->get();
            $teams = Team::where('company_id', '=', $user->company_id)->get();
        }
        $employeeTypes = EmployeeType::all();

        return view('employee.edit', compact('employee', 'countries', 'companies', 'departments', 'teams', 'employeeTypes'));
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
        $employee = Employee::find($id);
        $employee_check = Employee::where('idNo', '=', Input::get('idNo'))->get()->first();

        if ($employee_check && $employee_check->id != $id)
            return Redirect::route('employee.edit', [$id])->withInput()->with('danger', 'Employee"s ID no already exists');

        $employee->employee_no = Input::get('employee_no');
        $employee->name = Input::get('name');
        $employee->surname = Input::get('surname');
        $employee->dob = Input::get('dob');
        $employee->idType = Input::get('idType');
        $employee->idNo = Input::get('idNo');
        $employee->gender = Input::get('gender');
        $employee->occupation = Input::get('occupation');
        $employee->start_date = Input::get('start_date');
        $employee->contact_no = Input::get('contact_no');
        $employee->email = Input::get('email');

        if ($employee->update())
            return Redirect::route('employees')->with('success', 'Successfully updated employee!');
        else
            return Redirect::route('employee.edit', [$id])->withInput()->withErrors($employee->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);

        if ($employee) {
            $employeeHistory = new EmployeeHistory();
            $employeeHistory->employee_no = $employee->employee_no;
            $employeeHistory->surname = $employee->surname;
            $employeeHistory->name = $employee->name;
            $employeeHistory->dob = $employee->dob;
            $employeeHistory->idType = $employee->idType;
            $employeeHistory->idNo = $employee->idNo;
            $employeeHistory->gender = $employee->gender;
            $employeeHistory->contact_no = $employee->contact_no;
            $employeeHistory->start_date = $employee->start_date;
            $employeeHistory->occupation = $employee->occupation;
            $employeeHistory->email = $employee->email;
            $date = Carbon::now();
            $employeeHistory->termination_date = $date->format('Y-m-d');
            $employeeHistory->action_user = Auth::user()->name . ' ' . Auth::user()->surname;
            $employeeHistory->employeeType_id = $employee->employeeType_id;
            $employeeHistory->dept_id = $employee->dept_id;
            $employeeHistory->team_id = $employee->team_id;
            $employeeHistory->company_id = $employee->company_id;
            $employeeHistory->country_id = $employee->country_id;

            if ($employeeHistory->save()) {
                $employee->delete();
                return Redirect::route('employees')->with('success', 'Employee successfully terminated!');
            }
        }
    }
    public function getNameData(Request $request)
    {
        $employee_name = $request->input('nameAuto');
        $employeesInfo = array();

        if(Auth::user()->user_role == 'Management') {
            $employees = DB::table('employees')->where('name', 'LIKE', "%{$employee_name}%")->orderBy('name')->get();
        } else {
            $employee = Employee::where('name', '=', Auth::user()->name)
                ->where('surname', '=', Auth::user()->surname)->first();
            $employees = DB::table('employees')->where('company_id', '=', $employee->company_id)
            ->where('name', 'LIKE', "%{$employee_name}%")->orderBy('name')->get();
        }
        foreach ($employees as $employee) {
            $employeeInfo = new EmployeeInfo();
            $employeeInfo->id = $employee->id;
            $employeeInfo->label = $employee->name;
            $employeeInfo->name = $employee->surname;
            array_push($employeesInfo, $employeeInfo);
        }
        return json_encode($employeesInfo);
    }
}
class Employees
{
    public $id;
    public $name;
    public $surname;
    public $employeeNo;
    public $dateOfBirth;
    public $idNo;
    public $gender;
    public $contactNo;
    public $emailAddress;
    public $startDate;
    public $occupation;
    public $employeeType;
}
class EmployeeInfo
{
    public $id;
    public $label;
    public $name;
}