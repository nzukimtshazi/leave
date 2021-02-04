<?php

namespace App\Http\Controllers;

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
        return view('user.create');
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
        $user = new User($input);
        $user->password = Hash::make(Input::get('password'));

        $exists = User::where('email', $user->email)->first();
        if ($exists) {
            return Redirect::route('user.create')->withInput()->with('danger', 'User with email "' . $user->email . '" already exists!');
        }

        if ($user->save())
            return Redirect::route('users')->with('success', 'Successfully added user!');
        else
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
