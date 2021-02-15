<!-- app/views/employee/add.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- Create Employee Form... -->

    <div class="row">
        <div class="col-xs-12 col-sm-8 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add Employee</h3>
                </div>
                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}


                    {!! Form::model(new App\Models\Employee\Employee, ['route' => ['employee.store']]) !!}

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
                                <input type="text" name="dob" value="{{ old('dob') }}" required id="dob" class="form-control datepicker">
                            </div>
                        </div>

                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                {!! Form::label('idType', 'ID Type') !!}
                                {!! Form::select('idType', array('Select Type'=>'Select Type', 'RSA ID'=>'RSA ID',
                                'Passport/Foreign ID'=>'Passport/Foreign ID', 'Asylum Seeker"s Permit'=>'Asylum Seeker"s Permit',
                                'Refugee ID'=>'Refugee ID'), null, array('class' => 'form-control')) !!}
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
                                {!! Form::select('gender', array('Select Gender'=>'Select Gender','Female'=>'Female', 'Male'=>'Male'), null, array('class' => 'form-control')) !!}
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
                                <input type="text" required name="start_date" value="{{ old('start_date') }}" required id="start_date" class="form-control datepicker">
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
                                {!! Form::label('employeeType_id', 'Employee Type') !!}
                                <select class="form-control input-sm" required name="employeeType_id" id="employeeType_id">
                                    <option disabled selected hidden>Select Employee Type</option>
                                    @foreach($employeeTypes as $type)
                                        @if($type['id'] == app('request')->input('employeeType_id'))
                                            <option value="{{$type['id']}}" selected="{{$type['id']}}">{{$type['employee_type']}}</option>
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
                                    {!! Form::label('country_id', 'Country Name') !!}
                                    <select class="form-control input-sm" required name="country_id" id="country_id">
                                        <option disabled selected hidden>Select Country</option>
                                        @foreach($countries as $country)
                                            @if($country['id'] == app('request')->input('country_id'))
                                                <option value="{{$country['id']}}" selected="{{$country['id']}}">{{$country['name']}}</option>
                                            @else
                                                <option value="{{$country->id}}">{{$country->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    {!! Form::label('company_id', 'Company Name') !!}
                                    <select class="form-control input-sm" required name="company_id" id="company_id">
                                        <option value="">Select Country First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    {!! Form::label('dept_id', 'Department Name') !!}
                                    <select class="form-control input-sm" required name="dept_id" id="dept_id">
                                        <option value="">Select Company First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-3 col-md-3">
                                <div class="form-group">
                                    {!! Form::label('team_id', 'Team Name') !!}
                                    <select class="form-control input-sm" required name="team_id" id="team_id">
                                        <option value="">Select Company First</option>
                                    </select>
                                </div>
                            </div>
                        @else
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    {!! Form::label('company_id', 'Company Name') !!}
                                    <select class="form-control input-sm" required name="company_id" id="company_id">
                                        <option disabled selected hidden>Select Company</option>
                                        @foreach($companies as $company)
                                            @if($company['id'] == app('request')->input('company_id'))
                                                <option value="{{$company['id']}}" selected="{{$company['id']}}">{{$company['name']}}</option>
                                            @else
                                                <option value="{{$company->id}}">{{$company->name}}</option>
                                            @endif
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    {!! Form::label('dept_id', 'Department Name') !!}
                                    <select class="form-control input-sm" required name="dept_id" id="dept_id">
                                        <option value="">Select Company First</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-sm-4 col-md-4">
                                <div class="form-group">
                                    {!! Form::label('team_id', 'Team Name') !!}
                                    <select class="form-control input-sm" required name="team_id" id="team_id">
                                        <option value="">Select Company First</option>
                                    </select>
                                </div>
                            </div>
                        @endif
                    </div>

                    <a href="{!!URL::route('employees')!!}" class="btn btn-info" role="button">Cancel</a>
                    {!! Form::submit('Add', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection