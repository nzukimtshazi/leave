<!-- app/views/attendanceRegister/index.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- List Accrued Leave Form... -->

    <!-- Current leave balances -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4>Employees accrued leave</h4>
                        </div>
                        <div class="col-xs-6 text-right">
                            <a href="attendanceRegister/add" role="button" class="btn btn-default">Capture Register</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped" id="dataTable">
                        @if (count($employees) > 0)

                            <!-- Table Headings -->
                            <thead>
                                <th>Employee Name</th>
                                <th>Annual Leave</th>
                                <th>Sick Leave</th>
                                <th>Family Responsibility</th>
                                <th>Action</th>
                            </thead>


                            <!-- Table Body -->
                            <tbody>
                                @foreach ($employees as $employee)
                                    <tr>
                                        <!-- Employee Name -->
                                        <td class="table-text">
                                            <div>{{ $employee->name }}</div>
                                        </td>

                                        <td>
                                            <div>
                                                {!! Form::model($employee, ['method' => 'GET', 'route' => ['attendanceRegister.add', $employee->id]]) !!}
                                                <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></i> Edit </button>
                                                {!! Form::close() !!}
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        @else
                            <div class="alert alert-info" role="alert">No accrued leaves are available</div>
                        @endif
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
