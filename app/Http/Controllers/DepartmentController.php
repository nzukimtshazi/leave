<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Department\Department;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    /**
     * Define your validation rules in a property in
     * the controller to reuse the rules.
     */
    protected $validationRules=[
        'company_id' => 'required|numeric|digits_between:1,9999',
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
            $departments = Department::where('company_id', '=', $employee->company_id)->get();
        else
            $departments = DB::table('departments')->get();
        return view('department.index', ['departments' => $departments]);
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
        if ($employee)
            $companies = Company::where('id', '=', $employee->company_id)->get();
        else
            $companies = Company::all();
        return view('department.add', compact('companies', $companies));
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

        $department = Department::where('name', '=', $request->name)->count();
        if ($department > 0)
            return redirect('department/add')->withInput()->with('danger', 'Department already exists');

        $company = Company::where('id', '=', Input::get('company_id'))->first();
        $input = Input::all();
        $department = new Department($input);
        $department->company_id = $company->id;

        if ($department->save())
            return Redirect::route('departments', ['company_id' => $company->id])->with('success', 'Successfully added department!');
        else
            return Redirect::route('department.add')->withInput()->withErrors($department->errors());
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
        $department = Department::find($id);
        $did = Department::find($id)->company_id;
        $company = Company::find($department->company_id);
        return view('department.edit', compact('department', 'did', 'company'));
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

        $department = Department::find($id);
        $department_check = Department::where('name', '=', Input::get('name'))->get()->first();

        if ($department_check && $department_check->id != $id)
            return Redirect::route('department.edit', [$id])->withInput()->with('danger', 'Department already exists');

        $department->name = Input::get('name');
        $department->company_id = Input::get('company_id');

        if ($department->update())
            return Redirect::route('departments')->with('success', 'Successfully updated department!');
        else
            return Redirect::route('department.edit', [$id])->withInput()->withErrors($department->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $department = Department::findOrFail($id);
        $employees = Employee::where('dept_id', '=', $department->id)->first();

        if ($employees)
            return Redirect::route('departments')->with('danger', 'Department has employees linked to it');
        else {
            $department->delete();
            return Redirect::route('departments')->with('success', 'Department successfully deleted!');
        }
    }
}
