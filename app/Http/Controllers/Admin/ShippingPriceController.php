<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShippingPrice;
use App\Models\State;
use Illuminate\Http\Request;

class ShippingPriceController extends Controller
{
    public function index()
    {
        $shippingPrices = ShippingPrice::with('state')->latest()->get();
        return view('admin.shipping_price.index', compact('shippingPrices'));
    }

    public function create()
    {
        $states = State::where('country_id',101)->get();
        return view('admin.shipping_price.create', compact('states'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'state_id'       => 'required|integer',
            'shipping_cost'  => 'required|numeric|min:0',
            'status'         => 'nullable|boolean',
        ]);

        ShippingPrice::create($request->only(['state_id', 'shipping_cost', 'status']));

        return redirect()->route('shipping-price.index')->with('success', 'Shipping price added successfully.');
    }

    public function edit($id)
    {
        $shippingPrice = ShippingPrice::findOrFail($id);
        $states =State::where('country_id',101)->get();
        return view('admin.shipping_price.edit', compact('shippingPrice', 'states'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'state_id'       => 'required|integer',
            'shipping_cost'  => 'required|numeric|min:0',
            'status'         => 'nullable|boolean',
        ]);

        $shippingPrice = ShippingPrice::findOrFail($id);
        $shippingPrice->update($request->only(['state_id', 'shipping_cost', 'status']));

        return redirect()->route('shipping-price.index')->with('success', 'Shipping price updated successfully.');
    }

    public function destroy($id)
    {
        $shippingPrice = ShippingPrice::findOrFail($id);
        $shippingPrice->delete();

        return redirect()->route('shipping-price.index')->with('success', 'Shipping price deleted successfully.');
    }
}
