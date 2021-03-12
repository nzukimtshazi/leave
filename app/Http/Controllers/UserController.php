<?php

namespace App\Http\Controllers;

use App\Models\Functions\Functions;
use App\Models\Role\Role;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use Session;
use Illuminate\Support\Facades\Input;

class UserController extends Controller
{
    /**
     * Define your validation rules in a property in
     * the controller to reuse the rules.
     */
    protected $validationRules=[
        'role_id' => 'required|numeric|digits_between:1,9999',
    ];
    /**
     * Display a listing of the resource.
     *
* @return \Illuminate\Http\Response
*/
    public function index()
    {
        $users = User::all();
        $roles = Role::all();
        return view('user.index', compact('users', 'roles'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $roles = Role::all();
        return view('user.create', compact('roles'));
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

        $input = Input::all();
        $user = new User($input);
        $user->password = Hash::make(Input::get('password'));

        $exists = User::where('email', $user->email)->first();
        if ($exists) {
            return Redirect::route('user.create')->withInput()->with('danger', 'User with email "' . $user->email . '" already exists!');
        }
        $functions = Functions::where('role_id', '=', Input::get('role_id'))->get();
        foreach ($functions as $function)
        {
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
            if ($function->description == 'Add Employee')
                $user->addEmployee = 'Y';
            if ($function->description == 'Update Employee')
                $user->updateEmployee = 'Y';
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
        if ($user->save()) {
            return Redirect::route('users')->with('success', 'Successfully added user!');
        } else
            return Redirect::route('user.create')->withInput()->withErrors($user->errors());
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
        $user = User::find($id);
        $roles = Role::all();

        return view('user.edit', compact('user', 'roles'));
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

        $user = User::find($id);
        $user->name = Input::get('name');
        $user->surname = Input::get('surname');
        $user->email = Input::get('email');
        $user->createRole = 'N'; $user->updateRole = 'N'; $user->deleteRole = 'N';
        $user->addUser = 'N'; $user->updateUser = 'N'; $user->deleteUser = 'N';
        $user->addCountry = 'N'; $user->updateCountry = 'N'; $user->deleteCountry = 'N';
        $user->addCompany = 'N'; $user->updateCompany = 'N'; $user->deleteCompany = 'N';
        $user->addDept = 'N'; $user->updateDept = 'N'; $user->deleteDept = 'N';
        $user->addTeam = 'N'; $user->updateTeam = 'N'; $user->deleteTeam = 'N';
        $user->addEmployeeType = 'N'; $user->updateEmployeeType = 'N'; $user->deleteEmployeeType = 'N';
        $user->addLeaveType = 'N'; $user->updateLeaveType = 'N'; $user->deleteLeaveType = 'N';
        $user->addEmployee = 'N'; $user->updateEmployee = 'N'; $user->deleteEmployee = 'N';
        $user->attReg = 'N';
        $user->leaveCapture = 'N';
        $user->leaveApprove = 'N';
        $user->settings = 'N';
        $user->reportView = 'N';
        $user->role_id = Input::get('role_id');

        if ((Input::get('password')) != $user->password)
            $user->password = Hash::make(Input::get('password'));

        $exists = User::where('email', $user->email)->first();
        if ($exists  && $exists->id != $id) {
            return Redirect::route('user.edit', [$id])->withInput()->with('danger', 'User with email "' . $user->email . '" already exists!');
        }
        $functions = Functions::where('role_id', '=', Input::get('role_id'))->get();
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
            if ($function->description == 'Add Employee')
                $user->addEmployee = 'Y';
            if ($function->description == 'Update Employee')
                $user->updateEmployee = 'Y';
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
        if ($user->update())
            return Redirect::route('users')->with('success', 'Successfully updated user!');
        else
            return Redirect::route('user.edit', [$id])->withInput()->withErrors($user->errors());
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
    public function showLogin()
    {
        // show the form
        return view('user.login');
    }
    public function doLogin()
    {
        // validate the info, create rules for the inputs
        $users = User::where('email', '=', Input::get('email'))->get();

        //check if email address exists
        if ($users -> isEmpty()) {
            return Redirect::to('login')
                ->withInput(Input::except('password'))// send back the input (not the password) so that we can repopulate the form
                ->with('danger', 'Sorry, email address does not exist!');
        }

        foreach ($users as $user)
        {
            $rules = array(
                'email' => 'required|email', // make sure the email is an actual email
                'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
            );

            // run the validation rules on the inputs from the form
            $validator = Validator::make(Input::all(), $rules);

            // if the validator fails, redirect back to the form
            if ($validator->fails()) {
                return Redirect::to('login')
                    ->withErrors($validator)// send back all errors to the login form
                    ->withInput(Input::except('password'))// send back the input (not the password) so that we can repopulate the form
                    ->with('danger', 'Your login failed. Please try again.');
            } else
                {
                // create our user data for the authentication
                $userData = array(
                    'email' => Input::get('email'),
                    'password' => Input::get('password')
                );

                // attempt to do the login
                if (Auth::attempt($userData, true))
                {
                    return redirect('dashboard');
                } else
                    {
                     // validation not successful, send back to form
                    return Redirect::to('login')
                        ->withErrors($validator)// send back all errors to the login form
                        ->withInput(Input::except('password'))// send back the input (not the password) so that we can repopulate the form
                        ->with('danger', 'Your login failed. Please try again.');
                }
            }
        }

    }
    public function doLogout()
    {
        Auth::logout(); // log the user out of our application
        return Redirect::to('login'); // redirect the user to the login screen
    }
}
