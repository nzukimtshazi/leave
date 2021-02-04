<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Country\Country;
use App\Models\Department\Department;
use App\Models\Employee\Employee;
use App\Models\EmployeeType\EmployeeType;
use App\Models\Team\Team;
use Illuminate\Http\Request;
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
        $employees = Employee::all();
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
        $countries = Country::all();
        $companies = Company::all();
        $departments = Department::all();
        $teams = Team::all();
        $employeeTypes = EmployeeType::all();

        return view('employee.add', compact('countries', 'companies', 'departments', 'teams', 'employeeTypes'));
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
        $employee = new Employee($input);

        if ($employee->save())
            return Redirect::route('employees', ['id' => $employee->id])->with('success', 'Successfully added employee!');
        else
            return Redirect::route('employee.add')->withInput()->withErrors($employee->errors());
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
        $countries = Country::all();
        $companies = Company::all();
        $departments = Department::all();
        $teams = Team::all();
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
        //
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