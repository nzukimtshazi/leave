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
        return view('user.index', compact('users'));
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
        if (Input::get('country') == null && Input::get('company') == null && Input::get('department') == null &&
            Input::get('team') == null && Input::get('employeeType') == null && Input::get('leaveType') == null &&
            Input::get('employee') == null && Input::get('attReg') == null && Input::get('leave') == null &&
            Input::get('reports') == null && Input::get('user_role') == null && Input::get('crud_user') == null)
            return Redirect::route('user.add')->withInput()->with('warning', 'At least one user function must be selected!');

        $role = Role::find(Input::get('role_id'));
        if (Input::get('country') == 'on') {
            $user->countryCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Country');
        }
        if (Input::get('company') == 'on') {
            $user->companyCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Company');
        }
        if (Input::get('department') == 'on') {
            $user->departmentCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Department');
        }
        if (Input::get('team') == 'on') {
            $user->teamCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Team');
        }
        if (Input::get('employeeType') == 'on') {
            $user->employeeTypeCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Employee Type');
        }
        if (Input::get('leaveType') == 'on') {
            $user->leaveTypeCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Leave Type');
        }
        if (Input::get('employee') == 'on') {
            $user->employeeCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Employee');
        }
        if (Input::get('attReg') == 'on') {
            $user->attReg = 'Y';
            $this->addFunctions($role->id, 'Add Attendance Register');
        }
        if (Input::get('leave') == 'on') {
            $user->leaveCRUD = 'Y';
            $this->addFunctions($role->id, 'Capture Leave');
        }
        if (Input::get('settings') == 'on') {
            $user->settings = 'Y';
            $this->addFunctions($role->id, 'Settings');
        }
        if (Input::get('reports') == 'on') {
            $user->reportView = 'Y';
            $this->addFunctions($role->id, 'View Reports');
        }
        if (Input::get('user_role') == 'on') {
            $user->roleCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD User role');
        }
        if (Input::get('crud_user') == 'on') {
            $user->userCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD User');
        }
        if ($user->save()) {
            return Redirect::route('users')->with('success', 'Successfully added user!');
        } else
            return Redirect::route('user.create')->withInput()->withErrors($user->errors());
    }
    public function addFunctions($role_id, $description)
    {
        $functions = Functions::where('description', '=', $description)
            ->where('role_id', '=', $role_id)->first();

        if (!$functions) {
            $functions = new Functions();
            $functions->description = $description;
            $functions->role_id = $role_id;
            $functions->save();
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
        $user = User::find($id);
        $roles = Role::all();

        if ($user->countryCRUD == 'Y')
            $country = 'on';
        else
            $country = null;
        if ($user->companyCRUD == 'Y')
            $company = 'on';
        else
            $company = null;
        if ($user->departmentCRUD == 'Y')
            $department = 'on';
        else
            $department = null;
        if ($user->teamCRUD == 'Y')
            $team = 'on';
        else
            $team = null;
        if ($user->employeeTypeCRUD == 'Y')
            $employeeType = 'on';
        else
            $employeeType = null;
        if ($user->leaveTypeCRUD == 'Y')
            $leaveType = 'on';
        else
            $leaveType = null;
        if ($user->employeeCRUD == 'Y')
            $employee = 'on';
        else
            $employee = null;
        if ($user->attReg == 'Y')
            $attReg = 'on';
        else
            $attReg = null;
        if ($user->leaveCRUD == 'Y')
            $leave = 'on';
        else
            $leave = null;
        if ($user->settings = 'Y')
            $settings = 'on';
        else
            $settings = null;
        if ($user->reportView == 'Y')
            $reports = 'on';
        else
            $reports = null;
        if ($user->roleCRUD == 'Y')
            $user_role = 'on';
        else
            $user_role = null;
        if ($user->userCRUD == 'Y')
            $crud_user = 'on';
        else
            $crud_user = null;

        return view('user.edit', compact('user', 'roles', 'country', 'company', 'department', 'team', 'employeeType',
            'leaveType', 'employee', 'attReg', 'leave', 'settings', 'reports', 'user_role', 'crud_user'));
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

        if (Input::get('country') == null && Input::get('company') == null && Input::get('department') == null &&
            Input::get('team') == null && Input::get('employeeType') == null && Input::get('leaveType') == null &&
            Input::get('employee') == null && Input::get('attReg') == null && Input::get('leave') == null &&
            Input::get('reports') == null && Input::get('user_role') == null && Input::get('crud_user') == null)
            return Redirect::route('user.edit', [$id])->withInput()->with('warning', 'At least one user function must be selected!');

        $user = User::find($id);
        $user->name = Input::get('name');
        $user->surname = Input::get('surname');
        $user->email = Input::get('email');
        $user->role_id = Input::get('role_id');

        if ((Input::get('password')) != $user->password)
            $user->password = Hash::make(Input::get('password'));

        $exists = User::where('email', $user->email)->first();
        if ($exists  && $exists->id != $id) {
            return Redirect::route('user.edit', [$id])->withInput()->with('danger', 'User with email "' . $user->email . '" already exists!');
        }
        $role = Role::find(Input::get('role_id'));
        if (Input::get('country') == 'on') {
            $user->countryCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Country');
        } else
            $user->countryCRUD = 'N';

        if (Input::get('company') == 'on') {
            $user->companyCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Company');
        } else
            $user->companyCRUD = 'N';

        if (Input::get('department') == 'on') {
            $user->departmentCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Department');
        } else
            $user->departmentCRUD = 'N';

        if (Input::get('team') == 'on') {
            $user->teamCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Team');
        } else
            $user->teamCRUD = 'N';

        if (Input::get('employeeType') == 'on') {
            $user->employeeTypeCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Employee Type');
        } else
            $user->employeeTypeCRUD = 'N';

        if (Input::get('leaveType') == 'on') {
            $user->leaveTypeCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Leave Type');
        } else
            $user->leaveTypeCRUD = 'N';

        if (Input::get('employee') == 'on') {
            $user->employeeCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD Employee');
        } else
            $user->employeeCRUD = 'N';

        if (Input::get('attReg') == 'on') {
            $user->attReg = 'Y';
            $this->addFunctions($role->id, 'Add Attendance Register');
        } else
            $user->attReg = 'N';

        if (Input::get('leave') == 'on') {
            $user->leaveCRUD = 'Y';
            $this->addFunctions($role->id, 'Capture Leave');
        } else
            $user->leaveCRUD = 'N';

        if (Input::get('settings') == 'on') {
            $user->settings = 'Y';
            $this->addFunctions($role->id, 'Settings');
        } else
            $user->settings = 'N';

        if (Input::get('reports') == 'on') {
            $user->reportView = 'Y';
            $this->addFunctions($role->id, 'View Reports');
        } else
            $user->reportView = 'N';

        if (Input::get('user_role') == 'on') {
            $user->roleCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD User role');
        } else
            $user->roleCRUD = 'N';

        if (Input::get('crud_user') == 'on') {
            $user->userCRUD = 'Y';
            $this->addFunctions($role->id, 'CRUD User');
        } else
            $user->userCRUD = 'N';

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
