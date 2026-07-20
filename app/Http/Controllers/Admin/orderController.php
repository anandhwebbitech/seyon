<?php

namespace App\Http\Controllers\Admin;

use App\Exports\ProductWiseFullExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Upload;
use App\Models\ProductCategory;
use App\Models\ProductSubCategory;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\Order;
use App\Models\Address;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\Response;
use Dompdf\Dompdf;
use Maatwebsite\Excel\Facades\Excel;
use Mail;
use PDF;


class orderController extends Controller
{
    public function orderList(Request $request)
    {
       $query = Order::query();

        if (request('from')) {
            $query->whereDate('created_at', '>=', request('from'));
        }
        if (request('to')) {
            $query->whereDate('created_at', '<=', request('to'));
        }

        if (request('payment_method')) {
            $query->where('payment_method', request('payment_method'));
        }

        if (request('order_status')) {
            $query->where('order_status', request('order_status'));
        }

        if (request('shipping_status')) {
            $query->where('shipping_status', request('shipping_status'));
        }

        if (request('keyword')) {
            $keyword = request('keyword');
            $query->where(function ($q) use ($keyword) {
                $q->where('payment_order_id', 'LIKE', "%{$keyword}%")
                ->orWhereHas('user', function ($u) use ($keyword) {
                    $u->where('name', 'LIKE', "%{$keyword}%")
                    ->orWhere('phone', 'LIKE', "%{$keyword}%")
                    ->orWhere('email', 'LIKE', "%{$keyword}%");
                });
            });
        }

        $orders = $query->latest()->get();
        return view('admin.order.index', compact('orders'));   
    }
    
    public function adminOrderDetails($id)
    {
        $orders = Order::where('id',$id)->first();
        $orders_details = OrderDetail::where('order_id',$id)->get();
        
        $totalSubtotal = $orders_details->sum(function($item) {
            return $item->offer_price * $item->quantity;
        });
      
       return view('admin.order.orders_details',compact('orders','orders_details','totalSubtotal'));
    }
    
    public function updateStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $newStatus = $request->input('new_status');

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->order_status = $newStatus;
        $order->save();

        return response()->json(['message' => 'Order status updated successfully']);
    }
    
    
    public function updateShippingStatus(Request $request)
    {
        $orderId = $request->input('order_id');
        $newStatus = $request->input('new_status');

        $order = Order::find($orderId);
        if (!$order) {
            return response()->json(['error' => 'Order not found'], 404);
        }

        $order->shipping_status = $newStatus;
        $order->save();

        return response()->json(['message' => 'Shipping status updated successfully']);
    }
    
    public function adminDownlaodInvoice($id)
    {
        $order            = Order::where('id',$id)->first();
        $order_details    = OrderDetail::where('order_id',$order->id)->get();
        $shipping_address = Address::where('user_id',$order->user_id)->where('id',$order->shipping_address)->first();
        
        $cart = OrderDetail::where('order_id',$order->id)->get();
        
        
        $total_gst = $order->gst;
        
        $invoiceNumber = $order->payment_order_id;
    
    

        $data = [
            'shipping_address' => $shipping_address,
            'order'            => $order,
            'order_details'    => $order_details,
            'total_gst'        => $total_gst,
            'invoiceNumber'    => $invoiceNumber,
        ];
        $html = view('frontend.product.invoice', compact('data'))->render();
    
        // Load HTML content
        $dompdf = new Dompdf();
        $options = $dompdf->getOptions();
        $options->set('isHtml5ParserEnabled', true);

        // Set CSS styles
        $css = '
            /* Add your CSS styles here */
        ';
        $dompdf->loadHtml('<style>' . $css . '</style>' . $html);

        $dompdf->setPaper('A4', 'portrait');

        $dompdf->render();

        // Output the footer
       /* $footerHtml = 'Prepared By: Grand Gover Horticulture Co LLC';
        $dompdf->getCanvas()->page_text(275, 800, $footerHtml, null, 10, array(0, 0, 0));*/

        // Get PDF content
        $pdfContent = $dompdf->output();

        // Sanitize the filename
        $filename = preg_replace('/[^A-Za-z0-9_\-]/', '_', $invoiceNumber) . '.pdf';

        // Return the response with PDF content
        return response($pdfContent)
            ->header('Content-Type', 'application/pdf')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }
    public function orderRevenue(Request $r) 
    {
        $date = $r->date;

        $amount = Order::whereDate('created_at', $date)->sum('total_amount');

        return response()->json(['amount' => $amount]);
    }
    public function exportFullProductReport()
    {
        return Excel::download(new ProductWiseFullExport, 'product-wise-report.xlsx');
    }
}