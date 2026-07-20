<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CallToAction;
use App\Models\ShopByAge;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ShopByAgeController extends Controller
{
    public function index(){
        $shop_by_age = ShopByAge::orderBy('priority', 'asc')->get();
        return view('admin.shop_by_age.index', compact('shop_by_age'));
    }

    public function create(){
        return view('admin.shop_by_age.create');
    }

    public function store(Request $request){
        $request->validate([
            'title' => 'required|string|max:255',
            'url'   => 'required|string|max:255',
            'priority' => 'required|integer|min:0',
            'image' => 'required|image|mimes:jpg,jpeg,png,gif,webp|max:8048',
        ]);
        $shop_by_age = new ShopByAge();
        
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/shop_by_age'), $fileName);
            $shop_by_age->image = 'uploads/shop_by_age/' . $fileName;
        } else {
            return redirect()->back()->with(['danger' => 'Please upload an image.']);
        }
        $slug = Str::slug($request->title);

        $originalSlug = $slug;
        $count = 1;

        while (ShopByAge::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $shop_by_age->title = $request->title;
        $shop_by_age->url   = $request->url;
        $shop_by_age->slug  = $slug;
        $shop_by_age->priority = $request->priority;
        $shop_by_age->status = $request->status ?? 1;
        $shop_by_age->save();
    
        if ($shop_by_age) {
            return redirect()->route('shop.by.index')->with(['success' => 'Shop by Age has been added successfully']);
        } else {
            return redirect()->back()->with('danger', 'Failed to add Shop by Age.');
        }
    } 

    public function edit($id){
        $shop_by_age = ShopByAge::find($id);
        if($shop_by_age){
            return view('admin.shop_by_age.edit',compact('shop_by_age'));
        }
        return redirect()->back()->with('danger', 'Failed to add Shop by Age.');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title'  => 'required|string|max:255',
            'url'    => 'required|string|max:255',
            'priority' => 'required|integer|min:0',
            'status' => 'required|in:0,1',
        ]);

        $shop_by_age = ShopByAge::find($id);

        if (!$shop_by_age) {
            return redirect()->back()->with('danger', 'Shop by Age not found.');
        }
        $slug = Str::slug($request->title);

        $originalSlug = $slug;
        $count = 1;

        while (ShopByAge::where('slug', $slug)->exists()) {
            $slug = $originalSlug . '-' . $count;
            $count++;
        }
        $shop_by_age->title   = $request->title;
        $shop_by_age->url     = $request->url;
        $shop_by_age->slug    = $slug;
        $shop_by_age->priority = $request->priority;
        $shop_by_age->status  = $request->status;

        if ($request->hasFile('image')) {
            if ($shop_by_age->image && file_exists(public_path($shop_by_age->image))) {
                unlink(public_path($shop_by_age->image));
            }

            $image    = $request->file('image');
            $fileName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/shop_by_age'), $fileName);
            $shop_by_age->image = 'uploads/shop_by_age/' . $fileName;
        }

        $shop_by_age->save();

        return redirect()->route('shop.by.index')->with('success', 'Shop by Age has been updated successfully');
    }

    public function delete($id)
    {
        $shop_by_age = ShopByAge::find($id);

        if (!$shop_by_age) {
            return redirect()->back()->with('danger', 'Shop by Age not found.');
        }

        if ($shop_by_age->image && file_exists(public_path($shop_by_age->image))) {
            unlink(public_path($shop_by_age->image));
        }

        $shop_by_age->delete();

        return redirect()->route('shop.by.index')->with('success', 'Shop by Age has been deleted successfully');
    }

    public function callToAction(){
        $call_to_action = CallToAction::where('status',1)->get();
        $types = ['call_to_action_main','call_to_action_sub','call_to_action_sub1','call_to_action_sub2'];
        return view('admin.call_to_action.index',compact('call_to_action','types'));
    }

   public function callToActionStore(Request $request)
{
    $types = $request->input('types', []);

    // Loop through types to build dynamic validation rules
    $rules = [];
    foreach ($types as $type) {
        $rules["title.$type"] = 'required|string|max:255';
        $rules["description.$type"] = 'required|string';
        $rules["url.$type"] = 'required|url';
        $rules["status.$type"] = 'required|in:0,1';
        $rules["image.$type"] = 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048';
    }

    $messages = [];
    foreach ($types as $type) {
        $messages["title.$type.required"] = "Title for " . ucfirst(str_replace('_', ' ', $type)) . " is required.";
        $messages["description.$type.required"] = "Description for " . ucfirst(str_replace('_', ' ', $type)) . " is required.";
        $messages["url.$type.required"] = "URL for " . ucfirst(str_replace('_', ' ', $type)) . " is required.";
        $messages["url.$type.url"] = "URL for " . ucfirst(str_replace('_', ' ', $type)) . " must be valid.";
        $messages["status.$type.required"] = "Status for " . ucfirst(str_replace('_', ' ', $type)) . " is required.";
        $messages["status.$type.in"] = "Status for " . ucfirst(str_replace('_', ' ', $type)) . " must be Active or Inactive.";
        $messages["image.$type.image"] = "Image for " . ucfirst(str_replace('_', ' ', $type)) . " must be an image file.";
        $messages["image.$type.mimes"] = "Image for " . ucfirst(str_replace('_', ' ', $type)) . " must be jpeg, png, jpg, gif, or webp.";
        $messages["image.$type.max"] = "Image for " . ucfirst(str_replace('_', ' ', $type)) . " must be less than 2MB.";
    }

    $request->validate($rules, $messages);

    foreach ($types as $type) {
        $cta = CallToAction::firstOrNew(['name' => $type]);

        $cta->name = $type;
        $cta->title = $request->title[$type];
        $cta->description = $request->description[$type];
        $cta->url = $request->url[$type];
        $cta->status = $request->status[$type];

        if ($request->hasFile("image.$type")) {
            // Delete old image if exists
            if (!empty($cta->image) && file_exists(public_path($cta->image))) {
                unlink(public_path($cta->image));
            }

            $image = $request->file("image.$type");
            $fileName = time() . '_' . $type . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/call_to_action'), $fileName);
            $cta->image = 'uploads/call_to_action/' . $fileName;
        }

        $cta->save();
    }

    return redirect()->back()->with('success', 'Call To Action updated successfully.');
}

}