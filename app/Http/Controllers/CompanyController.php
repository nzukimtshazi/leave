<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Country\Country;
use App\Models\Department\Department;
use App\Models\Team\Team;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class CompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $departments = array();
        $teams = array();

        $countries = DB::table('countries')->orderBy('name')->get();
        $companies = DB::table('companies')->orderBy('name')->get();

        $currentCompanies = array();
        foreach ($companies as $company) {
            $currentCompany = new CurrentCompany();
            $currentCompany->companyId = $company->id;
            $currentCompany->companyName = $company->name;
            $country = Country::find($company->country_id);
            $currentCompany->countryName = $country->name;
            array_push($currentCompanies, $currentCompany);
        }

        if($request->company_id > 0)
        {
            $departments = Department::where('company_id', '=', $request->company_id)->get();
            $teams = Team::where('company_id', '=', $request->company_id)->get();
            return view('company.index', compact('countries', 'currentCompanies', 'departments', 'teams'));
        }
        else
        {
            return view('company.index', compact('countries', 'currentCompanies', 'departments', 'teams'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        $countries = Country::all('id', 'name');
        return view('company.add', compact('countries', $countries));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $company = Company::where('name', '=', $request->name)->count();
        if ($company > 0)
            return redirect('company/add')->withInput()->with('danger', 'Company already exists');

        $country = Country::where('id', '=', Input::get('country_id'))->first();
        $input = Input::all();
        $company = new Company($input);

        if ($company->save())
            return Redirect::route('companies', ['country_id' => $country->id])->with('success', 'Successfully added company!');
        else
            return Redirect::route('company.add')->withInput()->withErrors($company->errors());
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
        $company = Company::find($id);
        $countries = Country::all('id','name');
        $cid = Company::find($id)->country_id;
        return view('company.edit', compact('countries', 'company', 'cid'));
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
        $company = Company::find($id);
        $company_check = Company::where('name', '=', Input::get('name'))->get()->first();

        if ($company_check && $company_check->id != $id)
            return Redirect::route('company.edit', [$id])->withInput()->with('danger', 'Company already exists');

        $company->name = Input::get('name');

        if ($company->update())
            return Redirect::route('companies')->with('success', 'Successfully updated company!');
        else
            return Redirect::route('company.edit', [$id])->withInput()->withErrors($company->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $department = Department::where('company_id', '=', $company->id)->first();

        if ($department)
            return Redirect::route('companies')->with('danger', 'Company has departments linked to it');
        else {
            $company->delete();
            return Redirect::route('companies')->with('success', 'Company successfully deleted!');
        }

        $team = Team::where('company_id', '=', $company->id)->first();

        if ($team)
            return Redirect::route('companies')->with('danger', 'Company has teams linked to it');
        else {
            $company->delete();
            return Redirect::route('companies')->with('success', 'Company successfully deleted!');
        }
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function departments($id)
    {
        $company = Company::find($id);
        $departments= Department::where('company_id', '=', $company->id)->get();

        return view('company.depts', compact('company', 'departments'));
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function teams($id)
    {
        $company = Company::find($id);
        $teams= Team::where('company_id', '=', $company->id)->get();

        return view('company.teams', compact('company', 'teams'));
    }
    /**
     * Ajax call to return all departments
     *
     * @return Venues
     */
    public function ajaxDepartments($company_id)
    {
        //only show all departments to a company
        $departments = Department::where('company_id','=',$company_id)->get();
        return $departments;
    }
    /**
     * Ajax call to return all departments
     *
     * @return Venues
     */
    public function ajaxTeams($company_id)
    {
        //only show all teams to a company
        $teams = Team::where('company_id','=',$company_id)->get();
        return $teams;
    }
}
class CurrentCompany {
    public $companyId;
    public $companyName;
    public $countryName;
}
