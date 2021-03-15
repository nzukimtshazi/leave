<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// route to list users
Route::get('users', ['as' => 'users','uses' => 'UserController@index']);

// add user
Route::get('user/add', ['as' => 'user.add','uses' => 'UserController@add']);

// store user
Route::post('user/store', ['as' => 'user.store','uses' => 'UserController@store']);

// edit user
Route::get('user/edit/{id}', ['as' => 'user.edit','uses' => 'UserController@edit']);

// update user
Route::PATCH('user/update/{id}', ['as' => 'user.update','uses' => 'UserController@update']);

// delete user
Route::get('user/destroy/{id}', ['as' => 'user.destroy','uses' => 'UserController@destroy']);

// route to list countries
Route::get('countries', ['as' => 'countries','uses' => 'CountryController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add country
Route::get('country/add', ['as' => 'country.add','uses' => 'CountryController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store country
Route::post('country/store', ['as' => 'country.store','uses' => 'CountryController@store']);

// edit country
Route::get('country/edit/{id}', ['as' => 'country.edit','uses' => 'CountryController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update country
Route::PATCH('country/update/{id}', ['as' => 'country.update','uses' => 'CountryController@update']);

// delete country
Route::get('country/destroy/{id}', ['as' => 'country.destroy','uses' => 'CountryController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list companies
Route::get('companies', ['as' => 'companies','uses' => 'CompanyController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add company
Route::get('company/add', ['as' => 'company.add','uses' => 'CompanyController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store company
Route::post('company/store', ['as' => 'company.store','uses' => 'CompanyController@store']);

// edit company
Route::get('company/edit/{id}', ['as' => 'company.edit','uses' => 'CompanyController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update company
Route::PATCH('company/update/{id}', ['as' => 'company.update','uses' => 'CompanyController@update']);

// delete company
Route::get('company/destroy/{id}', ['as' => 'company.destroy','uses' => 'CompanyController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

// edit departments linked to a company
Route::get('company/departments/{id}', ['as' => 'company.departments','uses' => 'CompanyController@departments', 'middleware' => 'myMiddleware'])->middleware('auth');

// get the departments for the selected company
Route::get('ajax-company-department/{id}', ['as' => 'companies.ajaxDepartment','uses' => 'CompanyController@ajaxDepartments', 'middleware' => 'myMiddleware'])->middleware('auth');

// edit teams linked to a company
Route::get('company/teams/{id}', ['as' => 'company.teams','uses' => 'CompanyController@teams', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list departments
Route::get('departments', ['as' => 'departments','uses' => 'DepartmentController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add department
Route::get('department/add', ['as' => 'department.add','uses' => 'DepartmentController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store department
Route::post('department/store', ['as' => 'department.store','uses' => 'DepartmentController@store']);

// edit department
Route::get('department/edit/{id}', ['as' => 'department.edit','uses' => 'DepartmentController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update department
Route::PATCH('department/update/{id}', ['as' => 'department.update','uses' => 'DepartmentController@update']);

// delete department
Route::get('department/destroy/{id}', ['as' => 'department.destroy','uses' => 'DepartmentController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list teams
Route::get('teams', ['as' => 'teams','uses' => 'TeamController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add team
Route::get('team/add', ['as' => 'team.add','uses' => 'TeamController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store team
Route::post('team/store', ['as' => 'team.store','uses' => 'TeamController@store']);

// edit team
Route::get('team/edit/{id}', ['as' => 'team.edit','uses' => 'TeamController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update team
Route::PATCH('team/update/{id}', ['as' => 'team.update','uses' => 'TeamController@update']);

// delete team
Route::get('team/destroy/{id}', ['as' => 'team.destroy','uses' => 'TeamController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list employees
Route::get('employees', ['as' => 'employees','uses' => 'EmployeeController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add employee
Route::get('employee/add', ['as' => 'employee.add','uses' => 'EmployeeController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store employee
Route::post('employee/store', ['as' => 'employee.store','uses' => 'EmployeeController@store']);

// edit employee
Route::get('employee/edit/{id}', ['as' => 'employee.edit','uses' => 'EmployeeController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update employee
Route::PATCH('employee/update/{id}', ['as' => 'employee.update','uses' => 'EmployeeController@update']);

// terminate employee's employment
Route::get('employee/destroy/{id}', ['as' => 'employee.destroy','uses' => 'EmployeeController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list leave types
Route::get('leaveTypes', ['as' => 'leaveTypes','uses' => 'LeaveTypeController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add leave type
Route::get('leaveType/add', ['as' => 'leaveType.add','uses' => 'LeaveTypeController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store leave type
Route::post('leaveType/store', ['as' => 'leaveType.store','uses' => 'LeaveTypeController@store']);

// edit leave type
Route::get('leaveType/edit/{id}', ['as' => 'leaveType.edit','uses' => 'LeaveTypeController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update leave type
Route::PATCH('leaveType/update/{id}', ['as' => 'leaveType.update','uses' => 'LeaveTypeController@update']);

// delete leave type
Route::get('leaveType/destroy/{id}', ['as' => 'leaveType.destroy','uses' => 'LeaveTypeController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

// leave route
Route::get('leaves', ['as' => 'leaves','uses' => 'LeaveController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to capture leave for an employee
Route::get('leave/add', ['as' => 'leave.add','uses' => 'LeaveController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store leave
Route::post('leave/store', ['as' => 'leave.store','uses' => 'LeaveController@store']);

// edit leave
Route::get('leave/edit/{id}', ['as' => 'leave.edit','uses' => 'LeaveController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update leave
Route::PATCH('leave/update/{id}', ['as' => 'leave.update','uses' => 'LeaveController@update']);

// approve leave
Route::get('leave/approve/{id}', ['as' => 'leave.approve','uses' => 'LeaveController@approve', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list annual leave balances
Route::get('reports/annualLeave', ['as' => 'reports.annualLeave','uses' => 'ReportController@annualLeave', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list sick leave balances
Route::get('reports/sickLeave', ['as' => 'reports.sickLeave','uses' => 'ReportController@sickLeave', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to report on settings
Route::get('settings', ['as' => 'settings','uses' => 'SettingsController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

//get the dashboard screen
Route::get('dashboard', ['as' => 'dashboard.view','uses' => 'DashboardController@dashboard'])->middleware('auth');

// get the companies for the selected country
Route::get('ajax-country-company/{id}', ['as' => 'countries.ajaxCompanies','uses' => 'CountryController@ajaxCompanies', 'middleware' => 'myMiddleware'])->middleware('auth');

// get the teams for the selected company
Route::get('ajax-company-team/{id}', ['as' => 'companies.ajaxTeam','uses' => 'CompanyController@ajaxTeams', 'middleware' => 'myMiddleware'])->middleware('auth');

// add hours worked by employees
Route::get('attendanceRegister/search', ['as' => 'attendanceRegister.search','uses' => 'AttendanceRegisterController@search', 'middleware' => 'myMiddleware'])->middleware('auth');

// add hours worked by employees
Route::get('attendanceRegister/add', ['as' => 'attendanceRegister.add','uses' => 'AttendanceRegisterController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store storing hours worked by employees
Route::post('attendanceRegister/store', ['as' => 'attendanceRegister.store','uses' => 'AttendanceRegisterController@store']);

// route to paginate to the left
Route::get('paginateLeft', ['as' => 'paginateLeft','uses' => 'AttendanceRegisterController@paginateLeft', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to paginate to the right
Route::get('paginateRight', ['as' => 'paginateRight','uses' => 'AttendanceRegisterController@paginateRight', 'middleware' => 'myMiddleware'])->middleware('auth');

// show the login form
Route::get('login', ['as' => 'login','uses' => 'UserController@showLogin']);

// process the login form
Route::post('login', array('uses' => 'UserController@doLogin'));

// process the logout
Route::get('users/logout', ['as' => 'logout','uses' => 'UserController@doLogout']);

// route to list employee types
Route::get('employeeTypes', ['as' => 'employeeTypes','uses' => 'EmployeeTypeController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// add employee type
Route::get('employeeType/add', ['as' => 'employeeType.add','uses' => 'EmployeeTypeController@add', 'middleware' => 'myMiddleware'])->middleware('auth');

// store employee type
Route::post('employeeType/store', ['as' => 'employeeType.store','uses' => 'EmployeeTypeController@store']);

// edit employee type
Route::get('employeeType/edit/{id}', ['as' => 'employeeType.edit','uses' => 'EmployeeTypeController@edit', 'middleware' => 'myMiddleware'])->middleware('auth');

// update employee type
Route::PATCH('employeeType/update/{id}', ['as' => 'employeeType.update','uses' => 'EmployeeTypeController@update']);

// delete employee type
Route::get('employeeType/destroy/{id}', ['as' => 'employeeType.destroy','uses' => 'EmployeeTypeController@destroy', 'middleware' => 'myMiddleware'])->middleware('auth');

//route to display calendar view
Route::get('calendar/index', ['as' => 'calendar.index','uses' => 'CalendarController@index', 'middleware' => 'myMiddleware'])->middleware('auth');

// get the ajaxfunction for employee names
Route::get('getNameData', ['as' => 'getNameData','uses' => 'EmployeeController@getNameData', 'middleware' => 'myMiddleware'])->middleware('auth');

// route to list employee types
Route::get('roles', ['as' => 'roles','uses' => 'UserRoleController@index']);

// add user role
Route::get('role/add', ['as' => 'role.add','uses' => 'UserRoleController@add']);

// store user role
Route::post('role/store', ['as' => 'role.store','uses' => 'UserRoleController@store']);

// edit user role
Route::get('role/edit/{id}', ['as' => 'role.edit','uses' => 'UserRoleController@edit']);

// update user role
Route::PATCH('role/update/{id}', ['as' => 'role.update','uses' => 'UserRoleController@update']);




