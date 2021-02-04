<?php

namespace App\Http\Controllers;

use App\Models\LeaveType\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class LeaveTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $leaveTypes = DB::table('leaveType')->get();
        return view('leaveType.index', ['leaveTypes' => $leaveTypes]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('leaveType.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $leaveType = LeaveType::where('type', '=', $request->type)->count();
        if ($leaveType > 0) {
            return redirect('leaveType/add')->withInput()->with('danger', 'Leave type already exists');
        }

        $input = Input::all();
        $leaveType = new LeaveType($input);

        if ($leaveType->save())
            return Redirect::route('leaveTypes')->with('success', 'Successfully added leave type!');
        else
            return Redirect::route('leaveType.add')->withInput()->withErrors($leaveType->errors());
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
        $leaveType = LeaveType::find($id);
        return view('leaveType.edit', compact('leaveType'));
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
        $leaveType = LeaveType::find($id);
        $type_check = LeaveType::where('type', '=', Input::get('type'))->get()->first();

        if ($type_check && $type_check->id != $id)
            return Redirect::route('leaveType.edit', [$id])->withInput()->with('danger', 'Leave type already exists');

        $leaveType->type = Input::get('type');
        $leaveType->cycle_length = Input::get('cycle_length');

        if ($leaveType->update())
            return Redirect::route('leaveTypes')->with('success', 'Successfully updated leave type!');
        else
            return Redirect::route('leaveType.edit', [$id])->withInput()->withErrors($leaveType->errors());
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
