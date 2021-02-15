<!-- app/views/team/add.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- Create Team Form... -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 ">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Add New Team</h3>
                </div>
                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}

                    {!! Form::open(array('route' => 'team.store', 'method'=>'POST','files'=>true)) !!}

                    <div class="col-sm-4 col-md-4">
                        <div class="form-group">
                            {!! Form::label('name', 'Name') !!}
                            {!! Form::text('name', Request::old('name'), array('class' => 'form-control', 'required')) !!}
                        </div>
                        <div class="form-group">
                            {!! Form::Label('company_id', 'Company Name') !!}
                            <select class="form-control" name="company_id">
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

                    <div class="col-xs-12 col-sm-12 col-md-12">
                        <a href="{!!URL::route('teams')!!}" class="btn btn-info" role="button">Cancel</a>
                        {!! Form::submit('Add', array('class' => 'btn btn-primary')) !!}
                    </div>

                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
