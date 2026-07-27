<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Admin\MileStoneController;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Country;
use App\Models\Coupon;
use App\Models\Upload;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Product;
use App\Services\SmsService;
use App\Mail\ContactFormMail;
use App\Models\Address;
use App\Models\CallToAction;
use App\Models\Cart;
use App\Models\ColorProduct;
use App\Models\GiftWrap;
use App\Models\MilestoneSetting;
use App\Models\ShippingPrice;
use App\Models\ShopByAge;
use App\Models\ShopByPrice;
use App\Models\ShopByReels;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;
class HomeController extends Controller
{
    public function index(){
        // Artisan::call('migrate');
        $categories = ProductCategory::where('status', 1)->get();
        $shop_by_age = ShopByAge::where('status', 1)->orderBy('priority', 'asc')->get();
        $shop_by_prices = ShopByPrice::where('status', 1)->get();
        $shop_by_reels = ShopByReels::where('status', 1)->get();
        $call_to_actions = CallToAction::where('status', 1)->get()->keyBy('name');
        $products = Product::with('colors')->where('status', 1)->get();
        $new_arrivals = $products->where('new_arrival', 1);
        $best_seller = $products->where('best_sellers', 1)->take(10);
        // dd($shop_by_prices);
        return view('frontend.index',compact('new_arrivals','shop_by_reels','best_seller','categories','shop_by_age','call_to_actions','shop_by_prices'));
    }
    public function searchList(Request $request)
    {
        // print_r($request->all()); exit();
        $user        = Auth::user();
        $category    = ProductCategory::where('status',1)->latest()->get();
        $subcategory = ProductSubCategory::where('status',1)->latest()->get();
        
        $search_text = $request->search_text;

        $search = null;
        $product = Product::query();
        
        
        if($search_text)
        {
            $product     = Product::where('product_name', 'LIKE', "%{$search_text}%")
                           ->where('status', 1)
                           ->latest()->get();
            $product_count = Product::where('status', 1)->count();
        }
        else
        {
            $product     = Product::where('status',1)->latest()->get();
            
            $product_count = Product::where('status', 1)->count();
            
        }
        
        return view('frontend.product.search_product',compact('user','category','subcategory','product','product_count'));
    }
    
    // public function search(Request $request)
    // {
    //     $user = Auth::user();

    //     $categories = ProductCategory::where('status', 1)->latest()->get();
    //     $subcategories = ProductSubCategory::where('status', 1)->latest()->get();

    //     // Database overall Min and Max
    //     $min_price = Product::where('status', 1)->min('offer_price');
    //     $max_price = Product::where('status', 1)->max('offer_price');

    //     $shop_by_price_id = $request->shop_by_price_id ?? null;

    //     if (!empty($shop_by_price_id)) {
    //         $shopPriceObj = \App\Models\ShopByPrice::find($shop_by_price_id); 
            
    //         if ($shopPriceObj) {
    //             $req_min_price = $request->has('req_min') ? $request->req_min : $shopPriceObj->min_price;
    //             $req_max_price = $request->has('req_max') ? $request->req_max : $shopPriceObj->max_price;
    //         } else {
    //             $req_min_price = $request->req_min ?? $min_price;
    //             $req_max_price = $request->req_max ?? $max_price;
    //         }
    //     } else {
    //         $req_min_price = $request->req_min ?? $min_price;
    //         $req_max_price = $request->req_max ?? $max_price;
    //     }

    //     $selected_categories = $request->selected_categories ?? [];
    //     $selected_subcategories = $request->selected_subcategories ?? [];
    //     $selected_submenus = $request->selected_submenus ?? [];
    //     $sort_by = $request->sort_by ?? null;
    //     $search = trim($request->search);

    //     $productQuery = Product::query()->where('status', 1);

    //     if (!empty($search)) {
    //         $productQuery->where(function ($q) use ($search) {
    //             $q->where('product_name', 'LIKE', "%{$search}%")
    //             ->orWhere('keyword', 'LIKE', "%{$search}%");
    //         });
    //     }

    //     if (!empty($selected_categories)) {
    //         $productQuery->whereIn('category_id', $selected_categories);
    //     }
    //     if (!empty($selected_subcategories)) {
    //         $productQuery->whereIn('subcategory', $selected_subcategories);
    //     }
    //     if (!empty($request->shop_by_age_id)) {
    //         $productQuery->whereHas('shopByAges', function ($q) use ($request) {
    //             $q->whereIn('shop_by_age_id', (array) $request->shop_by_age_id);
    //         });
    //     }

    //     if (!empty($selected_submenus)) {
    //         $productQuery->whereIn('sub_menu_id', $selected_submenus);
    //     }

    //     $productQuery->whereBetween('offer_price', [(float)$req_min_price, (float)$req_max_price]);

    //     if ($sort_by == "low-to-high") {
    //         $productQuery->orderBy('offer_price', 'asc');
    //     } elseif ($sort_by == "high-to-low") {
    //         $productQuery->orderBy('offer_price', 'desc');
    //     } elseif ($sort_by == "new-arrival") {
    //         $productQuery->where('new_arrival', 1);
    //     } elseif ($sort_by == "best-selling") {
    //         $productQuery->where('best_sellers', 1);
    //     } elseif ($sort_by == "newest-first") {
    //         $productQuery->latest();
    //     } elseif ($sort_by == "a-to-z") {
    //         $productQuery->orderBy('product_name', 'asc');
    //     } else {
    //         $productQuery->latest();
    //     }

    //     $products = $productQuery->paginate(12)->withQueryString();
    //     $product_count = $products->total();

    //     if ($request->ajax()) {
    //         return response()->json([
    //             'html' => view('frontend.product.partials.product_list', compact('products'))->render(),
    //             'total_text' => $products->total() > 0 
    //                 ? "Showing {$products->firstItem()}–{$products->lastItem()} of {$products->total()} Results" 
    //                 : "Showing 0 Results"
    //         ]);
    //     }

    //     return view('frontend.product.category', compact(
    //         'user',
    //         'categories',
    //         'subcategories',
    //         'products',
    //         'selected_categories',
    //         'product_count',
    //         'min_price',
    //         'max_price',
    //         'req_min_price',
    //         'req_max_price',
    //         'search',
    //         'sort_by',
    //         'shop_by_price_id'
    //     ));
    // }
    public function search(Request $request)
    {
        $user = Auth::user();

        $categories = ProductCategory::where('status', 1)->latest()->get();
        $subcategories = ProductSubCategory::where('status', 1)->latest()->get();

        $min_price = 0;
        $max_price = 9999;

        $shop_by_price_id = $request->shop_by_price_id ?? null;

        if (!empty($shop_by_price_id) && !$request->has('req_min') && !$request->has('req_max')) {
            $shopPriceObj = \App\Models\ShopByPrice::find($shop_by_price_id);
            
            if ($shopPriceObj) {
                // Min price starts from 0 so ₹95 items are included!
                $req_min_price = $shopPriceObj->min_price ?? 0;
                $req_max_price = $shopPriceObj->max_price ?? 199;
            } else {
                $req_min_price = $min_price;
                $req_max_price = $max_price;
            }
        } else {
            $req_min_price = $request->req_min ?? $min_price;
            $req_max_price = $request->req_max ?? $max_price;
        }

        $selected_categories = $request->selected_categories ?? [];
        $selected_subcategories = $request->selected_subcategories ?? [];
        $selected_submenus = $request->selected_submenus ?? [];
        $sort_by = $request->sort_by ?? null;
        $search = trim($request->search);

        $productQuery = Product::query()->where('status', 1);

        if (!empty($search)) {
            $productQuery->where(function ($q) use ($search) {
                $q->where('product_name', 'LIKE', "%{$search}%")
                ->orWhere('keyword', 'LIKE', "%{$search}%");
            });
        }

        if (!empty($selected_categories)) {
            $productQuery->whereIn('category_id', $selected_categories);
        }
        if (!empty($selected_subcategories)) {
            $productQuery->whereIn('subcategory', $selected_subcategories);
        }
        if (!empty($request->shop_by_age_id)) {
            $productQuery->whereHas('shopByAges', function ($q) use ($request) {
                $q->whereIn('shop_by_age_id', (array) $request->shop_by_age_id);
            });
        }

        if (!empty($selected_submenus)) {
            $productQuery->whereIn('sub_menu_id', $selected_submenus);
        }

        $productQuery->whereRaw("CAST(offer_price AS UNSIGNED) BETWEEN ? AND ?", [(int)$req_min_price, (int)$req_max_price]);

        // Sort Logics
        if ($sort_by == "low-to-high") {
            $productQuery->orderByRaw("CAST(offer_price AS UNSIGNED) ASC");
        } elseif ($sort_by == "high-to-low") {
            $productQuery->orderByRaw("CAST(offer_price AS UNSIGNED) DESC");
        } elseif ($sort_by == "new-arrival") {
            $productQuery->where('new_arrival', 1);
        } elseif ($sort_by == "best-selling") {
            $productQuery->where('best_sellers', 1);
        } elseif ($sort_by == "newest-first") {
            $productQuery->latest();
        } elseif ($sort_by == "a-to-z") {
            $productQuery->orderBy('product_name', 'asc');
        } else {
            $productQuery->latest();
        }

        $products = $productQuery->paginate(12)->withQueryString();
        $product_count = $products->total();

        if ($request->ajax()) {
            return response()->json([
                'html' => view('frontend.product.partials.product_list', compact('products'))->render(),
                'total_text' => $products->total() > 0 
                    ? "Showing {$products->firstItem()}–{$products->lastItem()} of {$products->total()} Results" 
                    : "Showing 0 Results"
            ]);
        }

        return view('frontend.product.category', compact(
            'user',
            'categories',
            'subcategories',
            'products',
            'selected_categories',
            'product_count',
            'min_price',
            'max_price',
            'req_min_price',
            'req_max_price',
            'search',
            'sort_by',
            'shop_by_price_id'
        ));
    }


    public function subCategoryList($id,Request $request)
    {
        $user        = Auth::user();
        $category    = ProductCategory::latest()->get();
        $subcategory = ProductSubCategory::latest()->get();
        
        $minOfferPrice = Product::where('category_id', $id)
                        ->where('status', 1)
                        ->min('offer_price');
                    
        $maxOfferPrice = Product::where('category_id', $id)
            ->where('status', 1)
            ->max('offer_price');
            
            

        $selected_categories = array();
        $search = null;
        $product = Product::query();
        
        
        if ($request->has('selected_categories')) {
            $selected_categories = $request->selected_categories;
            $blog_categories = ProductCategory::whereIn('id', $selected_categories)->pluck('id')->toArray();

            $product->whereIn('category_id', $blog_categories);
            $product = $product->where('status', 1)->orderBy('created_at', 'desc')->get();
        }
        else
        {
            $product     = Product::where('subcategory',$id)->where('status',1)->latest()->get();
        }
        
        
        
        return view('frontend.product.subcategory',compact('user','subcategory','category','product','selected_categories','minOfferPrice','maxOfferPrice'));
    }

    public function prodCategoryList(){
        $categories = ProductSubCategory::where('status',1)->get();
        return view('frontend.product.category-list',compact('categories'));
    }
    
    
    // public function productDetails($id)
    // {   
    //     $productDetails = Product::with('colors')->findOrFail($id);
    //     $variants = \DB::table('color_product')
    //     ->leftJoin('colors', 'color_product.color_id', '=', 'colors.id')
    //     ->where('color_product.product_id', $id)
    //     ->select(
    //         'color_product.id as pivot_id',
    //         'color_product.color_id',
    //         'color_product.variant_name',
    //         'color_product.qty',
    //         'colors.color_code', // colors table details (if exists)
    //         'colors.color_name'
    //     )
    //     ->get();
    //     // get upload objects
    //     $productImages = Upload::where('product_id', $id)->get();
    //     // push main image as object
    //     $productImages->prepend((object)[
    //         'path' => $productDetails->product_img
    //     ]);
    //     $related_products = Product::where('category_id', $productDetails->category_id)->get();   
    
    //     return view('frontend.product.details',compact('productDetails','productImages','related_products', 'variants'));
    // }
    public function productDetails($id)
    {   
        $productDetails = Product::findOrFail($id);

        $variants = \DB::table('color_product')
        ->leftJoin('colors', 'color_product.color_id', '=', 'colors.id')
        ->where('color_product.product_id', $id)
        ->select(
            'color_product.id as pivot_id',
            'color_product.color_id',
            'color_product.variant_name',
            'color_product.qty',
            'colors.color_code',
            'colors.color as color_title' // unga table padi colors.color_name-ku bathila colors.color
        )
        ->get();

        $productImages = Upload::where('product_id', $id)->get();
        $productImages->prepend((object)[
            'path' => $productDetails->product_img
        ]);
        
        $related_products = Product::where('category_id', $productDetails->category_id)->get();   

        return view('frontend.product.details', [
            'productDetails'   => $productDetails,
            'productImages'    => $productImages,
            'related_products' => $related_products,
            'colors'           => $variants 
        ]);
    }
    
    
    public function getProductDetails(Request $request)
    {
        $productId = $request->input('id');
        $product = Product::find($productId);

        return view('frontend.product.product_details', ['product' => $product])->render();
    }
    
    public function showCartTable()
    {
        $products = Product::all();
        $gift_wraps = GiftWrap::where('status',1)->get();
        $cart_lists = Cart::where('user_id', auth()->user()->id)->get();
        return view('frontend.product.cart', compact('gift_wraps','products','cart_lists'));
    }
    
    public function wishlistList()
    {
        $product = Product::all();
        $wishlists = Wishlist::where('user_id', auth()->user()->id)->get();
        return view('frontend.product.wishlist', compact('product','wishlists'));
    }
    
    public function addToWishlist(Request $request)
    {
        if(!auth()->check()) {
            return response()->json(['status' => 'login_required']);
        }

        $userId = auth()->id();
        $productId = $request->product_id;

        $exists = Wishlist::where('user_id', $userId)
                        ->where('product_id', $productId)
                        ->exists();

        if($exists) {
            return response()->json(['status' => 'exists']);
        }
        Wishlist::create([
            'user_id' => $userId,
            'product_id' => $productId
        ]);
        $wishlist_count = Wishlist::where('user_id', $userId)->count();
        return response()->json(['status' => 'added', 'wishlist_count' => $wishlist_count]);
    }
    
    public function removeWishlist(Request $request){
        $userId = auth()->id();
        $wishlist = Wishlist::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();
        if ($wishlist) {
            $wishlist->delete();
            $wishlist_count = Wishlist::where('user_id', $userId)->count();
            return response()->json(['status' => 'removed','wishlist_count' => $wishlist_count]);
        }

        return response()->json(['status' => 'not_found']);
    }
        
    public function addToCartBuy($id)
    {
        $product = Product::find($id);
        if (!$product) {
            abort(404);
        }
    
        $cart = session()->get('cart');
    
        if (!$cart) {
            $cart = [
                $id => [
                    "id" => $product->id,
                    "gst" => $product->gst,
                    "product_name" => $product->product_name,
                    "quantity"     => 1,
                    "offer_price"  => $product->offer_price,
                    "product_img"  => $product->product_img
                ]
            ];
            session()->put('cart', $cart);
        } else {
            if (isset($cart[$id])) {
                $cart[$id]['quantity']++;
            } else {
                $cart[$id] = [
                    "id" => $product->id,
                    "gst" => $product->gst,
                    "product_name" => $product->product_name,
                    "quantity" => 1,
                    "offer_price" => $product->offer_price,
                    "product_img" => $product->product_img
                ];
            }
            session()->put('cart', $cart);
        }
    
        if (request()->wantsJson()) {
            return response()->json(['message' => 'Product added to cart successfully!']);
        }
    
        return redirect()->route('show.cart.table')->with('success', 'Product added to cart successfully!');
    }
       
    public function addToCart(Request $request, $id)
    {
        $product = Product::with('colors')->findOrFail($id);

        $colorProductId = $request->input('color_id');
        
        $requestedQty = intval($request->input('quantity', 1));
        if ($requestedQty < 1) {
            $requestedQty = 1; // Safety fallback check
        }

        if (!$colorProductId && $product->colors->isNotEmpty()) {
            $colorProductId = $product->colors->first()->pivot->id;
        }

        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->where('color_id', $colorProductId)
            ->first();

        if ($colorProductId) {
            $colorStock = ColorProduct::find($colorProductId);

            if (!$colorStock || $colorStock->qty <= 0) {
                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => 'Selected color is out of stock'
                    ], 400);
                }
                return back()->with('error', 'Selected color is out of stock');
            }

            $currentInCart = $cartItem ? $cartItem->quantity : 0;
            $totalTargetQty = $currentInCart + $requestedQty; // Dynamic target qty logic

            if ($totalTargetQty > $colorStock->qty) {
                $availableToAdd = $colorStock->qty - $currentInCart;
                $msg = $availableToAdd > 0 
                    ? "You can only add {$availableToAdd} more of this item (Stock Limit: {$colorStock->qty})."
                    : "Not enough stock. You already have maximum stock in your cart.";

                if ($request->wantsJson()) {
                    return response()->json([
                        'status' => 'error',
                        'message' => $msg
                    ], 400);
                }
                return back()->with('error', $msg);
            }
        }

        if ($cartItem) {
            $cartItem->increment('quantity', $requestedQty);
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $id,
                'color_id'   => $colorProductId, 
                'quantity'   => $requestedQty, // Set custom quantity
                'price'      => $product->offer_price,
            ]);
        }

        if ($request->wantsJson()) {
            return response()->json([
                'status' => 'success',
                'message' => 'Product added to cart successfully!'
            ]);
        }

        return redirect()->back()->with('success', 'Product added to cart successfully!');
    }

    public function removeCart(Request $request)
    {
        $cartItem = Cart::find($request->cart_id);

        if($cartItem) {
            $cartItem->delete();
            return response()->json(['status' => 'success']);
        }

        return response()->json(['status' => 'error']);
    }

    public function clearCart()
    {
        Cart::where('user_id', Auth::id())->delete();

        if (request()->wantsJson()) {
            return response()->json(['message' => 'Cart cleared successfully']);
        }

        return redirect()->back()->with('success', 'Cart cleared successfully');
    }
   
   public function increaseQty(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $cart = Cart::where('id', $id)->lockForUpdate()->first();

            if (!$cart) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Cart item not found.'
                ], 404);
            }

            $availableStock = 0;

            if (!empty($cart->color_id)) {
                $colorProduct = ColorProduct::find($cart->color_id);
                if (!$colorProduct) {
                    return response()->json([
                        'status' => 'error', 
                        'message' => 'Selected color stock variant not found.'
                    ], 404);
                }
                $availableStock = $colorProduct->qty;
            } else {
                $product = $cart->product; 
                if (!$product) {
                    return response()->json([
                        'status' => 'error', 
                        'message' => 'Main product information not found.'
                    ], 404);
                }
                $availableStock = $product->quantity; 
            }

            if ($availableStock <= 0) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Item is currently out of stock.'
                ], 400);
            }

            if (($cart->quantity + 1) > $availableStock) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Not enough stock available. Maximum limit reached (' . $availableStock . ').'
                ], 400);
            }

            $cart->quantity += 1;
            $cart->save();

            return response()->json([
                'status' => 'success',
                'new_qty' => $cart->quantity,
                'available_stock' => $availableStock,
                'message' => 'Quantity increased successfully.'
            ]);
        });
    }

    public function decreaseQty(Request $request, $id)
    {
        return DB::transaction(function () use ($id) {
            $cart = Cart::where('id', $id)->lockForUpdate()->first();

            if (!$cart) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Cart item not found.'
                ], 404);
            }

            if ($cart->quantity <= 1) {
                return response()->json([
                    'status' => 'error', 
                    'message' => 'Minimum quantity allowed is 1.'
                ], 400);
            }

            $availableStock = 0;
            if (!empty($cart->color_id)) {
                $colorProduct = ColorProduct::find($cart->color_id);
                $availableStock = $colorProduct ? $colorProduct->qty : 0;
            } else {
                $product = $cart->product;
                $availableStock = $product ? $product->quantity : 0; 
            }

            $cart->quantity -= 1;
            $cart->save();

            return response()->json([
                'status' => 'success',
                'new_qty' => $cart->quantity,
                'available_stock' => $availableStock,
                'message' => 'Quantity decreased successfully.'
            ]);
        });
    }
    public function increaseCartQty($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found'
            ]);
        }

        // IMPORTANT: color-wise stock
        $colorProduct = ColorProduct::find($cart->color_id);

        if (!$colorProduct) {
            return response()->json([
                'status' => 'error',
                'message' => 'Color stock not found'
            ]);
        }

        if ($colorProduct->qty <= 0) {
            return response()->json([
                'status' => 'error',
                'message' => 'Out of stock for this color'
            ]);
        }

        if ($cart->quantity + 1 > $colorProduct->qty) {
            return response()->json([
                'status' => 'error',
                'message' => 'Not enough stock for selected color'
            ]);
        }

        $cart->quantity += 1;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'new_qty' => $cart->quantity,
            'available_stock' => $colorProduct->qty
        ]);
    }

    public function decreaseCartQty($id)
    {
        $cart = Cart::find($id);

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart item not found'
            ]);
        }

        if ($cart->quantity <= 1) {
            return response()->json([
                'status' => 'error',
                'message' => 'Minimum quantity is 1'
            ]);
        }

        $cart->quantity -= 1;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'new_qty' => $cart->quantity
        ]);
    }

    public function getCart()
    {
        $cartItems = Cart::with([
            'product:id,product_name,offer_price,product_img',
            'colorData.color:id,color,color_code'
        ])
        ->where('user_id', auth()->id())
        ->get()
        ->map(function ($item) {
            return [
                'id' => $item->id,
                'quantity' => $item->quantity,
                'product' => $item->product,
                'colorData' => optional($item->colorData)->color,
            ];
        });
        return response()->json($cartItems);
    }
    public function applyCoupon(Request $request)
    {
        $couponCode = $request->input('coupon');
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon) {
            session(['coupon' => $coupon]);
             return response()->json([
                'status' => 'success',
                'message' => 'Coupon applied successfully!',
            ]);
        } else {
             return response()->json([
                'status' => 'error',
                'message' => 'Coupon applied Failed!',
            ]);
        }
    }  
    
    
    public function removeCoupon(Request $request)
    {
        $request->session()->forget('coupon');
        return response()->json([
                'status' => 'success',
                'message' => 'Coupon removed successfully!',
            ]);
    }
    
    public function proceed_to_checkout(Request $request)
    {
        $cartItems = Cart::with('product','colorData')->where('user_id', auth()->id())->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('show.cart.table');
        }
        $addresses = Address::with('cityDetail','stateDetail','countryDetail','shippingPrice')->where('user_id', auth()->id())->get();
        $primary_address = $addresses->firstWhere('is_default', 1);
        $countries = Country::where('id',101)->get();
        $milestones = MilestoneSetting::where('status', 1)->get();
        return view('frontend.product.checkout',compact('milestones','cartItems','countries','addresses','primary_address'));
    }

    public function send(Request $request)
    {
        if ($request->filled('website')) {
            abort(403, 'Bot detected');
        }
    
        // ✅ Validation
        $validated = $request->validate([
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|max:255',
            'phone'   => 'required|digits_between:7,15',
            'subject' => 'required|string|max:255',
            'message' => [
                'required',
                'min:5',
                'max:1000',
                'not_regex:/<[^>]*>/'
            ],
        ]);
    
        $details = [
            'name'         => $validated['name'],
            'email'        => $validated['email'],
            'phone'        => $validated['phone'],
            'mail_subject' => $validated['subject'],
            'message'      => $validated['message'],
        ];
    
        Mail::to('info@webbitech.com')->send(new ContactFormMail($details));
    
        return back()->with('success', 'Your message has been sent successfully!');
    }
 

    public function wrapUpdate(Request $request)
    {
        $userId = auth()->id();
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found'
            ]);
        }
        $giftWrapId = $request->gift_wrap_id;
        $cart->gift_wrap_id = $giftWrapId;
        $cart->save();

        $carts = Cart::where('user_id', $userId)->with('product')->get();

        $subtotal = 0;
        foreach ($carts as $item) {
            $subtotal += $item->product->offer_price * $item->quantity;
        }
        $giftWrap = GiftWrap::find($giftWrapId);
        $giftWrapPrice = $giftWrap ? $giftWrap->price : 0;

        $newTotal = $subtotal + $giftWrapPrice;

        return response()->json([
            'status' => 'success',
            'message' => 'Gift wrap updated successfully',
            'gift_wrap_id' => $giftWrapId,
            'subtotal' => $subtotal,
            'gift_wrap_price' => $giftWrapPrice,
            'new_total' => $newTotal
        ]);
    }
    public function wrapMessageUpdate(Request $request)
    {
        $userId = auth()->id();

        $request->validate([
            'gift_message' => 'required|string|max:255',
        ]);
        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found',
            ]);
        }

        $cart->gift_message = $request->gift_message;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Gift message saved successfully.',
        ]);
    }
    public function removeMessageUpdate(Request $request)
    {
        $userId = auth()->id();

        $cart = Cart::where('user_id', $userId)->first();

        if (!$cart) {
            return response()->json([
                'status' => 'error',
                'message' => 'Cart not found',
            ]);
        }

        $cart->gift_wrap_id = null;
        $cart->gift_message = null;
        $cart->save();

        return response()->json([
            'status' => 'success',
            'message' => 'Gift message saved successfully.',
        ]);
    }

    public function buyNow(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity'   => 'nullable|integer|min:1',
            'color'      => 'nullable|exists:color_product,id',
        ]);

        $product = Product::findOrFail($request->product_id);
        // ✅ If product has colors, color is mandatory
        if ($product->is_color == 1 && !$request->filled('color')) {
            return back()->with('error', 'Please select a color');
        }

        // ✅ Validate color belongs to this product
        if ($request->filled('color')) {
            $validColor = $product->colors()
                ->where('color_product.id', $request->color)
                ->exists();

            if (!$validColor) {
                return back()->with('error', 'Invalid color selected');
            }
        }

        $quantity = $request->input('quantity', 1);
        $colorId  = $request->input('color'); // NULL if not selected

        // ✅ Cart item must be unique per product + color
        $cartItem = Cart::where('user_id', Auth::id())
            ->where('product_id', $product->id)
            ->where('color_id', $colorId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->color_id = $colorId;
            $cartItem->save();
        } else {
            Cart::create([
                'user_id'    => Auth::id(),
                'product_id' => $product->id,
                'color_id'   => $colorId,
                'quantity'   => $quantity,
                'price'      => $product->offer_price,
            ]);
        }

        return redirect()->route('product.proceed_to_checkout');
    }

}