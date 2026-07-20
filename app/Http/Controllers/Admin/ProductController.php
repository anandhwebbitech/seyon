<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Color;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Upload;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\ProductSubmenu;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;
use Mail;
use PDF;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{

    //category

    public function productCategory(Request $request)
    {
        $category = ProductCategory::latest()->get();
        return view('admin.product.category.index', compact('category'));
    }

    public function productCategoryAdd(Request $request)
    {
        return view('admin.product.category.add');
    }

    public function productCategoryStore(Request $request)
    {
        $request->validate([
            'name'   => 'required|string|max:255',
            'status' => 'required|in:0,1',
            'category_image' => 'required|image|mimes:webp,jpg,jpeg,png,gif|max:2048',
        ]);

        $category = new ProductCategory();
        $category->name   = $request->name;
        $category->status = $request->status;

        if ($request->hasFile('category_image')) {
            $image     = $request->file('category_image');
            $fileName  = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category_images'), $fileName);
            $category->category_image = 'uploads/category_images/' . $fileName;
        }

        $category->save();

        return redirect()
            ->route('admin.product.category')
            ->with('success', 'Product category has been added successfully');
    }

    public function productCategoryEdit($id)
    {
        $category = ProductCategory::findOrFail($id);
        return view('admin.product.category.edit', compact('category'));
    }


    public function productCategoryUpdate(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:product_categories,id',
            'name'       => 'required|string|max:255',
            'status'     => 'required|in:0,1',
            'category_image' => 'nullable|image|mimes:jpg,jpeg,png,gif|max:2048',
        ]);

        $category = ProductCategory::findOrFail($request->product_id);
        $category->name   = $request->name;
        $category->status = $request->status;

        if ($request->hasFile('category_image')) {
            if ($category->category_image && file_exists(public_path($category->category_image))) {
                unlink(public_path($category->category_image));
            }

            $image    = $request->file('category_image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/category_images'), $fileName);
            $category->category_image = 'uploads/category_images/' . $fileName;
        }

        $category->save();

        return redirect()
            ->route('admin.product.category')
            ->with('success', 'Product category has been updated successfully');
    }


    public function productCategoryImgDelete($id, $name)
    {
        $category_image = ProductCategory::where('id', $id)->where('category_image', $name)->first();
        if ($category_image) {
            if ($category_image) {
                $category_image->category_image = null;
                $category_image->save();
            }
        }

        $imagePath = public_path('product_images/category_images/' . $name);
        if (file_exists($imagePath)) {
            unlink($imagePath);
        }

        return redirect()->back();
    }


    //sub-category

    public function productSubCategory(Request $request)
    {
        $category = ProductSubCategory::latest()->get();
        return view('admin.product.subcategory.index', compact('category'));
    }

    public function productSubCategoryAdd(Request $request)
    {
        return view('admin.product.subcategory.add');
    }

    public function productSubCategoryStore(Request $request)
    {
        $subcategory                 = new ProductSubCategory();
        $subcategory->name           = $request->name;
        $subcategory->category_id    = $request->category_id;
        if ($request->hasFile('subcategory_image')) {
            $image    = $request->file('subcategory_image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sub_category_images'), $fileName);
            $subcategory->subcategory_image = 'uploads/sub_category_images/' . $fileName;
        }
        $subcategory->status         = $request->status;
        $subcategory->save();
        if ($subcategory) {
            return redirect()->route('admin.product.subcategory')->with('success', 'Product subcategory has been added successfully');
        }
    }

    public function productSubCategoryEdit($id)
    {
        $subcategory = ProductSubCategory::findOrFail($id);
        return view('admin.product.subcategory.edit', compact('subcategory'));
    }


    public function productSubCategoryUpdate(Request $request)
    {
        $category                 = ProductSubCategory::where('id', $request->subcategory_id)->first();
        $category->category_id    = $request->category_id;
        $category->name           = $request->name;

        if ($request->hasFile('subcategory_image')) {
            if ($category->subcategory_image && file_exists(public_path($category->subcategory_image))) {
                unlink(public_path($category->subcategory_image));
            }

            $image    = $request->file('subcategory_image');
            $fileName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('uploads/sub_category_images'), $fileName);
            $category->subcategory_image = 'uploads/sub_category_images/' . $fileName;
        }
        $category->status         = $request->status;
        $category->save();
        if ($category) {
            return redirect()->route('admin.product.subcategory')->with('success', 'Product subcategory has been updated successfully');
        }
    }



    //product

    public function product(Request $request)
    {
        $product = Product::latest()->get();
        return view('admin.product.index', compact('product'));
    }

    public function productAdd(Request $request)
    {
        $product = Product::latest()->get();
        return view('admin.product.add', compact('product'));
    }

    public function getSubcategories($id)
    {
        $subcategories = ProductSubCategory::where("category_id", $id)->pluck("name", "id");
        return response()->json($subcategories);
    }
    public function getMenus($id)
    {
        $submenus = ProductSubmenu::where("subcategory_id", $id)->pluck("name", "id");
        return response()->json($submenus);
    }


    // public function productStore(Request $request)
    // {
    //     $request->validate([
    //         'product_type'    => 'required',
    //         'shop_by_age_id'  => 'required|exists:shop_by_ages,id',
    //         'shop_by_price'   => 'required|exists:shop_by_prices,id',
    //         'category_id'     => 'required|exists:product_categories,id',
    //         // 'submenu'         => 'required|exists:product_submenus,id',
    //         'product_name'    => 'required|string|max:255',
    //         'quantity'        => 'required|integer|min:1',
    //         'actual_price'    => 'required|numeric|min:0',
    //         'discount'        => 'nullable|numeric|min:0|max:100',
    //         'offer_price'     => 'required|numeric|min:0',
    //         'file1'           => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         'file2.*'         => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
    //         'description'     => 'required|string',
    //         // 'colors.*'        => 'nullable|exists:colors,id',
    //         'color' => 'nullable|array',
    //         'color.*.colors' => 'nullable|required_if:is_color,1',
    //         'color.*.color_quantity' => 'nullable|required_if:is_color,1|numeric|min:1',
    //     ]);

    //     date_default_timezone_set('Asia/Kolkata');

    //     $product = new Product();
    //     $product->type             = $request->product_type;
    //     $product->shop_by_price_id = $request->shop_by_price;
    //     $product->category_id  = $request->category_id;
    //     $product->subcategory  = $request->subcategory;
    //     $product->sub_menu_id  = $request->submenu;
    //     $product->product_name = $request->product_name;
    //     $product->quantity     = $request->quantity;
    //     $product->orginal_rate = $request->actual_price;
    //     $product->description  = $request->description;
    //     $product->discount     = $request->discount;
    //     $product->offer_price  = $request->offer_price;
    //     $product->is_color     = $request->is_color;
    //     // $product->gst          = $request->gst;
    //     $product->sku          = $request->sku;
    //     if ($request->product_type == "book") {
    //         $product->no_of_pages = $request->pages;
    //     }
    //     $product->keyword      = $request->keywords;
    //     $product->status       = $request->status;

    //     // Optional flags
    //     $product->best_sellers = $request->best_sellers ?? 0;
    //     $product->new_arrival  = $request->new_arrival ?? 0;
    //     $product->on_sale      = $request->on_sale ?? 0;
    //     $product->featured     = $request->featured ?? 0;

    //     // Main product image
    //     if ($request->hasFile('file1')) {
    //         $file = $request->file('file1');
    //         $fileName = time() . '.' . $file->getClientOriginalExtension();
    //         $file->move(public_path('uploads/product_images'), $fileName);
    //         $product->product_img = 'uploads/product_images/' . $fileName;
    //     }

    //     $product->save();
    //     $product->shopByAges()->sync($request->shop_by_age_id);

    //     // Sync colors only if is_color = 1
    //     if ($request->is_color == 1 && $request->filled('color')) {

    //         $syncData = [];

    //         foreach ($request->color as $row) {

    //             if (!empty($row['colors'])) {
    //                 $syncData[$row['colors']] = [
    //                     'qty' => $row['color_quantity'] ?? 0
    //                 ];
    //             }
    //         }

    //         $product->colors()->sync($syncData);

    //     } else {
    //         $product->colors()->sync([]);
    //     }

    //     // Gallery images
    //     if ($request->hasFile('file2')) {
    //         foreach ($request->file('file2') as $index => $image) {
    //             $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
    //             $image->move(public_path('uploads/product_images'), $imageName);

    //             $upload = new Upload();
    //             $upload->name       = $imageName;
    //             $upload->path       = 'uploads/product_images/' . $imageName;
    //             $upload->product_id = $product->id;
    //             $upload->save();
    //         }
    //     }

    //     return redirect()->route('admin.product')->with('success', 'Product has been added successfully');
    // }
    
    // public function productStore(Request $request)
    // {
    //     // 1. Validation Rules
    //     $request->validate([
    //         'product_type'    => 'required',
    //         'shop_by_age_id'  => 'required|array', 
    //         'shop_by_age_id.*'=> 'exists:shop_by_ages,id',
    //         'shop_by_price'   => 'required|exists:shop_by_prices,id',
    //         'category_id'     => 'required|exists:product_categories,id',
    //         'product_name'    => 'required|string|max:255',
    //         'quantity'        => 'required|integer|min:1',
    //         'actual_price'    => 'required|numeric|min:0',
    //         'discount'        => 'nullable|numeric|min:0|max:100',
    //         'offer_price'     => 'required|numeric|min:0',            
    //         'file1'           => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',             
    //         'file2'           => 'nullable|array',
    //         'file2.*'         => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',            
    //         'description'     => 'required|string',
    //         'color'           => 'nullable|array',
    //         'color.*.colors'  => 'nullable|required_if:is_color,1',
    //         'color.*.color_quantity' => 'nullable|required_if:is_color,1|numeric|min:1',
    //     ]);
    
    //     date_default_timezone_set('Asia/Kolkata');    
    //     $product = new Product();
    //     $product->type             = $request->product_type;
    //     $product->shop_by_price_id = $request->shop_by_price;
    //     $product->category_id      = $request->category_id;
    //     $product->subcategory      = $request->subcategory;
    //     $product->sub_menu_id      = $request->submenu;
    //     $product->product_name     = $request->product_name;
    //     $product->quantity         = $request->quantity;
    //     $product->orginal_rate     = $request->actual_price;
    //     $product->description      = $request->description;
    //     $product->discount         = $request->discount;
    //     $product->offer_price      = $request->offer_price;
    //     $product->is_color         = $request->is_color;
    //     $product->sku              = $request->sku;        
    //     if ($request->product_type == "book") {
    //         $product->no_of_pages  = $request->pages;
    //     }
    //     $product->keyword          = $request->keywords;
    //     $product->status           = $request->status;    
    //     $product->best_sellers     = $request->best_sellers ?? 0;
    //     $product->new_arrival      = $request->new_arrival ?? 0;
    //     $product->on_sale          = $request->on_sale ?? 0;
    //     $product->featured         = $request->featured ?? 0;    
    //     $destinationPath = public_path('uploads/product_images');
    //     if (!file_exists($destinationPath)) {
    //         mkdir($destinationPath, 0755, true);
    //     }    
    //     if ($request->hasFile('file1')) {
    //         $file1 = $request->file('file1');
    //         $fileName1 = time() . '_' . uniqid() . '.' . $file1->getClientOriginalExtension();            
    //         $file1->move($destinationPath, $fileName1);            
    //         $product->product_img = 'uploads/product_images/' . $fileName1;
    //     }
    //         $product->save();        
    //     $product->shopByAges()->sync($request->shop_by_age_id);    
    //     if ($request->is_color == 1 && $request->filled('color')) {
    //         $syncData = [];
    //         foreach ($request->color as $row) {
    //             if (!empty($row['colors'])) {
    //                 $syncData[$row['colors']] = [
    //                     'qty' => $row['color_quantity'] ?? 0
    //                 ];
    //             }
    //         }
    //         $product->colors()->sync($syncData);
    //     } else {
    //         $product->colors()->sync([]);
    //     }
    //     if ($request->hasFile('file2')) {
    //         foreach ($request->file('file2') as $index => $galleryFile) {
    //             if ($galleryFile->isValid()) {
    //                 $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $galleryFile->getClientOriginalExtension();                    
    //                 $galleryFile->move($destinationPath, $imageName);    
    //                 $upload = new Upload();
    //                 $upload->name = $imageName;
    //                 $upload->path = 'uploads/product_images/' . $imageName;
    //                 $upload->product_id = $product->id;
    //                 $upload->save();
    //             }
    //         }
    //     }    
    //     return redirect()->route('admin.product')->with('success', 'Product has been added successfully');
    // }
    public function productStore(Request $request)
    {
        // 1. Validation Rules
        $request->validate([
            'product_type'           => 'required',
            'shop_by_age_id'         => 'required|array', 
            'shop_by_age_id.*'       => 'exists:shop_by_ages,id',
            'shop_by_price'          => 'required|exists:shop_by_prices,id',
            'category_id'            => 'required|exists:product_categories,id',
            'product_name'           => 'required|string|max:255',
            'quantity'               => 'required|integer|min:1',
            'actual_price'           => 'required|numeric|min:0',
            'discount'               => 'nullable|numeric|min:0|max:100',
            'offer_price'            => 'required|numeric|min:0',            
            'file1'                  => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',             
            'file2'                  => 'nullable|array',
            'file2.*'                => 'image|mimes:jpeg,png,jpg,gif,svg,webp|max:1024',             
            'description'            => 'required|string',
            'keywords'               => 'nullable|string',
            'is_color'               => 'required|in:0,1',
            'option_type'            => 'required_if:is_color,1|in:color,variant',
            'color'                  => 'nullable|array',
            'color.*.colors'         => 'nullable|exists:colors,id',
            'color.*.color_quantity' => 'nullable|required_if:is_color,1|numeric|min:1',
            'color.*.variant_name'   => 'nullable|required_if:option_type,variant|string|max:255',
        ]);

        date_default_timezone_set('Asia/Kolkata');    
        $product = new Product();
        $product->type             = $request->product_type;
        $product->shop_by_price_id = $request->shop_by_price;
        $product->category_id      = $request->category_id;
        $product->subcategory      = $request->subcategory;
        $product->sub_menu_id      = $request->submenu;
        $product->product_name     = $request->product_name;
        $product->quantity         = $request->quantity;
        $product->orginal_rate     = $request->actual_price;
        $product->description      = $request->description;
        $product->discount         = $request->discount;
        $product->offer_price      = $request->offer_price;
        $product->is_color         = $request->is_color;
        $product->option_type      = $request->is_color == 1 ? $request->option_type : 'color';
        $product->sku              = $request->sku;        
        
        if ($request->product_type == "book") {
            $product->no_of_pages  = $request->pages;
        }
        
        $product->keyword          = $request->keywords;
        $product->status           = $request->status;    
        $product->best_sellers     = $request->best_sellers ?? 0;
        $product->new_arrival      = $request->new_arrival ?? 0;
        $product->on_sale          = $request->on_sale ?? 0;
        $product->featured         = $request->featured ?? 0;
        
        // Image Upload Destination Setup
        $destinationPath = public_path('uploads/product_images');
        if (!file_exists($destinationPath)) {
            mkdir($destinationPath, 0755, true);
        }    
        
        // Main Product Image processing (file1)
        if ($request->hasFile('file1')) {
            $file1 = $request->file('file1');
            $fileName1 = time() . '_' . uniqid() . '.' . $file1->getClientOriginalExtension();            
            $file1->move($destinationPath, $fileName1);            
            $product->product_img = 'uploads/product_images/' . $fileName1;
        }
        
        // Save Product to generate ID
        $product->save();        
        
        // Sync Age categories
        $product->shopByAges()->sync($request->shop_by_age_id);    

        // 2. Pivot Table Syncing (Color & Variant details)
        if ($request->is_color == 1 && $request->filled('color')) {
            
            $product->colors()->detach(); 

            foreach ($request->color as $row) {
                $colorId = !empty($row['colors']) ? $row['colors'] : null;
                
                \DB::table('color_product')->insert([
                    'product_id'   => $product->id,
                    'color_id'     => $colorId,
                    'qty'          => $row['color_quantity'] ?? 0,
                    'variant_name' => ($request->option_type === 'variant') ? ($row['variant_name'] ?? null) : null,
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }
        } else {
            $product->colors()->detach();
        }

        // 3. Gallery Images Upload Loop (file2)
        if ($request->hasFile('file2')) {
            foreach ($request->file('file2') as $index => $galleryFile) {
                if ($galleryFile->isValid()) {
                    $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $galleryFile->getClientOriginalExtension();                    
                    $galleryFile->move($destinationPath, $imageName);    
                    
                    $upload = new Upload();
                    $upload->name = $imageName;
                    $upload->path = 'uploads/product_images/' . $imageName;
                    $upload->product_id = $product->id;
                    $upload->save();
                }
            }
        }    
        
        return redirect()->route('admin.product')->with('success', 'Product created successfully!');
    }
/**
 * Helper function to crop and resize image to 1:1 ratio using PHP GD
 */
private function resizeAndCropToSquare($sourcePath, $destinationPath, $targetSize = 600)
{
    $imageInfo = getimagesize($sourcePath);
    if (!$imageInfo) {
        return; 
    }
    $mime = $imageInfo['mime'];

    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            $sourceImage = imagecreatefromjpeg($sourcePath);
            break;
        case 'image/png':
            $sourceImage = imagecreatefrompng($sourcePath);
            imagealphablending($sourceImage, true);
            break;
        case 'image/gif':
            $sourceImage = imagecreatefromgif($sourcePath);
            break;
        case 'image/webp':
            $sourceImage = imagecreatefromwebp($sourcePath);
            break;
        default:
            move_uploaded_file($sourcePath, $destinationPath);
            return;
    }

    $width = imagesx($sourceImage);
    $height = imagesy($sourceImage);

    // 1:1 Center Crop 
    if ($width > $height) {
        $squareSize = $height;
        $src_x = ($width - $height) / 2;
        $src_y = 0;
    } else {
        $squareSize = $width;
        $src_x = 0;
        $src_y = ($height - $width) / 2;
    }

    $destinationImage = imagecreatetruecolor($targetSize, $targetSize);

    if ($mime == 'image/png' || $mime == 'image/webp') {
        imagealphablending($destinationImage, false);
        imagesavealpha($destinationImage, true);
        $transparent = imagecolorallocatealpha($destinationImage, 255, 255, 255, 127);
        imagefilledrectangle($destinationImage, 0, 0, $targetSize, $targetSize, $transparent);
    }

    imagecopyresampled(
        $destinationImage, $sourceImage,
        0, 0, $src_x, $src_y,
        $targetSize, $targetSize, $squareSize, $squareSize
    );

    switch ($mime) {
        case 'image/jpeg':
        case 'image/jpg':
            imagejpeg($destinationImage, $destinationPath, 90);
            break;
        case 'image/png':
            imagepng($destinationImage, $destinationPath, 6);
            break;
        case 'image/gif':
            imagegif($destinationImage, $destinationPath);
            break;
        case 'image/webp':
            imagewebp($destinationImage, $destinationPath, 85);
            break;
    }

    imagedestroy($sourceImage);
    imagedestroy($destinationImage);
}

    //coupon code

    public function coupon_code(Request $request)
    {
        $coupon_code = Coupon::latest()->get();
        return view('admin.product.coupon_code.index', compact('coupon_code'));
    }

    public function coupon_code_add(Request $request)
    {
        return view('admin.product.coupon_code.add');
    }

    public function coupon_code_store(Request $request)
    {
        $coupon_code                 = new Coupon();
        $coupon_code->code           = $request->code;
        $coupon_code->percentage     = $request->percentage;
        $coupon_code->status         = $request->status;
        $coupon_code->save();
        if ($coupon_code) {
            return redirect()->route('admin.coupon_code')->with('success', 'Coupon code has been added successfully');
        }
    }

    public function coupon_code_edit($id)
    {
        $coupon_code = Coupon::findOrFail($id);
        return view('admin.product.coupon_code.edit', compact('coupon_code'));
    }


    public function coupon_code_update(Request $request)
    {
        $coupon_code                 = Coupon::where('id', $request->coupon_id)->first();
        $coupon_code->code           = $request->code;
        $coupon_code->percentage     = $request->percentage;
        $coupon_code->status         = $request->status;
        $coupon_code->save();
        if ($coupon_code) {
            return redirect()->route('admin.coupon_code')->with('success', 'Coupon code has been updated successfully');
        }
    }

    public function coupon_code_delete($id)
    {
        $coupon_code                 = Coupon::where('id', $id)->first();
        $coupon_code->delete();
        if ($coupon_code) {
            return redirect()->route('admin.coupon_code')->with('success', 'Coupon code has been deleted successfully');
        }
    }

    public function AjaxCrop(Request $request)
    {
        if (isset($request->image)) {
            $data = $request->image;
            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);
            $image_data = base64_decode($image_array_2[1]);

            $imageName = time() . '.jpg';

            $image_path =  ('public/product_images/category_images') . '/' . $imageName;

            file_put_contents($image_path, $image_data);

            return response()->json(['image_url' =>  asset('public/product_images/category_images/' . $imageName), 'image_name' => $imageName]);
        }
    }

    public function AjaxCropSubcat(Request $request)
    {
        if (isset($request->image)) {
            $data = $request->image;
            $image_array_1 = explode(";", $data);

            $image_array_2 = explode(",", $image_array_1[1]);
            $image_data = base64_decode($image_array_2[1]);

            $imageName = time() . '.jpg';

            $image_path =  ('public/product_images/subcategory_images') . '/' . $imageName;

            file_put_contents($image_path, $image_data);

            return response()->json(['image_url' =>  asset('public/product_images/subcategory_images/' . $imageName), 'image_name' => $imageName]);
        }
    }


    public function productDelete($id)
    {
        try {
            $product = Product::findOrFail($id);

            if ($product->product_img && file_exists(public_path($product->product_img))) {
                unlink(public_path($product->product_img));
            }

            $galleryImages = Upload::where('product_id', $product->id)->get();
            foreach ($galleryImages as $image) {
                if ($image->path && file_exists(public_path($image->path))) {
                    unlink(public_path($image->path));
                }
                $image->delete();
            }

            $product->delete();

            return redirect()->back()->with('success', 'Product deleted successfully');
        } catch (\Exception $e) {
            Log::error("Error deleting product ID: $id. Error: " . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while deleting the product');
        }
    }



    // public function productEdit($id)
    // {
    //     $product = Product::findOrFail($id);
    //     $categories = ProductCategory::get();
    //     $subcategories = ProductSubCategory::where('category_id', $product->category_id)->get();
    //     $submenus = ProductSubMenu::where('subcategory_id', $product->subcategory)->get();
    //     return view('admin.product.edit', compact('product', 'categories', 'subcategories', 'submenus'));
    // }
public function productEdit($id)
{
    $product = Product::findOrFail($id);
    
    // Left Join moolama variants and pure variant names edukirom
    $productVariants = \DB::table('color_product')
        ->leftJoin('colors', 'color_product.color_id', '=', 'colors.id')
        ->where('color_product.product_id', $id)
        ->select(
            'color_product.id as pivot_id',
            'color_product.color_id',
            'color_product.variant_name',
            'color_product.qty'
        )
        ->get();

    $categories = ProductCategory::get();
    $subcategories = ProductSubCategory::where('category_id', $product->category_id)->get();
    $submenus = ProductSubMenu::where('subcategory_id', $product->subcategory)->get();
    
    return view('admin.product.edit', compact(
        'product', 
        'productVariants', // Intha data-va blade-ku anuprom
        'categories', 
        'subcategories', 
        'submenus'
    ));
}

    public function deleteImage(Request $request)
    {
        $upload = Upload::find($request->id);

        if ($upload) {
            $imagePath = public_path($upload->path);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            $upload->delete();

            return response()->json(['success' => true]);
        } else {
            return response()->json(['error' => 'Image not found.'], 404);
        }
    }

    // public function adminProductUpdate(Request $request)
    // {
    //     $rules = [
    //         'product_type' => 'required|in:book,toys',

    //         'category_id'  => 'required|exists:product_categories,id',
    //         // 'subcategory'  => 'required|exists:product_sub_categories,id',
    //         // 'submenu'      => 'required|exists:product_submenus,id',

    //         'shop_by_age_id'   => 'required|array|min:1',
    //         'shop_by_age_id.*' => 'exists:shop_by_ages,id',

    //         'shop_by_price' => 'required|exists:shop_by_prices,id',

    //         'product_name' => 'required|string|max:255',
    //         'quantity'     => 'required|integer|min:1',

    //         'actual_price' => 'required|numeric|min:0',
    //         'offer_price'  => 'required|numeric|min:0|lte:actual_price',
    //         'discount'     => 'nullable|numeric|min:0|max:100',

    //         'description' => 'required|string',

    //         'file1'   => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
    //         'file2'   => 'nullable|array|max:4',
    //         'file2.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048',
    //     ];

    //     // ✅ Conditional validation for book pages
    //     if ($request->product_type === 'book') {
    //         $rules['pages'] = 'required|integer|min:1';
    //     }

    //     $messages = [
    //         'product_type.required' => 'Please select product type.',

    //         'category_id.required'  => 'Please select category.',
    //         'subcategory.required'  => 'Please select subcategory.',
    //         'submenu.required'      => 'Please select submenu.',

    //         'shop_by_age_id.required' => 'Please select at least one age group.',
    //         'shop_by_price.required'  => 'Please select shop by price.',

    //         'product_name.required' => 'Product name is required.',
    //         'quantity.required'     => 'Quantity is required.',
    //         'quantity.integer'      => 'Quantity must be a number.',

    //         'actual_price.required' => 'Actual price is required.',
    //         'offer_price.required'  => 'Offer price is required.',
    //         'offer_price.lte'       => 'Offer price cannot be greater than actual price.',

    //         'pages.required' => 'Please enter number of pages for the book.',

    //         'description.required' => 'Description is required.',
    //     ];

    //     $request->validate($rules, $messages);

    //     // ================= SAVE PRODUCT =================

    //     $product = Product::findOrFail($request->product_id);

    //     $product->type             = $request->product_type;
    //     $product->category_id      = $request->category_id;
    //     $product->subcategory      = $request->subcategory;
    //     $product->sub_menu_id      = $request->submenu;
    //     $product->shop_by_price_id = $request->shop_by_price;

    //     $product->product_name = $request->product_name;
    //     $product->quantity     = $request->quantity;
    //     $product->orginal_rate = $request->actual_price;
    //     $product->offer_price  = $request->offer_price;
    //     $product->discount     = $request->discount;
    //     $product->description  = $request->description;
    //     $product->sku          = $request->sku;
    //     $product->status       = $request->status;
    //     $product->is_color     = $request->is_color;

    //     if ($request->product_type === 'book') {
    //         $product->no_of_pages = $request->pages;
    //     }

    //     $product->best_sellers = $request->best_sellers ?? 0;
    //     $product->new_arrival  = $request->new_arrival ?? 0;
    //     $product->on_sale      = $request->on_sale ?? 0;
    //     $product->featured     = $request->featured ?? 0;

    //     // Thumbnail
    //     if ($request->hasFile('file1')) {
    //         $fileName = time() . '.' . $request->file('file1')->getClientOriginalExtension();
    //         $request->file('file1')->move(public_path('uploads/product_images'), $fileName);
    //         $product->product_img = 'uploads/product_images/' . $fileName;
    //     }

    //     $product->save();
    //     $product->shopByAges()->sync($request->shop_by_age_id);

    //     // Sync shop by ages
    //     if ($request->is_color == 1 && $request->filled('color')) {

    //         $syncData = [];

    //         foreach ($request->color as $row) {

    //             if (!empty($row['colors'])) {
    //                 $syncData[$row['colors']] = [
    //                     'qty' => $row['color_quantity'] ?? 0
    //                 ];
    //             }
    //         }

    //         $product->colors()->sync($syncData);

    //     } else {
    //         $product->colors()->sync([]);
    //     }

    //     // Gallery images
    //     if ($request->hasFile('file2')) {
    //         foreach ($request->file('file2') as $index => $image) {
    //             $imageName = time() . '_' . $index . '.' . $image->getClientOriginalExtension();
    //             // dd($imageName);
    //             $image->move(public_path('uploads/product_images'), $imageName);

    //             Upload::create([
    //                 'name'       => $imageName,
    //                 'path'       => 'uploads/product_images/' . $imageName,
    //                 'product_id' => $product->id,
    //             ]);
    //         }
    //     }

    //     return redirect()
    //         ->route('admin.product')
    //         ->with('success', 'Product has been updated successfully');
    // }
    
    public function adminProductUpdate(Request $request)
    {
        // 1. Validation Rules (Store maariye details accurate-ah match panni irukom)
        $rules = [
            'product_type'           => 'required|in:book,toys,school_essentials',
            'category_id'            => 'required|exists:product_categories,id',
            'shop_by_age_id'         => 'required|array|min:1',
            'shop_by_age_id.*'       => 'exists:shop_by_ages,id',
            'shop_by_price'          => 'required|exists:shop_by_prices,id',
            'product_name'           => 'required|string|max:255',
            'quantity'               => 'required|integer|min:1',
            'actual_price'           => 'required|numeric|min:0',
            'offer_price'            => 'required|numeric|min:0|lte:actual_price',
            'discount'               => 'nullable|numeric|min:0|max:100',
            'description'            => 'required|string',
            'file1'                  => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'file2'                  => 'nullable|array|max:4',
            'file2.*'                => 'image|mimes:jpeg,png,jpg,webp|max:2048',
            'is_color'               => 'required|in:0,1',
            'option_type'            => 'required_if:is_color,1|in:color,variant',
            'keyword'                => 'nullable|string',
            'color'                  => 'nullable|array',
            'color.*.colors'         => 'nullable|exists:colors,id',
            'color.*.color_quantity' => 'nullable|required_if:is_color,1|numeric|min:1',
            'color.*.variant_name'   => 'nullable|required_if:option_type,variant|string|max:255',
        ];

        if ($request->product_type === 'book') {
            $rules['pages'] = 'required|integer|min:1';
        }

        $messages = [
            'product_type.required'   => 'Please select product type.',
            'category_id.required'    => 'Please select category.',
            'shop_by_age_id.required' => 'Please select at least one age group.',
            'shop_by_price.required'  => 'Please select shop by price.',
            'product_name.required'   => 'Product name is required.',
            'quantity.required'       => 'Quantity is required.',
            'actual_price.required'   => 'Actual price is required.',
            'offer_price.required'    => 'Offer price is required.',
            'offer_price.lte'         => 'Offer price cannot be greater than actual price.',
            'pages.required'          => 'Please enter number of pages for the book.',
            'description.required'    => 'Description is required.',
        ];

        $request->validate($rules, $messages);
        
        date_default_timezone_set('Asia/Kolkata');

        // ================= SAVE PRODUCT =================
        $product = Product::findOrFail($request->product_id);

        $product->type             = $request->product_type;
        $product->category_id      = $request->category_id;
        $product->subcategory      = $request->subcategory;
        $product->sub_menu_id      = $request->submenu;
        $product->shop_by_price_id = $request->shop_by_price;
        $product->product_name     = $request->product_name;
        $product->quantity         = $request->quantity;
        $product->orginal_rate     = $request->actual_price;
        $product->offer_price      = $request->offer_price;
        $product->discount         = $request->discount;
        $product->description      = $request->description;
        $product->sku              = $request->sku;
        $product->status           = $request->status;
        $product->is_color         = $request->is_color;
        $product->option_type      = $request->is_color == 1 ? $request->option_type : 'color';

        if ($request->product_type === 'book') {
            $product->no_of_pages = $request->pages;
        } else {
            $product->no_of_pages = null;
        }

        $product->keyword      = $request->keywords;
        $product->best_sellers = $request->best_sellers ?? 0;
        $product->new_arrival  = $request->new_arrival ?? 0;
        $product->on_sale      = $request->on_sale ?? 0;
        $product->featured     = $request->featured ?? 0;

        // Normal Thumbnail Upload (file1)
        if ($request->hasFile('file1')) {
            if ($product->product_img && file_exists(public_path($product->product_img))) {
                @unlink(public_path($product->product_img));
            }
            
            $fileName = time() . '_' . uniqid() . '.' . $request->file('file1')->getClientOriginalExtension();
            $request->file('file1')->move(public_path('uploads/product_images'), $fileName);
            $product->product_img = 'uploads/product_images/' . $fileName;
        }

        $product->save();

        // Sync shop by ages
        $product->shopByAges()->sync($request->shop_by_age_id);

        // ================= PIVOT TABLE SYNC (Store Maariye Dynamic Update) =================
        if ($request->is_color == 1 && $request->filled('color')) {
            // Pathaiya records ah clean panni refresh panrom
            $product->colors()->detach(); 

            foreach ($request->color as $row) {
                $colorId = !empty($row['colors']) ? $row['colors'] : null;
                
                \DB::table('color_product')->insert([
                    'product_id'   => $product->id,
                    'color_id'     => $colorId,
                    'qty'          => $row['color_quantity'] ?? 0,
                    'variant_name' => ($request->option_type === 'variant') ? ($row['variant_name'] ?? null) : null,
                    'created_at'   => now(),
                    'updated_at'   => now()
                ]);
            }
        } else {
            $product->colors()->detach();
        }

        // Handle Deleted Gallery Images
        if ($request->has('delete_gallery')) {
            foreach ($request->delete_gallery as $oldImageId) {
                $galleryImg = \App\Models\Upload::find($oldImageId);
                if ($galleryImg) {
                    if (file_exists(public_path($galleryImg->path))) {
                        @unlink(public_path($galleryImg->path));
                    }
                    $galleryImg->delete();
                }
            }
        }

        // Normal Multiple Gallery Upload (file2)
        if ($request->hasFile('file2')) {
            $destinationPath = public_path('uploads/product_images');
            foreach ($request->file('file2') as $index => $galleryFile) {
                if ($galleryFile->isValid()) {
                    $imageName = time() . '_' . $index . '_' . uniqid() . '.' . $galleryFile->getClientOriginalExtension();
                    $galleryFile->move($destinationPath, $imageName);
                    
                    $upload = new Upload();
                    $upload->name = $imageName;
                    $upload->path = 'uploads/product_images/' . $imageName; // Store folders path-odu match panniyachu
                    $upload->product_id = $product->id;
                    $upload->save();
                }
            }
        }

        return redirect()->back()->with('success', 'Product updated successfully.');
    }

    public function productCategoryDelete($id)
    {
        $category                 = ProductCategory::where('id', $id)->first();
        if (!empty($category->category_image)) {
            $imagePath = public_path($category->category_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $category->delete();
        if ($category) {
            return redirect()->route('admin.product.category')->with('success', 'category has been deleted successfully');
        }
    }

    public function productSubCategoryDelete($id)
    {
        $sub_category = ProductSubCategory::where('id', $id)->first();
        if (!empty($sub_category->subcategory_image)) {
            $imagePath = public_path($sub_category->subcategory_image);
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }
        }
        $sub_category->delete();
        if ($sub_category) {
            return redirect()->route('admin.product.subcategory')->with('success', 'product category code has been deleted successfully');
        }
    }

    public function productSubmenu(Request $request)
    {
        $submenu = ProductSubmenu::latest()->get();
        $category = ProductSubCategory::latest()->get();
        return view('admin.product.submenu.index', compact('submenu', 'category'));
    }
    public function productSubmenuAdd(Request $request)
    {
        $submenu = ProductSubmenu::latest()->get();
        $category = ProductSubCategory::latest()->get();
        return view('admin.product.submenu.add', compact('submenu', 'category'));
    }
    public function productSubmenuStore(Request $request)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'subcategory' => 'required|exists:product_sub_categories,id',
            'status'      => 'required|in:0,1',
        ]);
        $submenu                 = new ProductSubmenu();
        $submenu->name           = $request->name;
        $submenu->category_id    = $request->category_id;
        $submenu->subcategory_id = $request->subcategory;
        $submenu->status         = $request->status;
        $submenu->save();
        if ($submenu) {
            return redirect()->route('admin.product.submenu')->with('success', 'Product submenu has been added successfully');
        }
    }

    public function productSubmenuEdit($id)
    {
        $submenu = ProductSubmenu::findOrFail($id);
        $categories = ProductCategory::latest()->get();
        $subcategories = ProductSubCategory::where('category_id', $submenu->category_id)->get();
        return view('admin.product.submenu.edit', compact('submenu', 'categories', 'subcategories'));
    }
    public function productSubmenuUpdate(Request $request, $id)
    {
        $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:product_categories,id',
            'subcategory' => 'required|exists:product_sub_categories,id',
            'status'      => 'required|in:0,1',
        ]);

        $submenu                 = ProductSubmenu::where('id', $id)->first();
        $submenu->name           = $request->name;
        $submenu->category_id    = $request->category_id;
        $submenu->subcategory_id = $request->subcategory;
        $submenu->status         = $request->status;
        $submenu->save();
        if ($submenu) {
            return redirect()->route('admin.product.submenu')->with('success', 'Product submenu has been updated successfully');
        }
    }
    public function productSubmenuDelete($id)
    {
        $submenu = ProductSubmenu::where('id', $id)->first();
        $submenu->delete();
        if ($submenu) {
            return redirect()->route('admin.product.submenu')->with('success', 'Product submenu has been deleted successfully');
        }
    }

    //color code
   
    public function color(Request $request)
    {
        $color_code = Color::latest()->get();
        return view('admin.product.color.index',compact('color_code'));
    }
    
    public function color_add(Request $request)
    {
        return view('admin.product.color.add');
    }
    
    public function color_store(Request $request)
    {
        $request->validate([
            'color' => 'required|string|max:50',
            'code'  => 'required|regex:/^#[A-Fa-f0-9]{6}$/',
        ]);

        $color_code                = new Color();
        $color_code->color_code    = $request->code;
        $color_code->color         = $request->color;
        $color_code->save();
        if($color_code)
        {
            return redirect()->route('admin.color')->with('success', 'Color code has been added successfully');
        }
    }
    
    public function color_edit($id)
    {
        $color_code = Color::findOrFail($id);
        return view('admin.product.color.edit',compact('color_code'));
    }
    
    
    public function color_update(Request $request)
    {
        $color_code                 = Color::where('id',$request->coupon_id)->first();
        $color_code->color_code     = $request->code;
        $color_code->color          = $request->color;
        $color_code->save();
        if($color_code)
        {
            return redirect()->route('admin.color')->with('success', 'Color code has been updated successfully');
        }
    }
     
    public function color_delete($id)
    {
        $color_code                 = Color::where('id',$id)->first();
        if($color_code){
            $color_code->delete();
            return redirect()->route('admin.color')->with('success', 'Color code has been deleted successfully');
        }
        return redirect()->route('admin.color')->with('error', 'Color code failed to delete');
    }
}