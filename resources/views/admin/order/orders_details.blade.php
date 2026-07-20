@extends('admin.index')
@section('admin')
<link href="vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<style>
    .submit-btn1{
         background: #FD6601;
    color: #fff;
    font-size: 13px;
    padding: 5px;
    border-radius:0px 5px 5px 0px;
    outline: none;
    border: 1px solid #FD6601;
    }
    .select-group .form-select{
        border-radius:5px 0px 0px 5px !important;
        padding:10px;
    }
</style>


@if(session('danger'))
    <div id="dangerAlert" class="alert alert-danger">
        {{ session('danger') }}
    </div>

    <script>
        setTimeout(function() {
            $('#dangerAlert').fadeOut('fast');
        }, 3000); 
    </script>
@endif


@if(session('success'))
    <div id="successAlert" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(function() {
            $('#successAlert').fadeOut('fast');
        }, 3000); 
    </script>
@endif

<div class="container-fluid">

        <!-- start page title -->
        <div class="row">
            <div class="col-6">
                <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                    <h4 class="mb-sm-0">Orders #{{ $orders->payment_order_id }}</h4>
                </div>
            </div>
            <div class="col-6">
                <div class="page-title-box">
                    <a href="{{ route('admin.download.invoice',$orders->id) }}" class="mb-sm-0" style="background: #FFD731;color: #000;padding: 10px 20px;border-radius: 25px;float: right;margin-bottom: 10px !important;">Download Invoice</a>
                </div>
            </div>
        </div>
        <!-- end page title -->
                        
                        
        <div class="row">
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        @php $user = App\Models\User::where('id',$orders->user_id)->first(); @endphp
                        <h4>Customer Details</h4>
                        <P>
                            <strong>Name : </strong>{{ $user->name }}<br/>
                            <strong>Email  : </strong>{{ $user->email }}<br/>
                            <strong>Mobile No. : </strong>{{ $user->phone }}<br/>
                        </P>
                    </div>
                </div>
            </div>
            <div class="col-6">
                <div class="card">
                    <div class="card-body">
                        <h4>Order Details</h4>
                        <P>
                            <strong>Invoice No : </strong>#{{ $orders->payment_order_id }}<br/>
                            <strong>Order Date  : </strong><?php echo (new DateTime($orders->created_at))->format('F j, Y'); ?><br/>
                            
                            @php $shipping_address = App\Models\Address::where('id',$orders->shipping_address)->first(); @endphp
                            <strong>Name : </strong>{{ $shipping_address->shipping_name }}<br/>
                            <strong>Email  : </strong>{{ $shipping_address->shipping_email }}<br/>
                            <strong>Mobile No. : </strong>{{ $shipping_address->shipping_phone }}<br/>
                            <strong>Address : </strong>{{ $shipping_address->shipping_address }}<br/>
                            @php
                                $country = App\Models\Country::where('id',$shipping_address->country)->first();
                                $state   = App\Models\State::where('id',$shipping_address->state)->first();
                                $city    = App\Models\City::where('id',$shipping_address->city)->first();
                            @endphp
                         {{ $city->name ?? '' }},&nbsp;{{ $state->name ?? '' }},&nbsp;{{ $country->name ?? '' }} - {{ $shipping_address->pincode }}
                        </P>
                    </div>
                </div>
            </div>
        </div>
        @if($orders_details->first()->gift_wrap_id)
            <div class="row">
                <div class="col-6">
                    <div class="card">
                        <div class="card-body">
                            @php $wrap = App\Models\GiftWrap::where('id',$orders_details->first()->gift_wrap_id)->first(); @endphp
                            <h4>Gift Wrap Details</h4>
                            <P>
                                <strong>Gift Wrap Name : </strong>{{ $wrap->name }}<br/>
                                <strong>Gift Wrap : </strong><img src="{{ asset($wrap->image) }}" height="50" width="100"><br/>
                            </P>
                            <P>
                                <strong>Gift Wrap Message : </strong>{{ $wrap->gift_message }}<br/>
                            </P>
                        </div>
                    </div>
                </div>
            </div>
        @endif
                        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> Orders</h4>
    
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <thead>
                            <tr>
                                <th>Sl</th>
                                <th>Images</th> 
                                <th>Product name</th> 
                                <th>Price</th> 
                                <th>Quantity</th> 
                                <th>Amount</th> 
                                
                            </thead>
    
                            <tbody>
                            @if($orders_details)	 
                                @foreach($orders_details as $key=>$item)                            
                                    <tr>
                                        <td> {{ $key+1 }} </td>
                                        @php $product_img = App\Models\Product::where('id',$item->product_id)->first(); @endphp
                                        <td> <img src="{{ asset($product_img->product_img) }}" style="height:100px;width:100px;" alt=""> </td> 
                                        <td> {{ $item->productname }} <br>
                                            <style>
                                                .color_picker label {
                                                    border: 1px solid #b5b5b5;
                                                    border-radius: 10px;
                                                    display: inline-block;
                                                    width: 25px;
                                                    height: 25px;
                                                    margin-right: 4px;
                                                }
                                            </style>
                                            <div class="color_picker ms-2">
                                                @if($item->color_id && $item->colorData)
                                                    @if($item->colorData)
                                                        <label for="color" title="{{ $item->colorData->color->color }}" style="background-color: {{ $item->colorData->color->color_code }}">
                                                            <span style="background-color: {{ $item->colorData->color->color_code }}"></span>
                                                        </label>
                                                    @endif
                                                @endif
                                            </div>
                                        </td>
                                        <td> {{ $item->offer_price }} </td> 
                                        <td> {{ $item->quantity }} </td> 
                                        <td> {{ $item->offer_price*$item->quantity }} </td> 
                                    </tr>
                                @endforeach
                            @endif
                            </tbody>
                        </table>

                    </div>
                </div>
            </div> <!-- end col -->
        </div> <!-- end row -->
        
          
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tbody>
                                <tr>
                                    <td>Order Status</td>
                                    <td>
                                         <div class="input-group select-group">
                                              <select name="order_status" id="order_status" class="form-select">
                                            <option value="0" {{ $orders->order_status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1" {{ $orders->order_status == 1 ? 'selected' : '' }}>Approved</option>
                                            <option value="2" {{ $orders->order_status == 2 ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    <button onclick="updateOrderStatus({{$orders->id}})" class="submit-btn1">Update Status</button>
                                         </div>
                                       
                                    </td>
                                </tr>
                                <tr>
                                    <td>Shipping Status</td>
                                    <td>
                                      <div class="input-group select-group">
                                            <select name="shipping_status" id="shipping_status" class="form-select">
                                            <option value="0"{{ $orders->shipping_status == 0 ? 'selected' : '' }}>Pending</option>
                                            <option value="1"{{ $orders->shipping_status == 1 ? 'selected' : '' }}>Order Received</option>
                                            <option value="2"{{ $orders->shipping_status == 2 ? 'selected' : '' }}>Shipped</option>
                                            <option value="3"{{ $orders->shipping_status == 3 ? 'selected' : '' }}>Out Of Delivery</option>
                                            <option value="4"{{ $orders->shipping_status == 4 ? 'selected' : '' }}>Delivered</option>
                                        </select>
                                           <button onclick="updateShippingStatus({{$orders->id}})" class="submit-btn1">Update Status</button>
                                      </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                      
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body">
                        <table class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                            <tbody>
                                <tr>
                                    <td> Sub Total </td>
                                    <td style="text-align: right;"> ₹{{ $totalSubtotal }} </td> 
                                </tr>
                                <tr>
                                    <td> GST Charge(+) </td>
                                    <td style="text-align: right;"> ₹{{ $orders->gst }} </td> 
                                </tr>
                                <tr>
                                    <td> Coupen Discount(-) </td>
                                    <td style="text-align: right;">₹ {{ $orders->coupon_discount }} </td> 
                                </tr>
                                <tr>
                                    <td> Total </td>
                                    <td style="text-align: right;">₹{{ str_replace(',','',$orders->total_amount)+$orders->gst }} </td> 
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
                     
                        
</div> <!-- container-fluid -->















<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script>
function updateOrderStatus(orderId) {
    var newStatus = $('#order_status').val();

    $.ajax({
        url: '{{ route("update.order.status") }}',
        method: 'POST',
        data: {
            order_id: orderId,
            new_status: newStatus,
            "_token": "{{ csrf_token() }}" // Add CSRF token for Laravel
        },
        success: function(response) {
            // Handle success response
            alert(response.message);
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
}

function updateShippingStatus(orderId) {
    var newStatus = $('#shipping_status').val();

    $.ajax({
        url: '{{ route("update.shipping.status") }}',
        method: 'POST',
        data: {
            order_id: orderId,
            new_status: newStatus,
            "_token": "{{ csrf_token() }}" // Add CSRF token for Laravel
        },
        success: function(response) {
            // Handle success response
            alert(response.message);
            console.log(response);
        },
        error: function(xhr, status, error) {
            // Handle error
            console.error(xhr.responseText);
        }
    });
}


</script>


@endsection