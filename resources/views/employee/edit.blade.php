<!-- app/views/employee/edit.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- Edit Employee Form... -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Employee {!! $employee->name !!} {!! $employee->surname !!}</h3>
                </div>

                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}

                    {!! Form::model($employee, array('route' => array('employee.update', $employee->id), 'files'=>true, 'method' => 'PATCH')) !!}

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('name', 'Name') !!}
                                {!! Form::text('name', Request::old('name'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('surname', 'Surname') !!}
                                {!! Form::text('surname', Request::old('surname'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('employee_no', 'Employee No') !!}
                                {!! Form::text('employee_no', Request::old('employee_no'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('dob', 'Date of birth') !!}
                                {!! Form::text('dob', $employee->dob, array('class' => 'form-control datepicker', 'id' => 'dob')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('idType', 'ID Type') !!}
                                {!! Form::select('idType', array('RSA ID'=>'RSA ID', 'Passport/Foreign ID'=>'Passport/Foreign ID',
                                'Asylum Seeker"s Permit'=>'Asylum Seeker"s Permit', 'Refugee ID'=>'Refugee ID'), null, array('class'
                                => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('idNo', 'ID No') !!}
                                {!! Form::text('idNo', Request::old('idNo'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('gender', 'Gender') !!}
                                {!! Form::select('gender', array('Female'=>'Female', 'Male'=>'Male'), null, array('class'
                                => 'form-control')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('occupation', 'Occupation') !!}
                                {!! Form::text('occupation', Request::old('occupation'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('contact_no', 'Contact No') !!}
                                {!! Form::text('contact_no', Request::old('contact_no'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('start_date', 'Start Date') !!}
                                {!! Form::text('start_date', $employee->start_date, array('class' => 'form-control datepicker', 'id' => 'startDate')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('email', 'Email Address') !!}
                                {!! Form::text('email', Request::old('email'), array('class' => 'form-control', 'required')) !!}
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::Label('employeeType_id', 'Employee Type') !!}
                                <select class="form-control input-sm" required name="employeeType_id" id="employeeType_id">
                                    @foreach($employeeTypes as $type)
                                        @if($type['id'] == $type['employeeType_id'])
                                            <option value="{{$type['employeeType_id']}}" selected="{{$type['employeeType_id']}}">{{$type['employee_type']}}</option>
                                        @else
                                            <option value="{{$type->id}}">{{$type->employee_type}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        @if(Auth::user()->user_role == 'Management')
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                {!! Form::Label('country_id', 'Country Name') !!}
                                <select class="form-control input-sm" required name="country_id" id="country_id">
                                    @foreach($countries as $country)
                                        @if($country['id'] == $employee['country_id'])
                                            <option value="{{$employee['country_id']}}" selected="{{$employee['country_id']}}">{{$country['name']}}</option>
                                        @else
                                            <option value="{{$country->id}}">{{$country->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                {!! Form::Label('company_id', 'Company Name') !!}
                                <select class="form-control input-sm" required name="company_id" id="company_id">
                                    @foreach($companies as $company)
                                        @if($company['id'] == $employee['company_id'])
                                            <option value="{{$employee['company_id']}}" selected="{{$employee['company_id']}}">{{$company['name']}}</option>
                                        @else
                                            <option value="{{$company->id}}">{{$company->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                {!! Form::Label('dept_id', 'Department Name') !!}
                                <select class="form-control input-sm" required name="dept_id" id="dept_id">
                                    @foreach($departments as $dept)
                                        @if($dept['id'] == $employee['dept_id'])
                                            <option value="{{$employee['dept_id']}}" selected="{{$employee['dept_id']}}">{{$dept['name']}}</option>
                                        @else
                                            <option value="{{$dept->id}}">{{$dept->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-3 col-md-3">
                            <div class="form-group">
                                {!! Form::Label('team_id', 'Team Name') !!}
                                <select class="form-control input-sm" required name="team_id" id="team_id">
                                    @foreach($teams as $team)
                                        @if($team['id'] == $employee['team_id'])
                                            <option value="{{$employee['team_id']}}" selected="{{$employee['team_id']}}">{{$team['name']}}</option>
                                        @else
                                            <option value="{{$team->id}}">{{$team->name}}</option>
                                        @endif
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        @else
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    {!! Form::Label('company_id', 'Company Name') !!}
                                    <select class="form-control input-sm" required name="company_id" id="company_id">
                                        @foreach($companies as $company)
                                            @if($company['id'] == $employee['company_id'])
                                                <option value="{{$employee['company_id']}}" selected="{{$employee['company_id']}}">{{$company['name']}}</option>
                                            @else
                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    {!! Form::Label('dept_id', 'Department Name') !!}
                                    <select class="form-control input-sm" required name="dept_id" id="dept_id">
                                        @foreach($departments as $dept)
                                            @if($dept['id'] == $employee['dept_id'])
                                                <option value="{{$employee['dept_id']}}" selected="{{$employee['dept_id']}}">{{$dept['name']}}</option>
                                            @else
                                                <option value="{{$dept->id}}">{{$dept->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    {!! Form::Label('team_id', 'Team Name') !!}
                                    <select class="form-control input-sm" required name="team_id" id="team_id">
                                        @foreach($teams as $team)
                                            @if($team['id'] == $employee['team_id'])
                                                <option value="{{$employee['team_id']}}" selected="{{$employee['team_id']}}">{{$team['name']}}</option>
                                            @else
                                                <option value="{{$team->id}}">{{$team->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a href="{!!URL::route('employees')!!}" class="btn btn-info" role="button">Cancel</a>
                        {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                        {!! Form::close() !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection