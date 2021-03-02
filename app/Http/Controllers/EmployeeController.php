<?php

namespace App\Http\Controllers;

use App\Models\AttendanceRegister\AttendanceRegister;
use App\Models\Company\Company;
use App\Models\Country\Country;
use App\Models\Department\Department;
use App\Models\Employee\Employee;
use App\Models\EmployeeHistory\EmployeeHistory;
use App\Models\EmployeeType\EmployeeType;
use App\Models\Leave\Leave;
use App\Models\LeaveCalculation\LeaveCalculation;
use App\Models\LeaveType\LeaveType;
use App\Models\Team\Team;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Redirect;

class EmployeeController extends Controller
{
    /**
     * Define your validation rules in a property in
     * the controller to reuse the rules.
     */
    protected $validationRules=[
        'employeeType_id' => 'required|numeric|digits_between:1,9999',
        'dob' => 'date_format:Y-m-d',
        'start_date' => 'date_format:Y-m-d',
    ];
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($employee)
            $employees = Employee::where('company_id', '=', $employee->company_id)->get();
        else
            $employees = DB::table('employees')->get();
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
        $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($employee) {
            $companies = Company::where('id', '=', $employee->company_id)->get();
            $departments = Department::where('company_id', '=', $employee->company_id)->get();
            $teams = Team::where('company_id', '=', $employee->company_id)->get();
        } else {
            $companies = Company::all();
            $departments = Department::all();
            $teams = Team::all();
        }
        $countries = Country::all();
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
        $v = Validator::make($request->all(), $this->validationRules);
        if ($v->fails())
            return redirect()->back()->withErrors($v->errors())->withInput();

        // validate duplicate email address
        $exists = Employee::where('email', '=', Input::get('email'))->first();
        if ($exists) {
            return Redirect::route('employee.add')->withInput()->with('danger', 'Employee with email "' . $exists->email . '" already exists!');
        }
        // validate duplicate ID no
        $exists = Employee::where('idNo', '=', Input::get('idNo'))->first();
        if ($exists) {
            return Redirect::route('employee.add')->withInput()->with('danger', 'Employee with ID no "' . $exists->idNo . '" already exists!');
        }
        // validate gender
        if (Input::get('gender') != 'Male' && Input::get('gender') != 'Female')
            return Redirect::route('employee.add')->withInput()->with('warning', 'Please select Gender');

        // validate ID Type
        if (Input::get('idType') == 'Select Type')
            return Redirect::route('employee.add')->withInput()->with('warning', 'Please select ID Type');

        // validate days employee works per week
        if (Input::get('days') == null)
            return Redirect::route('employee.add')->withInput()->with('warning', 'Number of working days per week not added!');

        //validate if date of birth and first six characters of ID no are equal
        if (Input::get('idType') == 'RSA ID') {
            $idNumber = strlen(Input::get('idNo'));
            if ($idNumber != 13)
                return Redirect::route('employee.add')->withInput()->with('warning', 'SA ID number is 13 digits long!');
        }
        $idN = Input::get('idNo');
        $dob = Input::get('dob');
        if (substr($idN, 0, 2) != substr($dob, 2, 2) or substr($idN, 2, 2) != substr($dob, 5, 2) or substr($idN, 4, 2) != substr($dob, 8, 2))
            return Redirect::route('employee.add')->withInput()->with('warning', 'First 6 characters of ID no & date of birth are not equal!');

        if (Input::get('annual') == null && Input::get('sick') == null && Input::get('public') == null && Input::get('study') == null &&
        Input::get('family') == null && Input::get('maternity') == null && Input::get('commissioning') == null &&
        Input::get('unpaid') == null && Input::get('adoption') == null && Input::get('paternity') == null && Input::get('covid') == null)
            return Redirect::route('employee.add')->withInput()->with('warning', 'At least one leave type must be selected!');

        $input = Input::all();
        $employee = new Employee($input);
        $company = Company::find(Input::get('company_id'));
        $employee->country_id = $company->country_id;

        if ($employee->save()) {
            $employeeId = Employee::where('name', '=', Input::get('name'))
                ->where('surname', '=', Input::get('surname'))->first();

            if (Input::get('annual') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'nnua' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type annual is not added in LeaveType table!');
            }
            if (Input::get('sick') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'ick' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type sick is not added in LeaveType table!');
            }
            if (Input::get('public') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'ublic' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type public is not added in LeaveType table!');
            }
            if (Input::get('study') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'tudy' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type study is not added in LeaveType table!');
            }
            if (Input::get('family') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'amil' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type family responsibility is not added in LeaveType table!');
            }
            if (Input::get('maternity') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'mate' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type maternity is not added in LeaveType table!');
            }
            if (Input::get('commissioning') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'sionin' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type commissioning is not added in LeaveType table!');
            }
            if (Input::get('unpaid') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'paid' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type unpaid is not added in LeaveType table!');
            }
            if (Input::get('adoption') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'dopt' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type adoption is not added in LeaveType table!');
            }
            if (Input::get('paternity') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'pate' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type paternity is not added in LeaveType table!');
            }
            if (Input::get('covid') == 'on') {
                $leaveType = LeaveType::where('type', 'like', '%' . 'ovid' . '%')->first();
                if ($leaveType)
                    $this->leaveCalculation($employeeId->id, $leaveType->id);
                else
                    return Redirect::route('employee.add')->withInput()->with('warning',
                        'Leave type covid is not added in LeaveType table!');
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

        $leaveCalculation->leaveDays_accumulated = 0;
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

        $login_employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($login_employee) {
            $countries = Country::find($login_employee->country_id);
            $companies = Company::where('id', '=', $login_employee->company_id)->get();
            $departments = Department::where('company_id', '=', $login_employee->company_id)->get();
            $teams = Team::where('company_id', '=', $login_employee->company_id)->get();
        } else {
            $countries = Country::all();
            $companies = Company::all();
            $departments = Department::all();
            $teams = Team::all();
        }
        $employeeTypes = EmployeeType::all();
        $leaveCalculations = LeaveCalculation::where('employee_id', '=', $employee->id)->get();

        $annual = null;
        $sick = null;
        $public = null;
        $study = null;
        $family = null;
        $maternity = null;
        $commissioning = null;
        $unpaid = null;
        $adoption = null;
        $paternity = null;
        $covid = null;
        $work_daysPerWeek = null;

        foreach ($leaveCalculations as $calculation)
        {
            $work_daysPerWeek = $calculation->work_daysPerWeek;
            $type = LeaveType::where('type', 'like', '%' . 'nnua' . '%')->first();
            if ($type->id == $calculation->leaveType_id)
                $annual = 'on';
            else {
                $type = LeaveType::where('type', 'like', '%' . 'ick' . '%')->first();
                if ($type->id == $calculation->leaveType_id)
                    $sick = 'on';
                else {
                    $type = LeaveType::where('type', 'like', '%' . 'ublic' . '%')->first();
                    if ($type->id == $calculation->leaveType_id)
                        $public = 'on';
                    else {
                        $type = LeaveType::where('type', 'like', '%' . 'tudy' . '%')->first();
                        if ($type->id == $calculation->leaveType_id)
                            $study = 'on';
                        else {
                            $type = LeaveType::where('type', 'like', '%' . 'amil' . '%')->first();
                            if ($type->id == $calculation->leaveType_id)
                                $family = 'on';
                            else {
                                $type = LeaveType::where('type', 'like', '%' . 'mate' . '%')->first();
                                if ($type->id == $calculation->leaveType_id)
                                    $maternity = 'on';
                                else {
                                    $type = LeaveType::where('type', 'like', '%' . 'sionin' . '%')->first();
                                    if ($type->id == $calculation->leaveType_id)
                                        $commissioning = 'on';
                                    else {
                                        $type = LeaveType::where('type', 'like', '%' . 'paid' . '%')->first();
                                        if ($type->id == $calculation->leaveType_id)
                                            $unpaid = 'on';
                                        else {
                                            $type = LeaveType::where('type', 'like', '%' . 'dopt' . '%')->first();
                                            if ($type->id == $calculation->leaveType_id)
                                                $adoption = 'on';
                                            else {
                                                $type = LeaveType::where('type', 'like', '%' . 'pate' . '%')->first();
                                                if ($type->id == $calculation->leaveType_id)
                                                    $paternity = 'on';
                                                else {
                                                    $type = LeaveType::where('type', 'like', '%' . 'ovid' . '%')->first();
                                                    if ($type->id == $calculation->leaveType_id)
                                                        $covid = 'on';
                                                }
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
            }
        }
        return view('employee.edit', compact('employee', 'countries', 'companies', 'departments', 'teams', 'employeeTypes',
            'work_daysPerWeek', 'annual', 'sick', 'public', 'study', 'family', 'maternity', 'commissioning', 'unpaid',
            'adoption', 'paternity', 'covid'));
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
        $v = Validator::make($request->all(), $this->validationRules);
        if ($v->fails())
            return redirect()->back()->withErrors($v->errors())->withInput();

        $employee = Employee::find($id);

        //validate duplicate ID no
        $employee_check = Employee::where('idNo', '=', Input::get('idNo'))->get()->first();
        if ($employee_check && $employee_check->id != $id)
            return Redirect::route('employee.edit', [$id])->withInput()->with('danger', 'Employee"s ID no already exists');

        // validate duplicate email address
        $employee_check = Employee::where('email', '=', Input::get('email'))->get()->first();
        if ($employee_check && $employee_check->id != $id)
            return Redirect::route('employee.edit', [$id])->withInput()->with('danger', 'Employee"s email address already exists');

        //validate if date of birth and first six characters of ID no are equal
        if (Input::get('idType') == 'RSA ID') {
            $idNumber = strlen(Input::get('idNo'));
            if ($idNumber != 13)
                return Redirect::route('employee.edit', [$id])->withInput()->with('warning', 'SA ID number is 13 digits long!');
        }
        $idN = Input::get('idNo');
        $dob = Input::get('dob');
        if (substr($idN, 0, 2) != substr($dob, 2, 2) or substr($idN, 2, 2) != substr($dob, 5, 2) or substr($idN, 4, 2) != substr($dob, 8, 2))
            return Redirect::route('employee.edit', [$id])->withInput()->with('warning', 'First 6 characters of ID no & date of birth are not equal!');

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
        $employee->employeeType_id = Input::get('employeeType_id');
        $employee->dept_id = Input::get('dept_id');
        $employee->team_id = Input::get('team_id');
        $employee->company_id = Input::get('company_id');
        $company = Company::find(Input::get('company_id'));
        $employee->country_id = $company->country_id;

        if ($employee->update()) {
            $leaveType = LeaveType::where('type', 'like', '%' . 'nnua' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('annual') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('annual') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('annual') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type annual is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'ick' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('sick') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('sick') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('sick') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type sick is not added on LeaveType table');
            }

            $leaveType = LeaveType::where('type', 'like', '%' . 'blic' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('public') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('public') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('public') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type public is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'udy' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('study') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('study') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('study') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type study is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'mily' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('family') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('family') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('family') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type family responsibility is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'mate' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('maternity') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('maternity') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('maternity') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type maternity is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'sionin' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('commissioning') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('commissioning') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('commissioning') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type commissioning is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'paid' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('unpaid') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('unpaid') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('unpaid') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type unpaid is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'opti' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('adoption') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('adoption') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('adoption') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type adoption is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'pate' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('paternity') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('paternity') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('paternity') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type paternity is not added on LeaveType table');
            }
            $leaveType = LeaveType::where('type', 'like', '%' . 'vid' . '%')->first();
            if ($leaveType) {
                $leaveCalculation = LeaveCalculation::where('leaveType_id', '=', $leaveType->id)
                    ->where('employee_id', '=', $employee->id)->first();
                if ($leaveCalculation) {
                    if (Input::get('covid') != 'on')
                        $leaveCalculation->delete();
                } else {
                    if (Input::get('covid') == 'on')
                        $this->leaveCalculation($employee->id, $leaveType->id);
                }
            } else {
                if (Input::get('covid') == 'on')
                    return Redirect::route('employee.edit', [$id])->withInput()->with('warning',
                        'Leave type covid is not added on LeaveType table');
            }
            return Redirect::route('employees')->with('success', 'Successfully updated employee!');
        } else
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
                $attendanceRegister = AttendanceRegister::where('employee_id', '=', $employee->id)->get();
                if ($attendanceRegister) {
                    foreach ($attendanceRegister as $register) {
                        $register->delete();
                    }
                }
                $leaveCalculations = LeaveCalculation::where('employee_id', '=', $employee->id)->get();
                if ($leaveCalculations) {
                    foreach ($leaveCalculations as $calculation) {
                        $calculation->delete();
                    }
                }
                $leaves = Leave::where('employee_id', '=', $employee->id)->get();
                if ($leaves) {
                    foreach ($leaves as $leave) {
                        $leave->delete();
                    }
                }
                $employee->delete();
                return Redirect::route('employees')->with('success', 'Employee successfully terminated!');
            }
        }
    }
    public function getNameData(Request $request)
    {
        $employee_name = $request->input('nameAuto');
        $employeesInfo = array();

        $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
        if ($employee)
            $employees = DB::table('employees')->where('company_id', '=', $employee->company_id)
                ->where('name', 'LIKE', "%{$employee_name}%")->orderBy('name')->get();
        else
            $employees = DB::table('employees')->where('name', 'LIKE', "%{$employee_name}%")->orderBy('name')->get();

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
