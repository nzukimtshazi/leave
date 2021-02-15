<!-- app/views/department/index.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- List Department Form... -->

    <!-- Current Departments -->

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-xs-6">
                    <h4>Current Departments</h4>
                </div>
                <div class="col-xs-6 text-right">
                    <a href="department/add" role="button" class="btn btn-default">Add Department</a>
                </div>
            </div>
        </div>

        <div class="panel-body">
            <table class="table table-striped" id="dataTable">
            @if (count($departments) > 0)

                <!-- Table Headings -->
                <thead>
                    <th width="15%">Department</th>
                    <th width="*">Action</th>
                </thead>

                <!-- Table Body -->
                <tbody>
                    @foreach ($departments as $department)
                        <tr>
                            <!-- Department Name -->
                            <td class="table-text">
                                <div>{{ $department->name }}</div>
                            </td>

                            <td>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-4 col-md-2">
                                        {!! Form::model($department, ['method' => 'GET', 'route' => ['department.edit', $department->id]]) !!}
                                        <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i> Edit </button>
                                        <a href="{!!URL::route('department.destroy', ['id' => $department->id])!!}" class="btn btn-danger"
                                           onclick="return confirm('Are you sure about deleting the department?')">Delete</a>
                                        {!! Form::close() !!}
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            @else
                <div class="alert alert-info" role="alert">No departments are available</div>
            @endif
            </table>
        </div>
    </div>
@endsection
