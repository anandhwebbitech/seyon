<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Redirect;
use App\Models\User;
use App\Models\Address;
use App\Models\Country;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Review;
use App\Services\SmsService;


class MemberController extends Controller
{
    public function dashboard(Request $request)
    {
        $user = Auth::user();
        return view('frontend.user.dashboard',compact('user'));
    }
    
    
    
    public function editProfile(Request $request)
    {
        return view('frontend.user.edit_profile');
    }
    
    
    public function updateProfile(Request $request)
    {
        $user_id = $request->user_id;
        $user = User::where('id',$user_id)->first();
        $user->name = $request->name;
        $user->save();
        
        return redirect()->route('user.dashboard')->with('success', 'Profile has been updated successfully!');
    }
    
    
    public function changePassword (Request $request)
    {
        return view('frontend.user.change_password');
    }
    
    public function updatePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->back()->with('success', 'Password changed successfully.');
    }
    
    public function userAddress (Request $request)
    {
        $countries = Country::where('id',101)->get();
        $userAddress = Address::where('user_id',auth()->user()->id)->get();
        return view('frontend.user.address',compact('countries','userAddress'));
    }
    
    
    public function deleteAddress($id) 
    {
        $address = Address::find($id);
        if($address)
        {
            $address->delete();
        }

        return redirect()->back()->with('error', 'Address has been deleted successfully.');
    }
    
    
    public function orderHistory(Request $request)
    {
        $orders      = Order::where('user_id',auth()->user()->id)->get();
        return view('frontend.user.order_history',compact('orders'));
    }


    public function fetchProducts(Request $request)
    {
        // Fetch products based on the order ID passed in the request
        $orderId = $request->input('order_id');
        $orderDetails = OrderDetail::where('order_id', $orderId)->get();

        // Assuming products are associated with order details
        $products = $orderDetails->map(function ($orderDetail) {
            return $orderDetail->product;
        });

        // Return the products as JSON response
        return response()->json($products);
    }
    
    
    public function userOrderDetails($id)
    {
        $orders            = Order::where('id',$id)->first();
        if(!$orders->shipping_address){
            return redirect()->back();
        }
        $orders_details    = OrderDetail::where('order_id',$id)->get();
        $orderDetailsCount = OrderDetail::where('order_id', $id)->count();
        $shippingAddress   = Address::where('id',$orders->shipping_address)->where('user_id',auth()->user()->id)->first();
        $totalSubtotal = $orders_details->sum(function($item) {
            return $item->offer_price * $item->quantity;
        });

        return view('frontend.user.order_details',compact('orders_details','orders','orderDetailsCount','shippingAddress','totalSubtotal'));
        
    }
    
    public function addReview(Request $request)
    {
        $rate       = $request->rate_value;
        $comment    = $request->comment;
        $order_id   = $request->order_id;
        $user_id    = auth()->user()->id;
        
        $product    = OrderDetail::where('id',$order_id)->first();
        
        $review              = new Review();
        $review->user_id     = $user_id;
        $review->product_id  = $product->product_id;
        $review->order_id    = $product->order_id;
        $review->star_count	 = $rate;
        $review->command     = $comment;
        $review->save();
        if($review)
        {
            return redirect()->back()->with('success', 'Thankyou for your review.');
        }
        
    }
    
    
    
    public function updateProfileImg(Request $request)
    {
        $user_id = auth()->user()->id;
        $user = User::where('id', $user_id)->first();
        $image = $request->file('image');
        if($image)
        {
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('profile_images'), $imageName);
            $user->image_name = $imageName;
            $user->image_path = 'profile_images/' . $imageName; 
            
            $user->save();
        
        return redirect()->back()->with('success', 'profile image has been updated successfully!');
        }
        
        return redirect()->back()->with('danger', 'please upload your profile image!');
    } 

    // CheckoutController.php

    public function applyExitOffer(Request $request)
    {
        if (!session()->has('exit_offer')) {
            session()->put('exit_offer', [
                'amount' => 30
            ]);
        }

        return response()->json([
            'status' => 'success'
        ]);
    }
}