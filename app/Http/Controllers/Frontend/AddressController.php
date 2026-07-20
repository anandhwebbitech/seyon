<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Address;
use App\Models\Country;
use App\Models\State;
use App\Models\City;

class AddressController extends Controller
{
    public function addNewAddress(Request $request)
    {
        $userId = Auth::id();
        $existingAddressCount = Address::where('user_id', $userId)->count();

        if ($request->has('is_default') && $request->is_default) {
            Address::where('user_id', $userId)->update(['is_default' => 0]);
            $isDefault = 1;
        } elseif ($existingAddressCount == 0) {
            $isDefault = 1;
        } else {
            $isDefault = 0;
        }

        Address::create([
            'user_id'          => $userId,
            'address_type'     => $request->address_type,
            'shipping_name'    => $request->shipping_name,
            'shipping_email'   => $request->shipping_email,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'country'          => $request->country,
            'state'            => $request->state,
            'city'             => $request->city,
            'pincode'          => $request->pincode,
            'is_default'       => $isDefault,
        ]);

        return redirect()->back()->with('addsuccess', 'Address has been added successfully!');
    }

    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json($states);
    }

    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json($cities);
    }
    
   public function getAddress($id)
    {
        $address = Address::find($id);

        if (!$address) {
            return response()->json(['error' => 'Address not found'], 404);
        }

        $countries = Country::select('id', 'name')->where('id', 101)->get();
        $states = State::select('id', 'name')->where('country_id', 101)->get();
        $stateIds = $states->pluck('id');
        $cities = City::select('id', 'name')->whereIn('state_id', $stateIds)->get();

        $html = view('frontend.user.edit-address', compact('address', 'countries', 'states', 'cities'))->render();

        return response()->json(['html' => $html]);
    }

    
    public function updateAddress(Request $request)
    {
        $address = Address::find($request->edit_address_id);

        if (!$address) {
            return redirect()->back()->with('adddanger', 'Failed to update address!');
        }

        $address->update([
            'user_id'          => Auth::id(),
            'address_type'     => $request->address_type,
            'shipping_name'    => $request->shipping_name,
            'shipping_email'   => $request->shipping_email,
            'shipping_phone'   => $request->shipping_phone,
            'shipping_address' => $request->shipping_address,
            'country'          => $request->country,
            'state'            => $request->state,
            'city'             => $request->city,
            'pincode'          => $request->pincode,
        ]);

        $userAddressesCount = Address::where('user_id', Auth::id())->count();

        if ($userAddressesCount === 1) {
            $address->is_default = 1;
        } elseif ($request->has('is_default')) {
            Address::where('user_id', Auth::id())->update(['is_default' => 0]);
            $address->is_default = 1;
        }

        $address->save();

        return redirect()->back()->with('addsuccess', 'Address has been updated successfully!');
    }

    
    public function orderConfirm(Request $request)
    {
        $request->validate([
            'select_address_id' => 'required',
        ]);
        $amount          = $request->total_amount;
        $address         = $request->selected_address;
        $shipping_cost   = $request->shipping_cost;
        $gst             = $request->gst;
        $coupon_discount = $request->coupon_discount;
        
        return view('frontend.product.payment',compact('amount','address','shipping_cost','gst','coupon_discount'));
    }

    public function setPrimary(Request $request)
    {
        $request->validate([
            'address_id' => 'required|exists:addresses,id',
        ]);

        $user = auth()->user();
        $user->addresses()->update(['is_default' => 0]);
        $user->addresses()->where('id', $request->address_id)->update(['is_default' => 1]);

        return response()->json([
            'success' => true,
            'message' => 'Primary address updated successfully.'
        ]);
    }

}    