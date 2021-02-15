<!-- app/views/team/index.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- List Team Form... -->

    <!-- Current Teams -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <h4>Current Teams</h4>
                </div>
                {{--@if(Auth::user()->user_role == 'Management' || Auth::user()->user_role == 'Admin')--}}
                <div class="col-xs-6 text-right">
                    <a href="team/add" role="button" class="btn btn-default">Add Team</a>
                </div>
                {{--@endif--}}
            </div>
        </div>

        <div class="panel-body">
            <table class="table table-striped" id="dataTable">
            @if (count($teams) > 0)

                <!-- Table Headings -->
                <thead>
                    <th width="15%">Team</th>
                    <th width="*">Action</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @foreach ($teams as $team)
                        <tr>
                            <!-- Team Name -->
                            <td class="table-text">
                                <div>{{ $team->name }}</div>
                            </td>

                            <td>
                                {{--@if(Auth::user()->user_role == 'Management' || Auth::user()->user_role == 'Admin')--}}
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-2">
                                        {!! Form::model($team, ['method' => 'GET', 'route' => ['team.edit', $team->id]]) !!}
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i> Edit </button>
                                        <a href="{!!URL::route('team.destroy', ['id' => $team->id])!!}" class="btn btn-danger"
                                           onclick="return confirm('Are you sure about deleting the team?')">Delete</a>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                                {{--@endif--}}
                            </td>

                        </tr>
                    @endforeach
                </tbody>
            @else
                <div class="alert alert-info" role="alert">No teams are available</div>
            @endif
            </table>
        </div>
    </div>
@endsection
