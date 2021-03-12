<?php

namespace App\Http\Controllers;

use App\Models\Functions\Functions;
use App\Models\Role\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Redirect;

class UserRoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('role.add');
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $roles = Role::where('description', '=', $request->description)->count();
        if ($roles > 0)
            return redirect('role/add')->withInput()->with('danger', 'Role already exists');

        $input = Input::all();
        $role = new Role($input);

        if(Input::get('createRole') == null && Input::get('updateRole') == null && Input::get('deleteRole') == null &&
        Input::get('addUser') == null && Input::get('updateUser') == null && Input::get('deleteUser') == null &&
        Input::get('addCountry') == null && Input::get('addCompany') == null && Input::get('addDept') == null &&
        Input::get('addTeam') == null && Input::get('addEmployeeType') == null && Input::get('addLeaveType') == null &&
        Input::get('updateCountry') == null && Input::get('updateCompany') == null && Input::get('updateDept') == null &&
        Input::get('updateTeam') == null && Input::get('updateEmployeeType') == null && Input::get('updateLeaveType') == null &&
        Input::get('deleteCountry') == null && Input::get('deleteCompany') == null && Input::get('deleteDept') == null &&
        Input::get('deleteTeam') == null && Input::get('deleteEmployeeType') == null && Input::get('deleteLeaveType') == null &&
        Input::get('addEmployee') == null && Input::get('updateEmployee') == null && Input::get('deleteEmployee') == null &&
        Input::get('attReg') == null && Input::get('leaveCreate') == null && Input::get('leaveUpdate') == null &&
        Input::get('settings') == null && Input::get('reports') == null)
            return Redirect::route('role.add')->withInput()->with('warning', 'At least one user function must be selected!');

        if ($role->save()) {
            $role = Role::where('description', '=', Input::get('description'))->first();

            if (Input::get('createRole') == 'on')
                $this->addFunction($role->id, 'Create User Role');

            if (Input::get('updateRole') == 'on')
                $this->addFunction($role->id, 'Update User Role');

            if (Input::get('deleteRole') == 'on')
                $this->addFunction($role->id, 'Delete User Role');

            if (Input::get('addUser') == 'on')
                $this->addFunction($role->id, 'Add User');

            if (Input::get('updateUser') == 'on')
                $this->addFunction($role->id, 'Update User');

            if (Input::get('deleteUser') == 'on')
                $this->addFunction($role->id, 'Delete User');

            if (Input::get('addCountry') == 'on')
                $this->addFunction($role->id, 'Add Country');

            if (Input::get('addCompany') == 'on')
                $this->addFunction($role->id, 'Add Company');

            if (Input::get('addDept') == 'on')
                $this->addFunction($role->id, 'Add Department');

            if (Input::get('addTeam') == 'on')
                $this->addFunction($role->id, 'Add Team');

            if (Input::get('addEmployeeType') == 'on')
                $this->addFunction($role->id, 'Add Employee Type');

            if (Input::get('addLeaveType') == 'on')
                $this->addFunction($role->id, 'Add Leave Type');

            if (Input::get('updateCountry') == 'on')
                $this->addFunction($role->id, 'Update Country');

            if (Input::get('updateCompany') == 'on')
                $this->addFunction($role->id, 'Update Company');

            if (Input::get('updateDept') == 'on')
                $this->addFunction($role->id, 'Update Department');

            if (Input::get('updateTeam') == 'on')
                $this->addFunction($role->id, 'Update Team');

            if (Input::get('updateEmployeeType') == 'on')
                $this->addFunction($role->id, 'Update Employee Type');

            if (Input::get('updateLeaveType') == 'on')
                $this->addFunction($role->id, 'Update Leave Type');

            if (Input::get('deleteCountry') == 'on')
                $this->addFunction($role->id, 'Delete Country');

            if (Input::get('deleteCompany') == 'on')
                $this->addFunction($role->id, 'Delete Company');

            if (Input::get('deleteDept') == 'on')
                $this->addFunction($role->id, 'Delete Department');

            if (Input::get('deleteTeam') == 'on')
                $this->addFunction($role->id, 'Delete Team');

            if (Input::get('deleteEmployeeType') == 'on')
                $this->addFunction($role->id, 'Delete Employee Type');

            if (Input::get('deleteLeaveType') == 'on')
                $this->addFunction($role->id, 'Delete Leave Type');

            if (Input::get('addEmployee') == 'on')
                $this->addFunction($role->id, 'Add Employee');

            if (Input::get('updateEmployee') == 'on')
                $this->addFunction($role->id, 'Update Employee');

            if (Input::get('deleteEmployee') == 'on')
                $this->addFunction($role->id, 'Delete Employee');

            if (Input::get('attReg') == 'on')
                $this->addFunction($role->id, 'Attendance Register');

            if (Input::get('leaveCreate') == 'on')
                $this->addFunction($role->id, 'Capture Leave');

            if (Input::get('leaveUpdate') == 'on')
                $this->addFunction($role->id, 'Approve Leave');

            if (Input::get('settings') == 'on')
                $this->addFunction($role->id, 'Settings');

            if (Input::get('reports') == 'on')
                $this->addFunction($role->id, 'View Reports');

            return Redirect::route('roles')->with('success', 'Successfully added user role!');
        } else
            return Redirect::route('role.add')->withInput()->withErrors($roles->errors());
    }
    public function addFunction($role_id, $description)
    {
        $function = Functions::where('description', '=', $description)
            ->where('role_id', '=', $role_id)->first();

        if (!$function) {
            $function = new Functions();
            $function->description = $description;
            $function->role_id = $role_id;
            $function->save();
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
        $role = Role::find($id);

        $function = Functions::where('description', 'like', '%' . 'eate User R'. '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $createRole = 'on';
        else
            $createRole = null;

        $function = Functions::where('description', 'like', '%' . 'date User R' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateRole = 'on';
        else
            $updateRole = null;

        $function = Functions::where('description', 'like', '%' . 'lete User R' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteRole = 'on';
        else
            $deleteRole = null;

        $function = Functions::where('description', 'like', '%' . 'd User')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addUser = 'on';
        else
            $addUser = null;

        $function = Functions::where('description', 'like', '%' . 'date User')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateUser = 'on';
        else
            $updateUser = null;

        $function = Functions::where('description', 'like', '%' . 'lete User')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteUser = 'on';
        else
            $deleteUser = null;

        $function = Functions::where('description', 'like', '%' . 'd Coun' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addCountry = 'on';
        else
            $addCountry = null;

        $function = Functions::where('description', 'like', '%' . 'd Comp' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addCompany = 'on';
        else
            $addCompany = null;

        $function = Functions::where('description', 'like', '%' . 'd Depa' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addDept = 'on';
        else
            $addDept = null;

        $function = Functions::where('description', 'like', '%' . 'd Team')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addTeam = 'on';
        else
            $addTeam = null;

        $function = Functions::where('description', 'like', '%' . 'd Employee T' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addEmployeeType = 'on';
        else
            $addEmployeeType = null;

        $function = Functions::where('description', 'like', '%' . 'd Leav' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addLeaveType = 'on';
        else
            $addLeaveType = null;

        $function = Functions::where('description', 'like', '%' . 'date Coun' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateCountry = 'on';
        else
            $updateCountry = null;

        $function = Functions::where('description', 'like', '%' . 'date Comp' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateCompany = 'on';
        else
            $updateCompany = null;

        $function = Functions::where('description', 'like', '%' . 'date Depa' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateDept = 'on';
        else
            $updateDept = null;

        $function = Functions::where('description', 'like', '%' . 'date Team')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateTeam = 'on';
        else
            $updateTeam = null;

        $function = Functions::where('description', 'like', '%' . 'date Employee T' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateEmployeeType = 'on';
        else
            $updateEmployeeType = null;

        $function = Functions::where('description', 'like', '%' . 'date Leav' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateLeaveType = 'on';
        else
            $updateLeaveType = null;

        $function = Functions::where('description', 'like', '%' . 'lete Coun' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteCountry = 'on';
        else
            $deleteCountry = null;

        $function = Functions::where('description', 'like', '%' . 'lete Comp' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteCompany = 'on';
        else
            $deleteCompany = null;

        $function = Functions::where('description', 'like', '%' . 'lete Depa' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteDept = 'on';
        else
            $deleteDept = null;

        $function = Functions::where('description', 'like', '%' . 'lete Team')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteTeam = 'on';
        else
            $deleteTeam = null;

        $function = Functions::where('description', 'like', '%' . 'lete Employee T' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteEmployeeType = 'on';
        else
            $deleteEmployeeType = null;

        $function = Functions::where('description', 'like', '%' . 'lete Leav' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteLeaveType = 'on';
        else
            $deleteLeaveType = null;

        $function = Functions::where('description', 'like', '%' . 'd Employee')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $addEmployee = 'on';
        else
            $addEmployee = null;

        $function = Functions::where('description', 'like', '%' . 'date Employee')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $updateEmployee = 'on';
        else
            $updateEmployee = null;

        $function = Functions::where('description', 'like', '%' . 'lete Employee')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $deleteEmployee = 'on';
        else
            $deleteEmployee = null;

        $function = Functions::where('description', 'like', '%' . 'egis' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $attReg = 'on';
        else
            $attReg = null;

        $function = Functions::where('description', 'like', '%' . 'ture' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $leaveCreate = 'on';
        else
            $leaveCreate = null;

        $function = Functions::where('description', 'like', '%' . 'ppro' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $leaveUpdate = 'on';
        else
            $leaveUpdate = null;

        $function = Functions::where('description', 'like', '%' . 'etti' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
            $settings = 'on';
        else
            $settings = null;

        $function = Functions::where('description', 'like', '%' . 'epor' . '%')
            ->where('role_id', '=', $role->id)->first();
        if ($function)
             $reports = 'on';
        else
            $reports = null;

        return view('role.edit', compact('role', 'createRole', 'updateRole', 'deleteRole', 'addUser', 'updateUser',
            'deleteUser', 'addCountry', 'addCompany', 'addDept', 'addTeam', 'addEmployeeType', 'addLeaveType',
            'updateCountry', 'updateCompany', 'updateDept', 'updateTeam', 'updateEmployeeType', 'updateLeaveType',
            'deleteCountry', 'deleteCompany', 'deleteDept', 'deleteTeam', 'deleteEmployeeType', 'deleteLeaveType',
            'addEmployee', 'updateEmployee', 'deleteEmployee', 'attReg', 'leaveCreate', 'leaveUpdate', 'settings', 'reports'));
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
        $role = Role::find($id);
        $role_check = Role::where('description', '=', Input::get('description'))->get()->first();

        if ($role_check && $role_check->id != $id)
            return Redirect::route('role.edit', [$id])->withInput()->with('danger', 'User role already exists');

        if(Input::get('createRole') == null && Input::get('updateRole') == null && Input::get('deleteRole') == null &&
        Input::get('addUser') == null && Input::get('updateUser') == null && Input::get('deleteUser') == null &&
        Input::get('addCountry') == null && Input::get('addCompany') == null && Input::get('addDept') == null &&
        Input::get('addTeam') == null && Input::get('addEmployeeType') == null && Input::get('addLeaveType') == null &&
        Input::get('updateCountry') == null && Input::get('updateCompany') == null && Input::get('updateDept') == null &&
        Input::get('updateTeam') == null && Input::get('updateEmployeeType') == null && Input::get('updateLeaveType') == null &&
        Input::get('deleteCountry') == null && Input::get('deleteCompany') == null && Input::get('deleteDept') == null &&
        Input::get('deleteTeam') == null && Input::get('deleteEmployeeType') == null && Input::get('deleteLeaveType') == null &&
        Input::get('addEmployee') == null && Input::get('updateEmployee') == null && Input::get('deleteEmployee') == null &&
        Input::get('attReg') == null && Input::get('leaveCreate') == null && Input::get('leaveUpdate') == null &&
        Input::get('settings') == null && Input::get('reports') == null)
            return Redirect::route('role.edit', [$id])->withInput()->with('warning', 'At least one user function must be selected!');

        $role->description = Input::get('description');

        if ($role->update())
        {
            $function = Functions::where('description', 'like', '%' . 'eate User R' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('createRole') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('createRole') == 'on')
                    $this->addFunction($role->id, 'Create User Role');
            }
            $function = Functions::where('description', 'like', '%' . 'date User R' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateRole') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateRole') == 'on')
                    $this->addFunction($role->id, 'Update User Role');
            }
            $function = Functions::where('description', 'like', '%' . 'lete User R' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteRole') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteRole') == 'on')
                    $this->addFunction($role->id, 'Delete User Role');
            }
            $function = Functions::where('description', 'like', '%' . 'd User')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addUser') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addUser') == 'on')
                    $this->addFunction($role->id, 'Add User');
            }
            $function = Functions::where('description', 'like', '%' . 'date User')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateUser') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateUser') == 'on')
                    $this->addFunction($role->id, 'Update User');
            }
            $function = Functions::where('description', 'like', '%' . 'lete User')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteUser') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteUser') == 'on')
                    $this->addFunction($role->id, 'Delete User');
            }

            $function = Functions::where('description', 'like', '%' . 'd Coun' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addCountry') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addCountry') == 'on')
                    $this->addFunction($role->id, 'Add Country');
            }
            $function = Functions::where('description', 'like', '%' . 'd Comp' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addCompany') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addCompany') == 'on')
                    $this->addFunction($role->id, 'Add Company');
            }
            $function = Functions::where('description', 'like', '%' . 'd Depa' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addDept') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addDept') == 'on')
                    $this->addFunction($role->id, 'Add Department');
            }
            $function = Functions::where('description', 'like', '%' . 'd Team')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addTeam') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addTeam') == 'on')
                    $this->addFunction($role->id, 'Add Team');
            }
            $function = Functions::where('description', 'like', '%' . 'd Employee T' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addEmployeeType') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addEmployeeType') == 'on')
                    $this->addFunction($role->id, 'Add Employee Type');
            }
            $function = Functions::where('description', 'like', '%' . 'd Leave' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addLeaveType') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addLeaveType') == 'on')
                    $this->addFunction($role->id, 'Add Leave Type');
            }
            $function = Functions::where('description', 'like', '%' . 'date Coun' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateCountry') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateCountry') == 'on')
                    $this->addFunction($role->id, 'Update Country');
            }
            $function = Functions::where('description', 'like', '%' . 'date Comp' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateCompany') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateCompany') == 'on')
                    $this->addFunction($role->id, 'Update Company');
            }
            $function = Functions::where('description', 'like', '%' . 'date Depa' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateDept') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateDept') == 'on')
                    $this->addFunction($role->id, 'Update Department');
            }
            $function = Functions::where('description', 'like', '%' . 'date Team')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateTeam') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateTeam') == 'on')
                    $this->addFunction($role->id, 'Update Team');
            }
            $function = Functions::where('description', 'like', '%' . 'date Employee T' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateEmployeeType') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateEmployeeType') == 'on')
                    $this->addFunction($role->id, 'Update Employee Type');
            }
            $function = Functions::where('description', 'like', '%' . 'date Leave' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateLeaveType') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateLeaveType') == 'on')
                    $this->addFunction($role->id, 'Update Leave Type');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Coun' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteCountry') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteCountry') == 'on')
                    $this->addFunction($role->id, 'Delete Country');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Comp' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteCompany') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteCompany') == 'on')
                    $this->addFunction($role->id, 'Delete Company');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Depa' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteDept') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteDept') == 'on')
                    $this->addFunction($role->id, 'Delete Department');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Team')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteTeam') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteTeam') == 'on')
                    $this->addFunction($role->id, 'Delete Team');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Employee T' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteEmployeeType') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteEmployeeType') == 'on')
                    $this->addFunction($role->id, 'Delete Employee Type');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Leave' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteLeaveType') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteLeaveType') == 'on')
                    $this->addFunction($role->id, 'Delete Leave Type');
            }
            $function = Functions::where('description', 'like', '%' . 'd Employee')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('addEmployee') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('addEmployee') == 'on')
                    $this->addFunction($role->id, 'Add Employee');
            }
            $function = Functions::where('description', 'like', '%' . 'date Employee')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('updateEmployee') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('updateEmployee') == 'on')
                    $this->addFunction($role->id, 'Update Employee');
            }
            $function = Functions::where('description', 'like', '%' . 'lete Employee')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('deleteEmployee') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('deleteEmployee') == 'on')
                    $this->addFunction($role->id, 'Delete Employee');
            }
            $function = Functions::where('description', 'like', '%' . 'egist' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('attReg') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('attReg') == 'on')
                    $this->addFunction($role->id, 'Attendance Register');
            }
            $function = Functions::where('description', 'like', '%' . 'ture' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('leaveCreate') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('leaveCreate') == 'on')
                    $this->addFunction($role->id, 'Capture Leave');
            }
            $function = Functions::where('description', 'like', '%' . 'ppro' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('leaveUpdate') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('leaveUpdate') == 'on')
                    $this->addFunction($role->id, 'Approve Leave');
            }
            $function = Functions::where('description', 'like', '%' . 'ttin' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('settings') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('settings') == 'on')
                    $this->addFunction($role->id, 'Settings');
            }
            $function = Functions::where('description', 'like', '%' . 'port' . '%')
                ->where('role_id', '=', $role->id)->first();
            if ($function) {
                if (Input::get('reports') !== 'on')
                    $function->delete();
            } else {
                if (Input::get('reports') == 'on')
                    $this->addFunction($role->id, 'View Reports');
            }
            // update all the users using that role
            $users = User::where('role_id', '=', $role->id)->get();
            foreach ($users as $user)
            {
                $user->createRole = 'N'; $user->updateRole = 'N'; $user->DeleteRole = 'N';
                $user->addUser = 'N'; $user->updateUser = 'N'; $user->DeleteUser = 'N';
                $user->addCountry = 'N'; $user->updateCountry = 'N'; $user->DeleteCountry = 'N';
                $user->addCompany = 'N'; $user->updateCompany = 'N'; $user->DeleteCompany = 'N';
                $user->addDept = 'N'; $user->updateDept = 'N'; $user->DeleteDept = 'N';
                $user->addTeam = 'N'; $user->updateTeam = 'N'; $user->DeleteTeam = 'N';
                $user->addEmployeeType = 'N'; $user->updateEmployeeType = 'N'; $user->DeleteEmployeeType = 'N';
                $user->addLeaveType = 'N'; $user->updateLeaveType = 'N'; $user->DeleteLeaveType = 'N';
                $user->addEmployee = 'N'; $user->updateEmployee = 'N'; $user->DeleteEmployee = 'N';
                $user->attReg = 'N'; $user->leaveCapture = 'N'; $user->leaveApprove = 'N';
                $user->settings = 'N'; $user->reportView = 'N';

                $functions = Functions::where('role_id', '=', $role->id)->get();
                foreach ($functions as $function) {
                    if ($function->description == 'Create User Role')
                        $user->createRole = 'Y';
                    if ($function->description == 'Update User Role')
                        $user->updateRole = 'Y';
                    if ($function->description == 'Delete User Role')
                        $user->deleteRole = 'Y';
                    if ($function->description == 'Add User')
                        $user->addUser = 'Y';
                    if ($function->description == 'Update User')
                        $user->updateUser = 'Y';
                    if ($function->description == 'Delete User')
                        $user->deleteUser = 'Y';
                    if ($function->description == 'Add Country')
                        $user->addCountry = 'Y';
                    if ($function->description == 'Add Company')
                        $user->addCompany = 'Y';
                    if ($function->description == 'Add Department')
                        $user->addDept = 'Y';
                    if ($function->description == 'Add Team')
                        $user->addTeam = 'Y';
                    if ($function->description == 'Add Employee Type')
                        $user->addEmployeeType = 'Y';
                    if ($function->description == 'Add Leave Type')
                        $user->addLeaveType = 'Y';
                    if ($function->description == 'Add Employee')
                        $user->addEmployee = 'Y';
                    if ($function->description == 'Update Country')
                        $user->updateCountry = 'Y';
                    if ($function->description == 'Update Company')
                        $user->updateCompany = 'Y';
                    if ($function->description == 'Update Department')
                        $user->updateDept = 'Y';
                    if ($function->description == 'Update Team')
                        $user->updateTeam = 'Y';
                    if ($function->description == 'Update Employee Type')
                        $user->updateEmployeeType = 'Y';
                    if ($function->description == 'Update Leave Type')
                        $user->updateLeaveType = 'Y';
                    if ($function->description == 'Update Employee')
                        $user->updateEmployee = 'Y';
                    if ($function->description == 'Delete Country')
                        $user->deleteCountry = 'Y';
                    if ($function->description == 'Delete Company')
                        $user->deleteCompany = 'Y';
                    if ($function->description == 'Delete Department')
                        $user->deleteDept = 'Y';
                    if ($function->description == 'Delete Team')
                        $user->deleteTeam = 'Y';
                    if ($function->description == 'Delete Employee Type')
                        $user->deleteEmployeeType = 'Y';
                    if ($function->description == 'Delete Leave Type')
                        $user->deleteLeaveType = 'Y';
                    if ($function->description == 'Delete Employee')
                        $user->deleteEmployee = 'Y';
                    if ($function->description == 'Attendance Register')
                        $user->attReg = 'Y';
                    if ($function->description == 'Capture Leave')
                        $user->leaveCapture = 'Y';
                    if ($function->description == 'Approve Leave')
                        $user->leaveApprove = 'Y';
                    if ($function->description == 'Settings')
                        $user->settings = 'Y';
                    if ($function->description == 'View Reports')
                        $user->reportView = 'Y';
                }
                $user->update();
            }
            return Redirect::route('roles')->with('success', 'Successfully updated user role!');
        } else
            return Redirect::route('role.edit', [$id])->withInput()->withErrors($role->errors());
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
