<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\EmployeeType\EmployeeType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class EmployeeTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $employeeTypes = DB::table('employeeTypes')->get();
        return view('employeeType.index', ['employeeTypes' => $employeeTypes]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('employeeType.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $employeeTypes = EmployeeType::where('employee_type', '=', $request->employee_type)->count();
        if ($employeeTypes > 0)
            return redirect('employeeType/add')->withInput()->with('danger', 'Employee Type already exists');

        $input = Input::all();
        $employeeTypes = new EmployeeType($input);

        if ($employeeTypes->save())
            return Redirect::route('employeeTypes')->with('success', 'Successfully added employee type!');
        else
            return Redirect::route('employeeType.add')->withInput()->withErrors($employeeTypes->errors());
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
        $employeeTypes = EmployeeType::find($id);
        return view('employeeType.edit', ['employeeTypes' => $employeeTypes]);
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
        $employeeType = EmployeeType::find($id);
        $employeeType_check = EmployeeType::where('employee_type', '=', Input::get('employee_type'))->get()->first();

        if ($employeeType_check && $employeeType_check->id != $id)
            return Redirect::route('employeeType.edit', [$id])->withInput()->with('danger', 'Employee Type already exists');

        $employeeType->employee_type = Input::get('employee_type');

        if ($employeeType->update())
            return Redirect::route('employeeTypes')->with('success', 'Successfully updated employee type!');
        else
            return Redirect::route('employeeType.edit', [$id])->withInput()->withErrors($employeeType->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $employeeType = EmployeeType::findOrFail($id);
        $employee = Employee::where('employeeType_id', '=', $employeeType->id)->first();

        if ($employee)
            return Redirect::route('employeeTypes')->with('danger', 'Employee type has employees linked to it');
        else {
            $employeeType->delete();
            return Redirect::route('employeeTypes')->with('success', 'Employee type successfully deleted!');
        }
    }
}
