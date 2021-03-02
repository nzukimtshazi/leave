@if (!Auth::guest())
    <!-- sidebar nav -->
    <nav class="navbar navbar-default">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
            </div>
            <div class="collapse navbar-collapse" id="myNavbar">
                <ul class="nav nav-pills nav-stacked">

                    <span class="label label-primary col-xs-12 col-sm-12 col-md-12" style="cursor: pointer;" data-toggle="collapse" data-target="#mainMenu">Main</span>
                    <div id="mainMenu" class="collapse in">
                        <li><a href="{!!URL::route('dashboard.view')!!}">Dashboard</a></li>
                        @if(Auth::user()->employeeCRUD == 'Y')
                            <li><a href="{!!URL::route('employees')!!}">Employees</a></li>
                        @endif
                        @if(Auth::user()->attReg == 'Y')
                            <li><a href="{!!URL::route('attendanceRegister.search')!!}">Attendance Register</a></li>
                        @endif
                        @if(Auth::user()->leaveCRUD == 'Y')
                            <li><a href="{!!URL::route('leave.add')!!}">Leave Applications</a></li>
                        @endif
                        <li><a href="{!!URL::route('calendar.index')!!}">Calendar</a></li>

                        @if(Auth::user()->settings == 'Y')
                            <div class="settings">
                                <button class="settbtn">Settings</button>
                                <div class="settings-content">
                                    @if(Auth::user()->userCRUD == 'Y')
                                        <li><a href="{!! URL::route('users') !!}">Users</a></li>
                                    @endif
                                    @if(Auth::user()->countryCRUD == 'Y')
                                        <li><a href="{!! URL::route('countries') !!}">Countries</a></li>
                                    @endif
                                    @if(Auth::user()->companyCRUD == 'Y')
                                        <li><a href="{!! URL::route('companies') !!}">Companies</a></li>
                                    @endif
                                    @if(Auth::user()->departmentCRUD == 'Y')
                                        <li><a href="{!!URL::route('departments')!!}">Departments</a></li>
                                    @endif
                                    @if(Auth::user()->teamCRUD == 'Y')
                                        <li><a href="{!!URL::route('teams')!!}">Teams</a></li>
                                    @endif
                                    @if(Auth::user()->employeeTypeCRUD == 'Y')
                                        <li><a href="{!!URL::route('employeeTypes')!!}">Employee Types</a></li>
                                    @endif
                                    @if(Auth::user()->leaveTypeCRUD == 'Y')
                                        <li><a href="{!!URL::route('leaveTypes')!!}">Leave Types</a></li>
                                    @endif
                                </div>
                            </div>
                        @endif
                    </div>
                    @if(Auth::user()->reportView == 'Y')
                        <span class="label label-primary col-xs-12 col-sm-12 col-md-12" style="cursor: pointer;" data-toggle="collapse" data-target="#reports">Reports</span>
                        <div id="reports" class="collapse in">
                            <li><a href="{!!URL::route('reports.annualLeave')!!}">Annual Leave Balances</a></li>
                            <li><a href="{!!URL::route('reports.sickLeave')!!}">Sick Leave Balances</a></li>
                        </div>
                    @endif
                    <span class="label label-primary col-xs-12 col-sm-12 col-md-12" style="cursor: pointer;" data-toggle="collapse" data-target="#helpSupport">Help & Support</span>
                    <div id="helpSupport" class="collapse in">
                        <li><a href="#">FAQ's</a></li>
                        <li><a href="#">Contact</a></li>
                        <li><a href="#">Documentation</a></li>
                    </div>
                    <div><li><a href="{!!URL::route('logout')!!}">Logout</a></li></div>
                </ul>
            </div>
        </div>
    </nav>
@endif

