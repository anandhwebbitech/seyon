<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ShopByReels;
use Illuminate\Http\Request;

class ShopByReelController extends Controller
{
    public function index()
    {
        $reels = ShopByReels::latest()->get();
        return view('admin.shop_by_reels.index', compact('reels'));
    }

    // 🔹 Show create form
    public function create()
    {
        return view('admin.shop_by_reels.create');
    }

    // 🔹 Store new reel
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        ShopByReels::create([
            'title' => $request->title,
            'url' => $request->url,
            'redirect_url' => $request->redirect_url,
            'status' => $request->status,
        ]);

        return redirect()->route('shop-by-reels.index')->with('success', 'Reel added successfully');
    }

    // 🔹 Show edit form
    public function edit($id)
    {
        $shopByReel = ShopByReels::findOrFail($id);
        return view('admin.shop_by_reels.edit', compact('shopByReel'));
    }

    // 🔹 Update reel
    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'url' => 'nullable|string|max:255',
            'redirect_url' => 'nullable|string|max:255',
            'status' => 'required|boolean',
        ]);

        $reel = ShopByReels::findOrFail($id);

        $reel->update([
            'title' => $request->title,
            'url' => $request->url,
            'redirect_url' => $request->redirect_url,
            'status' => $request->status,
        ]);

        return redirect()->route('shop-by-reels.index')->with('success', 'Reel updated successfully');
    }

    // 🔹 Delete reel
    public function destroy($id)
    {
        ShopByReels::findOrFail($id)->delete();

        return redirect()->back()->with('success', 'Reel deleted successfully');
    }

    // 🔹 Toggle status (Optional but useful)
    public function toggleStatus($id)
    {
        $reel = ShopByReels::findOrFail($id);
        $reel->status = !$reel->status;
        $reel->save();

        return response()->json([
            'success' => true,
            'status' => $reel->status
        ]);
    }
}
