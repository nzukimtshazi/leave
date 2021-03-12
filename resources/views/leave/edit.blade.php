<!-- app/views/leave/edit.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- Edit Leave Form... -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Update Leave for {!! $employee->name !!} {!! $employee->surname !!}</h3>
                </div>

                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}

                    {!! Form::model($employee, array('route' => array('leave.update', $employee->id), 'files'=>true, 'method' => 'PATCH')) !!}

                    <div class="form-group">
                        {!! Form::label('name', 'Name') !!}
                        {!! Form::text('name', Request::old('name'), array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('surname', 'Surname') !!}
                        {!! Form::text('surname', Request::old('surname'), array('class' => 'form-control', 'required')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::Label('leaveType_id', 'Leave Type') !!}
                        @foreach($leaveTypes as $leaveType)
                            @if($leaveType['id'] == app('request')->input('leaveType'))
                                <option value="{{$leaveType->id}}">{{$leaveType->type}}</option>
                            @endif
                        @endforeach
                    </div>

                    <div class="form-group">
                        {!! Form::label('start_date', 'Start Date') !!}
                        {!! Form::date('start_date', $leave->start_date, array('class' => 'form-control')) !!}
                    </div>

                    <div class="form-group">
                        {!! Form::label('start_date', 'Start Date') !!}
                        {!! Form::date('start_date', $leave->start_date, array('class' => 'form-control')) !!}
                    </div>

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a href="{!!URL::route('leaves')!!}" class="btn btn-info" role="button">Cancel</a>
                        {!! Form::submit('Update', array('class' => 'btn btn-primary')) !!}
                        {!! Form::close() !!}
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection