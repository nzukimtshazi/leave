<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Department\Department;
use App\Models\Employee\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class DepartmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if(Auth::user()->user_role == 'Management') {
            $departments = DB::table('departments')->get();
        } else {
            $employee = Employee::where('name', '=', Auth::user()->name)
            ->where('surname', '=', Auth::user()->surname)->first();
            $departments = Department::where('company_id', '=', $employee->company_id)->get();
        }
        return view('department.index', ['departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        if(Auth::user()->user_role == 'Management')
            $companies = Company::all('id', 'name');
        else {
            $employee = Employee::where('name', '=', Auth::user()->name)
                ->where('surname', '=', Auth::user()->surname)->first();
            $companies = Company::where('id', '=', $employee->company_id)->get();
        }
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
        $department = Department::where('name', '=', $request->name)->count();
        if ($department > 0)
            return redirect('department/add')->withInput()->with('danger', 'Department already exists');

        $company = Company::where('id', '=', Input::get('company_id'))->first();
        $input = Input::all();
        $department = new Department($input);

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
        if(Auth::user()->user_role == 'Management')
            $companies = Company::all('id', 'name');
        else {
            $employee = Employee::where('name', '=', Auth::user()->name)
                ->where('surname', '=', Auth::user()->surname)->first();
            $companies = Company::where('id', '=', $employee->company_id)->get();
        }
        return view('department.edit', compact('companies', 'department', 'did'));
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
        $department = Department::find($id);
        $department_check = Department::where('name', '=', Input::get('name'))->get()->first();

        if ($department_check && $department_check->id != $id)
            return Redirect::route('department.edit', [$id])->withInput()->with('danger', 'Department already exists');

        $department->name = Input::get('name');

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
