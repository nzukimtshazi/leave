<!-- app/views/user/edit.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- Edit User Form... -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Update User {!! $user->name !!} {!! $user->surname !!}</h3>
                </div>

                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}

                    {!! Form::model($user, ['method' => 'PATCH', 'route' => ['user.update', $user->id]]) !!}

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', $user->name, array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('surname', 'Surname') !!}
                                {!! Form::text('surname', $user->surname, array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('role_id', 'User role') !!}
                                <select class="form-control input-sm" required name="role_id" id="role_id">
                                    @foreach($roles as $role)
                                        @if($role['id'] == $user['role_id'])
                                            <option value="{{$user['role_id']}}" selected="{{$user['role_id']}}">{{$role['description']}}</option>
                                        @else
                                            <option value="{{$role->id}}">{{$role->description}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::email('email', $user->email, array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row>">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                <input class = 'form-control input-sm' type = "password" required name="password" id="password" value= "{!!$user->password !!}" >
                            </div>
                        </div>
                    </div><br>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="form-group">
                                <strong><p>User role functions: <input type="checkbox" id="selectAll"></p></strong>
                                <strong><p>  CRUD is CREATE, READ/EDIT, UPDATE and DELETE </p></strong>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($country === 'on')
                                        <input type="checkbox" name="country" checked="">
                                    @else
                                        <input type="checkbox" name="country" {{ old('country') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Country
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($company === 'on')
                                        <input type="checkbox" name="company" checked="">
                                    @else
                                        <input type="checkbox" name="company" {{ old('company') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Company
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($department === 'on')
                                        <input type="checkbox" name="department" checked="">
                                    @else
                                        <input type="checkbox" name="department" {{ old('department') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Department
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($team === 'on')
                                        <input type="checkbox" name="team" checked="">
                                    @else
                                        <input type="checkbox" name="team" {{ old('team') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Team
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($employeeType === 'on')
                                        <input type="checkbox" name="employeeType" checked="">
                                    @else
                                        <input type="checkbox" name="employeeType" {{ old('employeeType') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Employee Type
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($leaveType === 'on')
                                        <input type="checkbox" name="leaveType" checked="">
                                    @else
                                        <input type="checkbox" name="leaveType" {{ old('leaveType') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Leave Type
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($employee === 'on')
                                        <input type="checkbox" name="employee" checked="">
                                    @else
                                        <input type="checkbox" name="employee" {{ old('employee') ? 'checked' : '' }} >
                                    @endif
                                    CRUD Employee
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <label>
                                    @if ($attReg === 'on')
                                        <input type="checkbox" name="attReg" checked="">
                                    @else
                                        <input type="checkbox" name="attReg" {{ old('attReg') ? 'checked' : '' }} >
                                    @endif
                                    Add Attendance Register
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($leave === 'on')
                                        <input type="checkbox" name="leave" checked="">
                                    @else
                                        <input type="checkbox" name="leave" {{ old('leave') ? 'checked' : '' }} >
                                    @endif
                                    Leave
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($settings === 'on')
                                        <input type="checkbox" name="settings" checked="">
                                    @else
                                        <input type="checkbox" name="settings" {{ old('settings') ? 'checked' : '' }} >
                                    @endif
                                    Settings
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($reports === 'on')
                                        <input type="checkbox" name="reports" checked="">
                                    @else
                                        <input type="checkbox" name="reports" {{ old('reports') ? 'checked' : '' }} >
                                    @endif
                                    View Reports
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($user_role === 'on')
                                        <input type="checkbox" name="user_role" checked="">
                                    @else
                                        <input type="checkbox" name="user_role" {{ old('user_role') ? 'checked' : '' }} >
                                    @endif
                                    CRUD User Role
                                </label>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <label>
                                    @if ($crud_user === 'on')
                                        <input type="checkbox" name="crud_user" checked="">
                                    @else
                                        <input type="checkbox" name="crud_user" {{ old('crud_user') ? 'checked' : '' }} >
                                    @endif
                                    CRUD User
                                </label>
                            </div>
                        </div>
                    </div>
                    <a href="{!!URL::route('users')!!}" class="btn btn-info" role="button">Cancel</a>
                    {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#selectAll').click(function() {
            $(this.form.elements).filter(':checkbox').prop('checked', this.checked)
        });
    </script>
@endsection