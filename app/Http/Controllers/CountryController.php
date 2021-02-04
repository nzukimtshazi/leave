<?php

namespace App\Http\Controllers;

use App\Models\Company\Company;
use App\Models\Country\Country;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Session;
use Illuminate\Support\Facades\Redirect;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $companies = array();
        $countries = DB::table('countries')->orderby('name')->get();

        if($request->country_id > 0)
        {
            $companies = Company::where('country_id', '=', $request->country_id)->get();
            return view('country.index', ['countries' => $countries, 'companies' => $companies]);
        }
        else
            {
            return view('country.index', ['countries' => $countries, 'companies' => $companies]);
        }
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function add()
    {
        return view('country.add');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $country = Country::where('name', '=', $request->name)->count();
        if ($country > 0)
            return redirect('country/add')->withInput()->with('danger', 'Country already exists');

        $input = Input::all();
        $countries = new Country($input);

        if ($countries->save())
            return Redirect::route('countries')->with('success', 'Successfully added country!');
        else
            return Redirect::route('country.add')->withInput()->withErrors($countries->errors());
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
        $country = Country::find($id);
        return view('country.edit', ['country' => $country]);
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
        $country = Country::find($id);
        $country_check = Country::where('name', '=', Input::get('name'))->get()->first();

        if ($country_check && $country_check->id != $id)
            return Redirect::route('country.edit', [$id])->withInput()->with('danger', 'Country already exists');

        $country->name = Input::get('name');

        if ($country->update())
            return Redirect::route('countries')->with('success', 'Successfully updated country!');
        else
            return Redirect::route('country.edit', [$id])->withInput()->withErrors($country->errors());
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        $company = Company::where('country_id', '=', $country->id)->first();

        if ($company)
            return Redirect::route('countries')->with('danger', 'Country has companies linked to it');
        else {
            $country->delete();
            return Redirect::route('countries')->with('success', 'Country successfully deleted!');
        }
    }
    /**
     * Ajax call to return all companies
     *
     * @return Venues
     */
    public function ajaxCompanies($country_id)
    {
        //only show all companies to a country
        $companies = Company::where('country_id','=',$country_id)->get();
        return $companies;
    }
}
