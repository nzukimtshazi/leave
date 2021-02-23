<!-- app/views/attendanceRegister/add.blade.php -->

@extends('layout/layout')

@section('content')
    <!-- List Employee Register Form... -->

    <!-- Add hours for an employee -->

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <h4>Employees Attendance Register</h4>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-6 text-left">
                            <a href="{!!URL::route('attendanceRegister.add') !!}" role="button" class="btn btn-default">All</a>
                            <a href="{!!URL::route('attendanceRegister.shiftWorkers')!!}" role="button" class="btn btn-default">Shift Workers</a>
                            <a href="{!!URL::route('attendanceRegister.labourers')!!}" role="button" class="btn btn-default">Labourers</a>
                        </div>
                    </div>
                </div>
                <div class="panel-body">
                    <!-- if there are creation errors, they will show here -->
                    {!! HTML::ul($errors->all()) !!}

                    {!! Form::open(array('route' => 'attendanceRegister.store', 'method'=>'POST','files'=>true), array('employeesRegisterArray' => $employeesRegisterArray)) !!}

                    <table class="table table-striped" id="dataTable">
                    @if (count($employeesRegisterArray) > 0)

                        <!-- Table Headings -->
                            <thead>
                            <th></th>
                            @if($defaultValue == " ")
                                <th><input type="checkbox" id="selectAll"></th>
                            @endif
                            @if($defaultValue == "P")
                                <th><input type="checkbox" id="selectShiftWorkers"></th>
                            @endif
                            @if($defaultValue == "8")
                                <th><input type="checkbox" id="selectLabourers"></th>
                            @endif
                            <th>Employee</th>
                            <th>Type of worker</th>
                            <th><strong>{{ $day1 }}</strong></th>
                            <th><strong>{{ $day2 }}</strong></th>
                            <th><strong>{{ $day3 }}</strong></th>
                            <th><strong>{{ $day4 }}</strong></th>
                            <th><strong>{{ $day5 }}</strong></th>
                            <th><strong>{{ $day6 }}</strong></th>
                            <th><strong>{{ $day7 }}</strong></th>
                            </thead>

                            <!-- Table Body -->
                            <tbody>
                            @foreach ($employeesRegisterArray as $employee)

                                <tr>
                                    <td></td>

                                    <td><input type="checkbox"></td>

                                    <!-- Employee Name -->
                                    <td class="table-text">
                                        <div>{{ $employee->employeeName }}</div>
                                    </td>

                                    <!-- Employee Type -->
                                    <td class="table-text">
                                        <div>{{ $employee->employeeType }}</div>
                                    </td>

                                    <!-- Day1 -->
                                    @if($day1)
                                        <td class="table-text">
                                            <input type="text" name="day1Register[]" value="{{ @old('day1Register') }}" required id="day1" class="form-control">
                                        </td>
                                    @endif

                                <!-- Day2 -->
                                    @if($day2)
                                        <td class="table-text">
                                            <input type="text" name="day2Register[]" value="{{ @old('day2Register') }}" required id="day2" class="form-control">
                                        </td>
                                    @endif

                                <!-- Day3 -->
                                    @if($day3)
                                        <td class="table-text">
                                            <input type="text" name="day3Register[]" value="{{ @old('day3Register') }}" required id="day3" class="form-control">
                                        </td>
                                    @endif

                                <!-- Day4 -->
                                    @if($day4)
                                        <td class="table-text">
                                            <input type="text" name="day4Register[]" value="{{ @old('day4Register') }}" required id="day4" class="form-control">
                                        </td>
                                    @endif

                                <!-- Day5 -->
                                    @if($day5)
                                        <td class="table-text">
                                            <input type="text" name="day5Register[]" value="{{ @old('day5Register') }}" required id="day5" class="form-control">
                                        </td>
                                    @endif

                                <!-- Day6 -->
                                    @if($day6)
                                        <td class="table-text">
                                            <input type="text" name="day6Register[]" value="{{ @old('day6Register') }}" required id="day6" class="form-control">
                                        </td>
                                    @endif

                                <!-- Day7 -->
                                    @if($day7)
                                        <td class="table-text">
                                            <input type="text" name="day7Register[]" value="{{ @old('day7Register') }}" required id="day7" class="form-control">
                                        </td>
                                    @endif
                                    @if($rightPagination == 'Yes' && $defaultValue != " ")
                                        <td><input type="submit" value="&raquo;" onclick="checking()" /></td>
                                    @else
                                        <td></td>
                                    @endif
                                </tr>

                                {{ Form::hidden('employee_id[]', $employee->id) }}
                            @endforeach
                            {{ Form::hidden('day1', $day1) }}
                            {{ Form::hidden('day2', $day2) }}
                            {{ Form::hidden('day3', $day3) }}
                            {{ Form::hidden('day4', $day4) }}
                            {{ Form::hidden('day5', $day5) }}
                            {{ Form::hidden('day6', $day6) }}
                            {{ Form::hidden('day7', $day7) }}
                            {{ Form::hidden('str_day1', $str_day1) }}
                            {{ Form::hidden('defaultValue', $defaultValue) }}
                            </tbody>
                        @else
                            <div class="alert alert-info" role="alert">No employees are available</div>
                        @endif
                    </table>
                    <a href="{!!URL::route('attendanceRegister.add')!!}" class="btn btn-info" role="button">Cancel</a>
                    {!! Form::submit('Add', array('class' => 'btn btn-primary')) !!}
                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
    <script>
        $('#selectAll').click(function() {
            alert("You have to choose either shift workers or labourers to edit register");
            $('#dataTable td:nth-child(5)').html("");
            $('#dataTable td:nth-child(6)').html("");
            $('#dataTable td:nth-child(7)').html("");
            $('#dataTable td:nth-child(8)').html("");
            $('#dataTable td:nth-child(9)').html("");
            $('#dataTable td:nth-child(10)').html("");
            $('#dataTable td:nth-child(11)').html("");
        });
        $('#selectShiftWorkers').click(function() {
            $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
            if ($(this).prop("checked") == true) {
                $('#dataTable td:nth-child(5)').children("input").val("P");
                $('#dataTable td:nth-child(6)').children("input").val("P");
                $('#dataTable td:nth-child(7)').children("input").val("P");
                $('#dataTable td:nth-child(8)').children("input").val("P");
                $('#dataTable td:nth-child(9)').children("input").val("P");
                $('#dataTable td:nth-child(10)').children("input").val("P");
                $('#dataTable td:nth-child(11)').children("input").val("P");
            }
            else if ($(this).prop("checked") == false) {
                $('#dataTable td:nth-child(5)').children("input").val("");
                $('#dataTable td:nth-child(6)').children("input").val("");
                $('#dataTable td:nth-child(7)').children("input").val("");
                $('#dataTable td:nth-child(8)').children("input").val("");
                $('#dataTable td:nth-child(9)').children("input").val("");
                $('#dataTable td:nth-child(10)').children("input").val("");
                $('#dataTable td:nth-child(11)').children("input").val("");
            }
        });
        $('#selectLabourers').click(function() {
            $(this.form.elements).filter(':checkbox').prop('checked', this.checked);
            if ($(this).prop("checked") == true) {
                $('#dataTable td:nth-child(5)').children("input").val("8");
                $('#dataTable td:nth-child(6)').children("input").val("8");
                $('#dataTable td:nth-child(7)').children("input").val("8");
                $('#dataTable td:nth-child(8)').children("input").val("8");
                $('#dataTable td:nth-child(9)').children("input").val("8");
                $('#dataTable td:nth-child(10)').children("input").val("8");
                $('#dataTable td:nth-child(11)').children("input").val("8");
            }
            else if ($(this).prop("checked") == false) {
                $('#dataTable td:nth-child(5)').children("input").val("");
                $('#dataTable td:nth-child(6)').children("input").val("");
                $('#dataTable td:nth-child(7)').children("input").val("");
                $('#dataTable td:nth-child(8)').children("input").val("");
                $('#dataTable td:nth-child(9)').children("input").val("");
                $('#dataTable td:nth-child(10)').children("input").val("");
                $('#dataTable td:nth-child(11)').children("input").val("");
            }
        });
        function checking() {
            var days = document.getElementById('day1').value;
            if (days == "")
                return confirm('You can"t paginate without capturing this page first');
        }
    </script>
@endsection
