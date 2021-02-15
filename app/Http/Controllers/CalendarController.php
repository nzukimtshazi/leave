<?php

namespace App\Http\Controllers;

use App\Models\Employee\Employee;
use App\Models\Leave\Leave;
use App\Models\LeaveType\LeaveType;
use Illuminate\Http\Request;
use MaddHatter\LaravelFullcalendar\Facades\Calendar;
use Session;

class CalendarController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        {
            $leaves = [];
            $data = Leave::all();

            if($data->count())
            {
                foreach ($data as $key => $value)
                {
                    $employee = Employee::find($value->employee_id);
                    $name = $employee->name . ' ' . $employee->surname;
                    $leaveType = LeaveType::find($value->leaveType_id);
                    $type = $leaveType->type;

                    $content = $name . "\n" . $type;

                    $leaves[] = Calendar::event(
                        $content,
                        true,
                        new \DateTime($value->start_date),
                        new \DateTime($value->end_date.'+1 day'),
                        null,
                        // Add color
                        [
                            'color' => '#000000',
                            'textColor' => '#008000',
                        ]
                    );
                }
            }
            $calendar = Calendar::addEvents($leaves);
            return view('calendar.index', compact('calendar'));
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
