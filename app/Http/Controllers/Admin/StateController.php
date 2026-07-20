<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use App\Models\State;
use Redirect;
use Validator;


class StateController extends Controller
{
    public function __construct()
    {
        
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $states = State::whereHas('country', function($query){
            $query->where('status', 1);
        })->orderBy('id', 'asc')->get();
        
        $countries = Country::where('status', 1)->get();
      
        return view('admin.attributes.states.index', compact('states','countries'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
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
        $rules      = $this->state_rules;
        $messages   = $this->state_messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $state              = new State;
        $state->name        = $request->name;
        $state->country_id  = $request->country_id;
        if($state->save())
        {
            flash(translate('New state has been added successfully'))->success();
            return redirect()->route('states.index');
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
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
        $state         = State::findOrFail(decrypt($id));
        $countries     = Country::where('status',1)->get();
        return view('admin.member_profile_attributes.states.edit', compact('state','countries'));
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
        $rules      = $this->state_rules;
        $messages   = $this->state_messages;
        $validator  = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            flash(translate('Sorry! Something went wrong'))->error();
            return Redirect::back()->withErrors($validator);
        }

        $state              = State::findOrFail($id);
        $state->name        = $request->name;
        $state->country_id  = $request->country_id;
        if($state->save())
        {
            flash(translate('State info has been updated successfully'))->success();
            return redirect()->route('states.index');
        }
        else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $state = State::findOrFail($id);
        foreach ($state->cities as $key => $city) {
            $city->delete();
        }
        if (State::destroy($id)) {
            flash(translate('State info has been deleted successfully'))->success();
            return redirect()->route('states.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }

    // Get State by country
    public function get_state_by_country(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return $states;
    }
}
