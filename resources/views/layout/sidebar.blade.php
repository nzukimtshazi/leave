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
                        <li><a href="{!!URL::route('employees')!!}">Employees</a></li>
                        <li><a href="{!!URL::route('attendanceRegister.add')!!}">Attendance Register</a></li>
                        <li><a href="{!!URL::route('leave')!!}">Leave</a></li>
                        <li><a href="{!!URL::route('reports')!!}">Reports</a></li>
                        <div class="settings">
                            <button class="settbtn">Settings</button>
                            <div class="settings-content">
                                <a href="{!! URL::route('countries') !!}">Countries</a>
                                <a href="{!! URL::route('companies') !!}">Companies</a>
                                <li><a href="{!!URL::route('departments')!!}">Departments</a></li>
                                <li><a href="{!!URL::route('teams')!!}">Teams</a></li>
                                <li><a href="{!!URL::route('employeeTypes')!!}">Employee Types</a></li>
                                <a href="{!! URL::route('users') !!}">Users</a>
                            </div>
                        </div>
                    </div>

                    <div><li><a href="{!!URL::route('logout')!!}">Logout</a></li></div>
                </ul>
            </div>
        </div>
    </nav>
@endif
