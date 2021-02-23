@extends('layout/layout')
@section('content')

    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="row">
                <div class="col-md-12">
                    <div class="elementor-widget-container">
                        <ul class="elementor-icon-list-items">
                            <li class="elementor-icon-list-item">
							    <span class="elementor-icon-list-icon"><i aria-hidden="true" class="fas fa-leaf"></i></span>
                                <span class="elementor-icon-list-text">Calcu-Leave / Accu-Leave</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="panel-body">
        <div class="row">
            @if(Auth::user()->user_role == 'Management')
                <div class="container pt-3 my-3 border col-sm-3">
                    <h3>COUNTRIES</h3>
                    <a href="{!!URL::route('countries') !!}">Manage Countries</a>
                </div>
                <div class="container pt-3 col-sm-3">
                    <h3>COMPANIES</h3>
                    <a href="{!!URL::route('companies') !!}">Manage Companies</a>
                </div>
                <div class="container pt-3 my-3 border col-sm-3">
                    <h3>DEPARTMENTS</h3>
                    <a href="{!!URL::route('departments') !!}">Manage Departments</a>
                </div>
                <div class="container pt-3 col-sm-3">
                    <h3>TEAMS</h3>
                    <a href="{!!URL::route('teams') !!}">Manage Teams</a>
                </div>
                <div class="containe pt-3 col-sm-3">
                    <h3>EMPLOYEES</h3>
                    <a href="{!!URL::route('employees') !!}">Manage Employees</a>
                </div>
            @else
                <div class="container pt-3 my-3 border col-sm-3">
                    <h3>DEPARTMENTS</h3>
                    <a href="{!!URL::route('departments') !!}">Manage Departments</a>
                </div>
                <div class="container pt-3 col-sm-3">
                    <h3>TEAMS</h3>
                    <a href="{!!URL::route('teams') !!}">Manage Teams</a>
                </div>
                <div class="containe pt-3 col-sm-3">
                    <h3>EMPLOYEES</h3>
                    <a href="{!!URL::route('employees') !!}">Manage Employees</a>
                </div>
                <div class="container pt-3 col-sm-3">
                    <h3>EMPLOYEE TYPES</h3>
                    <a href="{!!URL::route('employeeTypes') !!}">Manage Employee Types</a>
                </div>
                <div class="containe pt-3 col-sm-3">
                    <h3>LEAVE TYPES</h3>
                    <a href="{!!URL::route('leaveTypes') !!}">Manage Leave Types</a>
                </div>
            @endif
        </div>
    </div>

    <script>
        $(function () {

            $('.wrapper1').on('scroll', function (e) {
                $('.panel-body').scrollLeft($('.wrapper1').scrollLeft());
            });
            $('.panel-body').on('scroll', function (e) {
                $('.wrapper1').scrollLeft($('.panel-body').scrollLeft());
            });
        });
        $( document ).ready(function() {
            $('.div1').width($('table').width());
            $('.div2').width($('table').width());
        });
    </script>
@endsection


