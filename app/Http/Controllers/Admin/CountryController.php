<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Country;
use Redirect;
use Validator;

class CountryController extends Controller
{
    public function __construct()
    {
        
    }
   
   
    public function index(Request $request)
    {
        $countries    = Country::where('status',1)->orderBy('id','asc');
        $countries = $countries->get();
        return view('admin.attributes.countries.index', compact('countries'));

    }

   
    public function create()
    {
        //
    }

    public function show($id)
    {
        //
    }


    public function edit($id)
    {
        $country = Country::findOrFail(decrypt($id));
        return view('admin.member_profile_attributes.countries.edit',compact('country'));
    }

   

    public function updateStatus(Request $request){
        $country = Country::findOrFail($request->id);
        $country->status = $request->status;
        if($country->save()){
            return 1;
        }
        return 0;
    }

   
    public function destroy($id)
    {
        $country = Country::findOrFail($id);
        foreach ($country->states as $key => $state) {
            foreach ($state->cities as $key => $city) {
                $city->delete();
            }
            $state->delete();
        }
        if (Country::destroy($id)) {
            flash(translate('Country deleted successfully'))->success();
            return redirect()->route('countries.index');
        } else {
            flash(translate('Sorry! Something went wrong.'))->error();
            return back();
        }
    }
}
