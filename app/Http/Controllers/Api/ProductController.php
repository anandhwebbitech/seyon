<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use App\Services\SmsService;
use Carbon\Carbon;
use Validator;
use Mail;
use App\Models\Review;
use Illuminate\Support\Facades\DB;
use App\Http\Resources\UserAddressInformation;
use App\Models\ProductCategory;
use App\Models\Product;
use App\Models\Upload;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Country;
use App\Models\State;
use App\Models\City;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use App\Models\BannerImages;
use Dompdf\Dompdf;
use PDF;
use App\Http\Resources\OrderResource;


class ProductController extends Controller
{
    
    public function getAllCatagories()
    {
        $categories = ProductCategory::all();
        $baseImageUrl = url('public/product_images/category_images/');
    
        foreach ($categories as $category) {
            if ($category->category_image) {
                $category->category_image = $baseImageUrl . '/' . $category->category_image;
            }
        }
    
        return response()->json([
            'categories' => $categories
        ]);
    }
        
        
    public function featuredProduct()
    {
        $featured_products = Product::where('featured', 1)->orderBy('created_at', 'desc')->get();
        $baseImageUrl = url('public/product_images/');
        
        foreach($featured_products as $product)
        {
            if($product->product_img)
            {
                $product->product_img = $baseImageUrl . '/' . $product->product_img;
            }
        }
        
        return response()->json([
            'featured_products' => $featured_products
        ]);
    
    }
        
        
    public function bestSellerProduct()
    {
        $featured_products = Product::where('best_sellers', 1)->orderBy('created_at', 'desc')->get();
        $baseImageUrl = url('public/product_images/');
        
        foreach($featured_products as $product)
        {
            if($product->product_img)
            {
                $product->product_img = $baseImageUrl . '/' . $product->product_img;
            }
        }
        
        return response()->json([
            'featured_products' => $featured_products
        ]);
    
    }
        
    
    public function addToCart(Request $request)
    {
        $productId = $request->product_id;
        
        $product = Product::findOrFail($productId);
        
        if($product->quantity != 0 && $product->quantity != '')
        {
            $cart = Session::get('cart', []);
    
            if (isset($cart[$productId])) {
                return response()->json([
                    'message' => 'Product is already in cart',
                ]);
            } 
            else {
                $cart[$productId] = [
                    'product_id' => $productId,
                    'name' => $product->product_name,
                    'price' => $product->offer_price,
                    'quantity' => 1,
                ];
            }
        
            Session::put('cart', $cart);
        
            return response()->json([
                'message' => 'Product added to cart successfully',
                'cart' => $cart
            ], 200);
        }
        else
        {
            return response()->json([
                'message' => 'Out of Stock',
            ]);
        }
    
        
    }
    
    
    public function getCart()
    {
        $cart = Session::get('cart', []);
        $cartDetails = [];
    
        foreach ($cart as $productId => $item) {
            $product = Product::find($productId);
    
            if ($product) {
                $reviews = Review::where('product_id', $productId)
                                ->selectRaw('COUNT(*) as review_count, AVG(star_count) as avg_rating')
                                ->first();
    
                $cartDetails[] = [
                    'product_id' => $productId,
                    'name' => $product->product_name,
                    'image' => url('public/product_images').'/'.$product->product_img,
                    'gst' =>$product->gst,
                    'price' => $product->offer_price,
                    'quantity' => $item['quantity'],
                    'review_count' => $reviews ? $reviews->review_count : 0,
                    'rating' => $reviews ? round($reviews->avg_rating, 1) : 0,
                ];
            } else {
                
            }
        }
    
        return response()->json([
            'cart' => $cartDetails
        ]);
    }
    
    
    public function removeFromCart(Request $request)
    {
        $productId = $request->product_id;
        
        $cart = Session::get('cart', []);
    
        if (isset($cart[$productId])) {
            unset($cart[$productId]);
    
            Session::put('cart', $cart);
    
            return response()->json([
                'message' => 'Product removed from cart successfully',
                'cart' => $cart
            ]);
        } else {
            return response()->json([
                'message' => 'Product not found in cart',
            ]);
        }
    }
    
    
    public function getCartCount()
    {
        $cart = Session::get('cart', []);
        
        $cartCount = count($cart);
        
        return response()->json([
            'cart_count' => $cartCount
        ]);
    }
    
    
    public function addToWishlist(Request $request)
    {
        $productId = $request->product_id;
        
        $product = Product::findOrFail($productId);
     
            $wishlist = Session::get('wishlist', []);
    
            if (isset($wishlist[$productId])) {
                return response()->json([
                    'message' => 'Product is already in wishlist',
                ]);
            } 
            else {
                $wishlist[$productId] = [
                    'product_id' => $productId,
                    'name' => $product->product_name,
                    'price' => $product->offer_price,
                ];
            }
        
            Session::put('wishlist', $wishlist);
        
            return response()->json([
                'message' => 'Product added to wishlist successfully',
                'wishlist' => $wishlist
            ], 200);
        
        
    }
        
    
    public function getWishlist()
    {
        $wishlist = Session::get('wishlist', []);
        $wishlistDetails = [];
    
        foreach ($wishlist as $productId => $item) {
            $product = Product::find($productId);
    
            if ($product) {
                $reviews = Review::where('product_id', $productId)
                                ->selectRaw('COUNT(*) as review_count, AVG(star_count) as avg_rating')
                                ->first();
    
                $wishlistDetails[] = [
                    'product_id' => $productId,
                    'name' => $product->product_name,
                    'image' => url('public/product_images').'/'.$product->product_img,
                    'price' => $product->offer_price,
                    'review_count' => $reviews ? $reviews->review_count : 0,
                    'rating' => $reviews ? round($reviews->avg_rating, 1) : 0,
                ];
            } else {
                
            }
        }
    
        return response()->json([
            'wishlist' => $wishlistDetails
        ]);
    }
    
    
    public function removeFromWishlist(Request $request)
    {
        $productId = $request->product_id;
        
        $wishlist = Session::get('wishlist', []);
    
        if (isset($wishlist[$productId])) {
            unset($wishlist[$productId]);
    
            Session::put('wishlist', $wishlist);
    
            return response()->json([
                'message' => 'Product removed from wishlist successfully',
                'wishlist' => $wishlist
            ]);
        } else {
            return response()->json([
                'message' => 'Product not found in wishlist',
            ]);
        }
    }
    
    
    public function getWishlistCount()
    {
        $wishlist = Session::get('wishlist', []);
        
        $cartCount = count($wishlist);
        
        return response()->json([
            'wishlist_count' => $cartCount
        ]);
    }
        
        
    public function productdetails(Request $request)
    {
        $productId = $request->product_id;
        $product = Product::find($productId);
    
            if ($product) {
                $reviews = Review::where('product_id', $productId)
                                ->selectRaw('COUNT(*) as review_count, AVG(star_count) as avg_rating')
                                ->first();
                
                $productImages = Upload::where('product_id', $productId)->select('id','name')->get();
                
                foreach($productImages as $img)
                {
                    if($img->name)
                    {
                        $img->name = url('public/product_images') . '/' . $img->name;
                    }
                }
                
                $allReviews = Review::where('product_id', $productId)->select('id','product_id','star_count','command','created_at')->get();
                
    
                $productDetails = [
                    'product_id' => $productId,
                    'category_id' => $product->category_id,
                    'name' => $product->product_name,
                    'thumbnail_image' => url('public/product_images').'/'.$product->product_img,
                    'price' => $product->offer_price,
                    'quantity' => $product->quantity,
                    'discount' => $product->discount,
                    'description' => $product->description,
                    'gst' => $product->gst,
                    'review_count' => $reviews ? $reviews->review_count : 0,
                    'rating' => $reviews ? round($reviews->avg_rating, 1) : 0,
                ];
                
                
                
                $getRelatedProducts = Product::where('category_id', $product->category_id)->get();
                
                foreach($getRelatedProducts as $products)
                {
                    if ($products) {
                        $reviews = Review::where('product_id', $products->id)
                                        ->selectRaw('COUNT(*) as review_count, AVG(star_count) as avg_rating')
                                        ->first();
            
                        $relatedProducts[] = [
                            'product_id' => $products->id,
                            'name' => $products->product_name,
                            'image' => url('public/product_images').'/'.$products->product_img,
                            'price' => $products->offer_price,
                            'review_count' => $reviews ? $reviews->review_count : 0,
                            'rating' => $reviews ? round($reviews->avg_rating, 1) : 0,
                        ];
                    } else {
                        
                    }
                }
                
                
                
                return response()->json([
                    'product_details' => $productDetails,
                    'product_images' => $productImages,
                    'reviews' => $allReviews,
                    'related_products' => $relatedProducts
                ]);
            }
    }
    
    
    public function applyCoupon(Request $request)
    {
        // print_r("dsd"); exit();
        $couponCode = $request->coupon_code;
        $coupon = Coupon::where('code', $couponCode)->first();

        if ($coupon) {
            // session(['coupon' => $coupon]);
            return response()->json([
                'message' => true,
                'percentage' => $coupon->percentage,
                'id' => $coupon->id
            ]);
        } else {
            return response()->json([
                'message' => false,
            ]);
        }
    }
    

    public function removeCoupon(Request $request)
    {
        $couponCode = $request->coupon_id;
        $coupon = Coupon::where('id', $request->coupon_id)->first();

        if ($coupon) {
            return response()->json([
                'message' => true
            ]);
        } else {
            return response()->json([
                'message' => false
            ]);
        }
    }
    
    
    public function addNewAddress(Request $request)
    {
        $address                     = new Address();
        $address->user_id            = $request->user_id;
        $address->address_type       = $request->address_type;
        $address->shipping_name      = $request->shipping_name;
        $address->shipping_email     = $request->shipping_email;
        $address->shipping_phone     = $request->shipping_phone;
        $address->shipping_address   = $request->shipping_address;
        $address->country            = $request->country;
        $address->state              = $request->state;
        $address->city               = $request->city;
        $address->pincode            = $request->pincode;
        $address->landmark           = $request->landmark;
        $address->save();
        
        if($address)
        {
            return response()->json([
                'message' => 'Address has been added successfully!'
            ]);
        }
        else
        {
            return response()->json([
                'message' => 'Failed'
            ]);
        }
        
    }
    

    public function updateAddress(Request $request)
    {
        $address = Address::find($request->address_id);

        if ($address) {
            $address->user_id = $request->user_id;
            $address->address_type = $request->address_type;
            $address->shipping_name = $request->shipping_name;
            $address->shipping_email = $request->shipping_email;
            $address->shipping_phone = $request->shipping_phone;
            $address->shipping_address = $request->shipping_address;
            $address->country = $request->country;
            $address->state = $request->state;
            $address->city = $request->city;
            $address->pincode = $request->pincode;
            $address->landmark = $request->landmark;
            $address->save();
            
            return response()->json([
                'message' => 'Address has been updated successfully!'
            ]);
        } 
        else {
            return response()->json([
                'message' => 'Failed to update!'
            ]);
        }
  
    }
    
    
    public function setDefaultAddress(Request $request)
    {
        $address = Address::find($request->address_id);
    
        if ($address) {
            Session::put('default_address', $address);
            return response()->json([
                'message' => 'Address has been updated and set as default successfully!',
                'default_address' => $address
            ]);
        } 
        else {
            return response()->json([
                'message' => 'Failed to set as default!'
            ]);
        }
    }
    
    
    public function getDefaultAddress(Request $request)
    {
        $defaultAddress = Session::get('default_address');
    
        if ($defaultAddress) {
            return response()->json([
                'default_address' => $defaultAddress
            ]);
        } else {
            return response()->json([
                'message' => 'No default address set.'
            ], 404);
        }
    }


    
    public function deleteAddress(Request $request) 
    {
        $address = Address::find($request->address_id);
        if($address)
        {
            $address->delete();
        }

        return response()->json([
            'message' => 'Address has been deleted successfully!'
        ]);
    }
    

    public function getAllAddress(Request $request)
    {
        
        $user_id = $request->user_id;
        $bank = Address::where('user_id',$user_id)->get();
        
        
        if($bank)
        {
            return (new UserAddressInformation($bank))->additional([
                'result' => true
            ]);
        }
        else
        {
            return response()->json([
                'status'  => false,
                'message' => 'Address not found'
                ]);
        }
  
    }
    
    
    public function getCountry(Request $request)
    {
        $country = Country::all();
        return response()->json([
            'countries' => $country
        ]);
    }
    
    
    public function getStates(Request $request)
    {
        $states = State::where('country_id', $request->country_id)->get();
        return response()->json([
            'states' => $states
        ]);
    }


    public function getCities(Request $request)
    {
        $cities = City::where('state_id', $request->state_id)->get();
        return response()->json([
            'cities' => $cities
        ]);
    }
    
    
    public function paymentProcess(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        
        $invoiceNumber = str_pad(Order::count() + 1, 5, '0', STR_PAD_LEFT); // Incremental number with leading zeros
        $date = now()->format('dmY');
        $time = now()->format('His');
        $invoiceNumber = $invoiceNumber . '-' . $date . '-' . $time;
        
        
        $cartProducts = session()->get('cart', []);
        // print_r($cartProducts); exit();
        
        $payment_method   = $request->payment_method;
        $shipping_address = $request->shipping_address;
        $total_amount     = $request->total_amount;
        $shipping_cost    = $request->shipping_cost;
        $gst              = $request->gst;
        $coupon_discount  = $request->coupon_discount;
       
       
        if($payment_method == 'cod')
        {
            $order                    = new Order();
            $order->user_id           = $request->user_id;
            $order->payment_method	  = $payment_method;
            $order->total_amount      = $total_amount;
            $order->shipping_address  = $shipping_address;
            $order->gst               = $gst;
            $order->shipping_cost     = $shipping_cost;
            $order->coupon_discount   = $coupon_discount;
            $order->payment_order_id  = $invoiceNumber;
            $order->save();
            
            if ($order) 
            {
                foreach ($cartProducts as $productId => $productDetails) 
                {
                    $product                        = Product::where('id',$productDetails['product_id'])->first();
                    $product->quantity -= $productDetails['quantity'];
                    $product->save();

                    
                    $orderDetail                    = new OrderDetail();
                    $orderDetail->user_id           = $request->user_id;
                    $orderDetail->order_id          = $order->id;
                    $orderDetail->product_id        = $productDetails['product_id'];
                    $orderDetail->quantity          = $productDetails['quantity'];
                    $orderDetail->productname       = $product->product_name;
                    $orderDetail->offer_price       = $product->offer_price;
                    $orderDetail->product_gst       = $product->gst;
                    $orderDetail->product_discount  = $product->discount;
                    
                    $orderDetail->save();
                }
            }
            
            return response()->json([
                'message' => 'Order confirmed!',
                'order' => $order
            ]);
        }
        
    }
    
    
    public function invoice(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
    
        $order = Order::where('id', $request->order)->first();
    
        if (!$order) {
            return response()->json([
                'message' => 'Order not found!'
            ], 404);
        }
    
        $orderDetails = OrderDetail::where('order_id', $order->id)->get();
    
        if ($orderDetails->isEmpty()) {
            return response()->json([
                'message' => 'Order details not found!'
            ], 404);
        }
    
        $shippingAddress = Address::where('user_id', $order->user_id)
                                   ->where('id', $order->shipping_address)
                                   ->first();
    
        if (!$shippingAddress) {
            return response()->json([
                'message' => 'Shipping address not found!'
            ], 404);
        }
    
        $total_gst = 0;
        foreach ($orderDetails as $orderDetail) {
            $gst_amount_per_unit = ($orderDetail->offer_price * $orderDetail->product_gst) / 100;
            $gst_amount_total = $gst_amount_per_unit * $orderDetail->quantity;
            $total_gst += $gst_amount_total;
        }
    
        $invoiceNumber = $order->payment_order_id;
    
        $data = [
            'shipping_address' => $shippingAddress,
            'order'            => $order,
            'order_details'    => $orderDetails,
            'total_gst'        => $total_gst,
            'invoiceNumber'    => $invoiceNumber,
        ];
    
        $email = $request->email;
        $pdf = PDF::loadView('frontend.product.invoice', $data);
    
        $data["email"] = $email;
        $data["title"] = "Invoice - PDF";
    
        Mail::raw('', function ($message) use ($data, $pdf, $email) {
            $message->to($email)
                    ->subject('Invoice');
    
            $message->attachData($pdf->output(), 'invoice.pdf');
        });
    
        session()->forget('cart');
        session()->forget('coupon');
    
        return response()->json([
            'message' => 'Invoice sent successfully!',
            'data' => $data
        ]);
    }
    
    
    public function getOrderHistory(Request $request)
    {
        $orders = Order::where('user_id', $request->user_id)
                       ->with(['orderDetails.product','address'])
                       ->get();
    
        return response()->json([
            'message' => 'true',
            'orders' => OrderResource::collection($orders),
        ]);
    }
    
    public function addReview(Request $request)
    {
        $rate       = $request->rate_value;
        $comment    = $request->comment;
        $order_id   = $request->order_id;
        $user_id    = $request->user_id;
        
        $product    = OrderDetail::where('id',$order_id)->first();
        // print_r($product); exit();
        $review              = new Review();
        $review->user_id     = $user_id;
        $review->product_id  = $product->product_id;
        $review->order_id    = $product->order_id;
        $review->star_count	 = $rate;
        $review->command     = $comment;
        $review->save();
        
        
        
        return response()->json([
            'message' => 'true',
            'review'  => $review,
        ]);
        
    }
    
    
    public function getBanner(Request $request)
    {
        $banners = BannerImages::all();
    
        if ($banners->isNotEmpty()) {
            $banners = $banners->map(function ($banner) {
                return [
                    'banner_image' => url('public/banner_images/' . $banner->image),
                    'banner_link' => $banner->banner_link,
                ];
            });
    
            return response()->json([
                'message' => 'true',
                'banners' => $banners,
            ]);
        }
    
        return response()->json([
            'message' => 'false',
            'banners' => [],
        ]);
    }

    
    
    public function searchList(Request $request)
    {
        $search_text = $request->search_text;
    
        $products = Product::where('product_name', 'LIKE', "%{$search_text}%")
                            ->where('status', 1)
                            ->latest()
                            ->get();
    
        if ($products->isNotEmpty()) {
            $products = $products->map(function ($product) {
                $product->product_img = url('public/product_images/' . $product->product_img);
                return $product;
            });
    
            return response()->json([
                'message' => 'true',
                'product' => $products,
            ]);
        } else {
            return response()->json([
                'message' => 'No Products Available',
            ]);
        }
    }




    
    public function applyFilter(Request $request)
    {
        $min_price   = $request->min_price;
        $max_price   = $request->max_price;
        $sort_val    = $request->sort_val;
    
        
        if($sort_val)
        {
            if($sort_val == "newest")
            {
                if (($min_price == 0 || $min_price) && $max_price) {
                    $max_price   = intval($max_price);
                    $min_price   = intval($min_price);
                    $product     = Product::where('status', 1)->whereBetween('offer_price', [$min_price, $max_price])->latest()->get();
                }
                else
                {
                    $product     = Product::where('status',1)->latest()->get();
                }
            }
            else if($sort_val == "oldest")
            {
                if (($min_price == 0 || $min_price) && $max_price) {
                    $max_price   = intval($max_price);
                    $min_price   = intval($min_price);
                    $product     = Product::where('status', 1)->whereBetween('offer_price', [$min_price, $max_price])->oldest()->get();
                }
                else
                {
                    $product     = Product::where('status',1)->oldest()->get();
                }
            }
            else if($sort_val == "high_to_low")
            {
                if (($min_price == 0 || $min_price) && $max_price) {
                    $max_price   = intval($max_price);
                    $min_price   = intval($min_price);
                    $product     = Product::where('status', 1)->whereBetween('offer_price', [$min_price, $max_price])->orderBy('offer_price', 'asc')->get();
                }
                else
                {
                    $product     = Product::where('status',1)->orderBy('offer_price', 'asc')->get();
                }
            }
            else if($sort_val == "low_to_high")
            {
                if (($min_price == 0 || $min_price) && $max_price) {
                    $max_price   = intval($max_price);
                    $min_price   = intval($min_price);
                    $product     = Product::where('status', 1)->whereBetween('offer_price', [$min_price, $max_price])->orderBy('offer_price', 'desc')->get();
                }
                else
                {
                    $product     = Product::where('status',1)->orderBy('offer_price', 'desc')->get();
                }
            }
            

        }
        
        if ($product->isNotEmpty()) {
            $product = $product->map(function ($product) {
                $product->product_img = url('public/product_images/' . $product->product_img);
                return $product;
            });
        } 
            
        return response()->json([
            'message' => 'true',
            'product' => $product,
        ]);

    }
    
    
    
    public function updatePassword(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        

        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json([
                'message' => 'The current password is incorrect.'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();
        
         return response()->json([
                'message' => 'Password changed successfully..'
            ]);

    }




      
}