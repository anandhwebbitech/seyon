<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\GiftWrap;
use Illuminate\Http\Request;

class GiftWrapController extends Controller
{
    public function index()
    {
        $giftwraps = GiftWrap::get();
        return view('admin.gift_wrap.index', compact('giftwraps'));
    }

    public function create()
    {
        return view('admin.gift_wrap.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|regex:/^[A-Za-z0-9 _-]+$/',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        $data = $request->only(['name', 'price', 'status']);

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/giftwraps'), $fileName);
            $data['image'] = 'uploads/giftwraps/' . $fileName;
        }

        GiftWrap::create($data);

        return redirect()->route('gift-wrap.index')->with('success', 'Gift Wrap added successfully.');
    }

    public function edit($id)
    {
        $giftwrap = GiftWrap::findOrFail($id);
        return view('admin.gift_wrap.edit', compact('giftwrap'));
    }

    public function update(Request $request, $id)
    {
        $giftwrap = GiftWrap::findOrFail($id);

        $request->validate([
            'name' => 'required|regex:/^[A-Za-z0-9 _-]+$/',
            'price' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);


        $data = $request->only(['name', 'price', 'status']);

        if ($request->hasFile('image')) {
            $fileName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/giftwraps'), $fileName);
            $data['image'] = 'uploads/giftwraps/' . $fileName;
        }

        $giftwrap->update($data);

        return redirect()->route('gift-wrap.index')->with('success', 'Gift Wrap updated successfully.');
    }

    public function destroy($id)
    {
        $giftwrap = GiftWrap::findOrFail($id);
        if ($giftwrap->image && file_exists(public_path($giftwrap->image))) {
            unlink(public_path($giftwrap->image));
        }
        $giftwrap->delete();

        return redirect()->route('gift-wrap.index')->with('success', 'Gift Wrap deleted successfully.');
    }
}
