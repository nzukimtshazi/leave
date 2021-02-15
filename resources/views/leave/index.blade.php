<!-- app/views/leave/index.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- List Employee Leaves Form... -->

    <!-- Current Leave per employee -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-6">
                            <h4>Leave balances per employee</h4>
                        </div>
                        <div class="col-xs-6 text-right">
                            <a href="leave/add" role="button" class="btn btn-default">Capture Leave</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <table class="table table-striped" id="dataTable">
                    @if (count($employees) > 0)

                        <!-- Table Headings -->
                        <thead>
                            <th>Name</th>
                            <th>Surname</th>
                            <th>Employee Type</th>
                            <th>Annual Leave</th>
                            <!--<th width="*">Action</th>-->
                        </thead>

                        <!-- Table Body -->
                        <tbody>
                            @foreach ($employees as $employee)
                                <tr>
                                    <!-- Name -->
                                    <td class="table-text">
                                        <div>{{ $employee->name }}</div>
                                    </td>
                                    <!-- Surname -->
                                    <td class="table-text">
                                        <div>{{ $employee->surname }}</div>
                                    </td>

                                    <!-- Type of Worker -->
                                    <td class="table-text">
                                        <div>
                                            @foreach($employeeTypes as $employeeType)
                                                @if($employee->employeeType_id == $employeeType->id)
                                                    <div>{{ $employeeType->employee_type }}</div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>

                                    <!-- Accrued Leaves -->
                                    <td class="table-text">
                                        <div>
                                            @foreach($leaveCalculations as $calculation)
                                                @if($employee->id == $calculation->employee_id)
                                                    <div>{{ $calculation->leaveDays_available }}</div>
                                                @endif
                                            @endforeach
                                        </div>
                                    </td>

                                    <!--<td>
                                        <div>
                                            {!! Form::model($employee, ['method' => 'GET', 'route' => ['employee.edit', $employee->id]]) !!}
                                            <button type="submit" class="btn btn-warning"><i class="fa fa-trash"></i></i> Edit </button>
                                            {!! Form::close() !!}
                                        </div>
                                    </td>-->
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
