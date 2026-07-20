<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopByPrice;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopByPriceController extends Controller
{
    public function index(){
        $shop_by_price = ShopByPrice::get();
        return view('admin.shop_by_price.index',compact('shop_by_price'));
    }

    public function create(){
        return view('admin.shop_by_price.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:8048',
        ]);
        $shop_by_price = new ShopByPrice();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/shop_by_price'), $fileName);
            $shop_by_price->image = 'uploads/shop_by_price/' . $fileName;
        } else {
            return redirect()->back()->with(['danger' => 'Please upload an image.']);
        }
        $slug = Str::slug($request->title);

        $originalSlug = $slug;
        $count = 1;

        while (ShopByPrice::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $shop_by_price->title = $request->title;
        $shop_by_price->status = $request->status ?? 1;
        $shop_by_price->slug = $slug;
        $shop_by_price->save();
    
        if ($shop_by_price) {
            return redirect()->route('by.price.index')->with(['success' => 'Shop by Price has been added successfully']);
        } else {
            return redirect()->back()->with('danger', 'Failed to add Shop by Price.');
        }
    } 

    public function edit($id){
        $shop_by_price = ShopByPrice::find($id);
        if($shop_by_price){
            return view('admin.shop_by_price.edit',compact('shop_by_price'));
        }
        return redirect()->back()->with('danger', 'Failed to add Shop by Price.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'status' => 'required|in:0,1',
        ]);

        $shop_by_price = ShopByPrice::find($id);

        if (!$shop_by_price) {
            return redirect()->back()->with('danger', 'Shop by Price not found.');
        }
        $slug = Str::slug($request->title);

        $originalSlug = $slug;
        $count = 1;

        while (ShopByPrice::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $shop_by_price->title  = $request->title;
        $shop_by_price->slug   = $slug;
        $shop_by_price->status = $request->status;

        if ($request->hasFile('image')) {
            if ($shop_by_price->image && file_exists(public_path($shop_by_price->image))) {
                unlink(public_path($shop_by_price->image));
            }

            $image    = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/shop_by_price'), $fileName);
            $shop_by_price->image = 'uploads/shop_by_price/' . $fileName;
        }

        $shop_by_price->save();

        return redirect()->route('by.price.index')->with('success', 'Shop by Price has been updated successfully');
    }

    public function delete($id)
    {
        $shop_by_price = ShopByPrice::find($id);

        if (!$shop_by_price) {
            return redirect()->back()->with('danger', 'Shop by Price not found.');
        }

        if ($shop_by_price->image && file_exists(public_path($shop_by_price->image))) {
            unlink(public_path($shop_by_price->image));
        }

        $shop_by_price->delete();

        return redirect()->route('by.price.index')->with('success', 'Shop by Price has been deleted successfully');
    }
}
