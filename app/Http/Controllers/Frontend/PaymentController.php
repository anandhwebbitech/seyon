<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Coupon;
use App\Models\Address;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use PDF;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\InvoiceMail;
use App\Helper\Helper;
use App\Models\ColorProduct;

class PaymentController extends Controller
{
    public function paymentProcess(Request $request)
    {
        $request->validate([
            'shipping_address' => 'required',
            'courier_name'     => 'required',
            'payment_method'   => 'required',
        ]);
        $invoiceNumber = sprintf('%05d-%s', (Order::max('id') ?? 0) + 1, now()->format('dmY-His'));

        $cartProducts = Cart::where('user_id', auth()->id())->get();

        if ($cartProducts->isEmpty()) {
            return redirect()->route('cart.list')->with(['status' => false, 'message'=> 'Your Cart is Empty']);
        }

        $total_amount = $cartProducts->sum(fn($item) => ($item->product->offer_price ?? $item->price ?? 0) * $item->quantity);
        $discountPercent = 0;
    
        if (session()->has('coupon')) {
            $coupon = Coupon::find(session('coupon.id'));
            if ($coupon) {
                $discountPercent = $coupon->percentage;
            }
        }
        $discountAmount   = ($total_amount * $discountPercent) / 100;
        
        $gift_card = $cartProducts->first();
        $gift = 0;
        if($gift_card->gift_wrap_id){
            $gift = $gift_card->giftWrap->price;
            $total_amount = $total_amount + $gift;
        }

        $primary_address = Address::where('user_id', auth()->id())
                                ->where('id', $request->shipping_address)
                                ->first();

        $payment_method   = $request->payment_method;
        $shipping_address = $request->shipping_address;
        $shipping_cost    = $request->shipping_cost ? $primary_address->shippingPrice?->shipping_cost : $request->shipping_code;
        
        $total_amount     = $total_amount + $shipping_cost;
        $finalTotal       = $total_amount - round($discountAmount);
        
        if ($payment_method == 'cod') {

            $order = Order::create([
                'user_id'            => auth()->id(),
                'payment_order_id'   => $invoiceNumber,
                'payment_method'     => $payment_method,
                'total_amount'       => $finalTotal,
                'shipping_address'   => $shipping_address,
                'shipping_cost'      => $shipping_cost,
                'coupon_discount'    => round($discountAmount),
                'courier_preference' => $request->courier_name,
            ]);

            foreach ($cartProducts as $cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->decrement('quantity', $cartItem->quantity);
                }
                if ($cartItem->color_id) {
                    $colorProduct = ColorProduct::find($cartItem->color_id);
                    $colorProduct->decrement('qty', $cartItem->quantity);
                }

                OrderDetail::create([
                    'user_id'          => auth()->id(),
                    'order_id'         => $order->id,
                    'product_id'       => $cartItem->product_id,
                    'quantity'         => $cartItem->quantity,
                    'color_id'         => $cartItem->color_id ?? null,
                    'productname'      => $product->product_name ?? '',
                    'offer_price'      => $product->offer_price ?? 0,
                    'product_gst'      => $product->gst ?? 0,
                    'gift_wrap_id'     => $cartItem->gift_wrap_id,
                    'gift_message'     => $cartItem->gift_message,
                    'product_discount' => $product->discount ?? 0,
                ]);
            }

            $shipping = Address::where('user_id', auth()->id())
                                ->where('id', $order->shipping_address)
                                ->first();
            $total_gst = 0;
            $data = [
                'shipping_address' => $shipping,
                'order'            => $order,
                'order_details'    => OrderDetail::where('order_id',$order->id)->get(),
                'invoiceNumber'    => $invoiceNumber,
                'total_gst'        => $total_gst,
                'email'            =>  $shipping->shipping_email ? $shipping->shipping_email : auth()->user()->email,
            ];
            // try {
                Mail::to($data['email'])->queue(new InvoiceMail($data));
            // } catch (\Exception $e) {
            //     Log::error('Invoice email failed: '.$e->getMessage());
            // }
            session()->forget('coupon');
            Cart::where('user_id', auth()->id())->delete();
            
            return view('frontend.product.thankyou', compact('order'));
        }else if ($payment_method == 'online') {
            $total_amount = str_replace(',', '', $total_amount);
            $amount = $finalTotal * 100;

            $key_id = env('RAZORPAY_KEY');
            $key_secret = env('RAZORPAY_SECRET');

            $curl = curl_init();
            curl_setopt_array($curl, [
                CURLOPT_URL => "https://api.razorpay.com/v1/orders",
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    'receipt' => $invoiceNumber,
                    'amount' => $amount,
                    'currency' => 'INR',
                    'payment_capture' => 1
                ]),
                CURLOPT_HTTPHEADER => [
                    "Authorization: Basic " . base64_encode($key_id . ":" . $key_secret),
                    "Content-Type: application/json"
                ],
            ]);

            $response = curl_exec($curl);
            $err = curl_error($curl);
            curl_close($curl);

            if ($err) {
                Log::error('Razorpay order creation failed: ' . $err);
                return back()->with('error', 'Razorpay order creation failed. Please try again.');
            }

            $razorpayOrder = json_decode($response);
            if (empty($razorpayOrder->id)) {
                Log::error('Invalid Razorpay response: ' . $response);
                return back()->with('error', 'Payment initialization failed.');
            }

            $razorpayOrderId = $razorpayOrder->id;

            $order = Order::create([
                'user_id'            => auth()->id(),
                'payment_method'     => $payment_method,
                'total_amount'       => $finalTotal,
                'shipping_address'   => $shipping_address,
                'shipping_cost'      => $shipping_cost,
                'coupon_discount'    => round($discountAmount),
                'payment_order_id'   => $invoiceNumber,
                'razorpay_order_id'  => $razorpayOrderId,
                'courier_preference' => $request->courier_name,
            ]);

            foreach ($cartProducts as $cartItem) {
                $product = Product::find($cartItem->product_id);
                if ($product) {
                    $product->decrement('quantity', $cartItem->quantity);
                }
                if ($cartItem->color_id) {
                    $colorProduct = ColorProduct::find($cartItem->color_id);
                    $colorProduct->decrement('qty', $cartItem->quantity);
                }

                OrderDetail::create([
                    'user_id'          => auth()->id(),
                    'order_id'         => $order->id,
                    'product_id'       => $cartItem->product_id,
                    'quantity'         => $cartItem->quantity,
                    'color_id'         => $cartItem->color_id ?? null,
                    'productname'      => $product->product_name ?? '',
                    'offer_price'      => $product->offer_price ?? 0,
                    'product_gst'      => $product->gst ?? 0,
                    'gift_wrap_id'     => $cartItem->gift_wrap_id,
                    'gift_message'     => $cartItem->gift_message,
                    'product_discount' => $product->discount ?? 0,
                ]);
            }
            
            return view('frontend.product.razorpay_payment', [
                'razorpayOrderId' => $razorpayOrderId,
                'finalTotal'      => $finalTotal,
                'order'           => $order,
                'key_id'          => $key_id,
            ]);
        }

    }

    public function paymentSuccess(Request $request)
    {
        $payment_method = 'razorpay';
         if ($payment_method == 'razorpay') {
            $razorpayPaymentId = $request->input('razorpay_payment_id');
            $razorpayOrderId = $request->input('razorpay_order_id');
            $razorpaySignature = $request->input('razorpay_signature');
    
            $key_secret = env('RAZORPAY_SECRET');
            $generated_signature = hash_hmac('sha256', $razorpayOrderId . "|" . $razorpayPaymentId, $key_secret);
    
            if ($generated_signature === $razorpaySignature) {
                $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();
                $order->payment_status = 'Paid';
                $order->razorpay_payment_id = $razorpayPaymentId;
                $order->order_status = 1;
                $order->save();
                session()->forget('coupon');
                Cart::where('user_id', auth()->id())->delete();
    
                return view('frontend.product.thankyou', compact('order'));
            } else {
                $order = Order::where('razorpay_order_id', $razorpayOrderId)->first();

                if ($order) {
                    $order->orderDetails()->delete();

                    $order->delete();
                }
                return redirect()->back()->with('error', 'Payment verification failed.');
            }
        }
    }

    public function invoice(Request $request)
    {
        date_default_timezone_set('Asia/Kolkata');
        $order            = json_decode($request->order);
        $order_details    = OrderDetail::where('order_id',$order->id)->get();
        $shipping_address = Address::where('user_id',$order->user_id)->where('id',$order->shipping_address)->first();
        
        $cart = $request->session()->get('cart', []);
        $total_gst = 0;
        foreach ($cart as $product) {
            $gst_amount_per_unit = ($product['offer_price'] * $product['gst']) / 100;
            $gst_amount_total = $gst_amount_per_unit * $product['quantity'];
            $total_gst += $gst_amount_total;
        }
        
        
        $invoiceNumber = $order->payment_order_id;
    
    

        $data = [
            'shipping_address' => $shipping_address,
            'order'            => $order,
            'order_details'    => $order_details,
            'total_gst'        => $total_gst,
            'invoiceNumber'    => $invoiceNumber,
        ];
        

        $pdf = PDF::loadView('frontend.product.invoice', $data); 
        
        $data["email"] = auth()->user()->email;
        $data["title"] = "Invoice - PDF";
        
        Mail::raw('', function($message) use ($data, $pdf) {
            $message->to(auth()->user()->email)
                ->subject('Invoice'); 
        
            $message->attachData($pdf->output(), 'invoice.pdf');
        });
    
        /*$dompdf = new Dompdf();
        $html = view('frontend.product.invoice', $data)->render();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $pdfContent = $dompdf->output();
        return response($pdfContent)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'inline; filename="users.pdf"');*/
                
                
        // session()->forget('cart');
        session()->forget('coupon');
        return redirect()->route('user.dashboard');
    }

    public function sendOrderSms(Request $request){
        $order = Order::find($request->order_id);

        if(!$order) {
            return response()->json([
                'status' => false,
                'message' => 'Order not found!'
            ]);
        }
        $user = auth()->user();
        if($user->phone){
            $phone   = $user->phone;
            $message = 'Thank you for purchasing with us! Your order number is '.$order->payment_order_id.'. We appreciate your trust. Visit seyonkids.in for more amazing kids products.';
            $template_id = '1707176243088966812';
            $response = Helper::sendSms($message, $template_id, $phone);
        }else{
            return response()->json(['status' => true]);
        }
    }
}