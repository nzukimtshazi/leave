<!-- app/views/user/create.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- Create User Form... -->

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Create New User</h3>
                </div>
                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}

                    {!! Form::model(new App\Models\User\User, ['route' => ['user.store']]) !!}

                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', Request::old('name'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('surname', 'Surname') !!}
                                {!! Form::text('surname', Request::old('surname'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('role_id', 'User role') !!}
                                <select class="form-control input-sm" required name="role_id" id="role_id">
                                    <option disabled selected hidden>Select User Role</option>
                                    @foreach($roles as $role)
                                        <option value="{{$role->id}}">{{$role->description}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('email', 'Email') !!}
                                {!! Form::email('email', Request::old('email'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>
                    <div class="row>">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                {!! Form::label('password', 'Password') !!}
                                {!! Form::password('password', array('class' => 'form-control input-sm', 'required')) !!}
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
                                <input type="checkbox" id="country" name="country">
                                <label for="country"> CRUD Country</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="company" name="company">
                                <label for="company"> CRUD Company</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="department" name="department">
                                <label for="department"> CRUD Department</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="team" name="team">
                                <label for="team"> CRUD Team</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="employeeType" name="employeeType">
                                <label for="employeeType"> CRUD Employee Type</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="leaveType" name="leaveType">
                                <label for="leaveType"> CRUD Leave Type</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="employee" name="employee">
                                <label for="employee"> CRUD Employee</label><br>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                <input type="checkbox" id="attReg" name="attReg">
                                <label for="attReg"> Add Attendance Register</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="leave" name="leave">
                                <label for="leave"> Leave</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="settings" name="settings">
                                <label for="settings"> Settings</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="reports" name="reports">
                                <label for="reports"> View Reports</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="user_role" name="user_role">
                                <label for="user_role"> CRUD User Role</label><br>
                            </div>
                        </div>
                        <div class="col-sm-2 col-md-2">
                            <div class="form-group">
                                <input type="checkbox" id="crud_user" name="crud_user">
                                <label for="crud_user"> CRUD User</label><br>
                            </div>
                        </div>
                    </div>
                    <a href="{!!URL::route('users')!!}" class="btn btn-info" role="button">Cancel</a>
                    {!! Form::submit('Create', array('class' => 'btn btn-primary')) !!}
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