<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Team\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $teams = DB::table('teams')->get();
        return view('team.index', ['teams' => $teams]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $companies = Company::all('id', 'name');
        return view('team.add', compact('companies', $companies));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $team = Team::where('name', '=', $request->name)->count();
        if ($team > 0)
            return redirect('team/add')->withInput()->with('danger', 'Team already exists');

        $company = Company::where('id', '=', Input::get('company_id'))->first();
        $input = Input::all();
        $team = new Team($input);

        if ($team->save())
            return Redirect::route('teams', ['company_id' => $company->id])->with('success', 'Successfully added team!');
        else
            return Redirect::route('team.add')->withInput()->withErrors($team->errors());
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
        $team = Team::find($id);
        $companies = Company::all('id','name');
        $tid = Team::find($id)->company_id;
        return view('team.edit', compact('companies', 'team', 'tid'));
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
        $team = Team::find($id);
        $team_check = Team::where('name', '=', Input::get('name'))->get()->first();

        if ($team_check && $team_check->id != $id)
            return Redirect::route('team.edit', [$id])->withInput()->with('danger', 'Team already exists');

        $team->name = Input::get('name');

        if ($team->update())
            return Redirect::route('teams')->with('success', 'Successfully updated team!');
        else
            return Redirect::route('team.edit', [$id])->withInput()->withErrors($team->errors());
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
