@extends('frontend.layouts.app')
@section('content')



    <style>
        .count-clr {
            background: #000;
            /* padding: 6px; */
            /* border-radius: 50%; */
            float: right;
            width: 40px;
            font-size: 17px;
            height: 40px;
            line-height: 40px;
            border-radius: 50px;
            text-align: center;
            color: #ffffff;
            font-weight: 700;
        }

        /* Order History Page Styling */

        .profile-detail {
            padding: 60px 0;
            background: #f8f9fa;
            min-height: calc(100vh - 200px);
        }

        .main-title {
            font-size: 28px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 10px;
            position: relative;
            display: inline-block;
        }

        .main-title::after {
            content: '';
            position: absolute;
            bottom: -5px;
            left: 0;
            width: 60px;
            height: 3px;
            background: #e74c3c;
        }

        /* Alert Messages */
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            border-left: 4px solid #28a745;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
            box-shadow: 0 2px 8px rgba(40, 167, 69, 0.1);
        }

        .alert-danger {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            border-left: 4px solid #dc3545;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
            box-shadow: 0 2px 8px rgba(220, 53, 69, 0.1);
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Profile Right Section */
        .profile-right {
            width: 100%;
        }

        .profile-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
        }

        .profile-box-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #e74c3c;
        }

        /* Order List */
        .order-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .order-list>li {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 20px;
            transition: all 0.3s ease;
            border: 1px solid #e9ecef;
        }

        .order-list>li:hover {
            box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
            transform: translateY(-2px);
            border-color: #e74c3c;
        }

        .order-list>li:last-child {
            margin-bottom: 0;
        }

        .order-list dl.row {
            margin: 0;
        }

        .order-list dd {
            margin: 0;
        }

        /* Profile Card Image */
        .profile-card-img {
            width: 100%;
            height: 180px;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            border: 2px solid #e9ecef;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-card-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .order-list>li:hover .profile-card-img img {
            transform: scale(1.05);
        }

        .profile-card-img .count-clr {
            position: absolute;
            top: 10px;
            right: 10px;
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 2px 12px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            box-shadow: 0 2px 8px rgba(231, 76, 60, 0.3);
        }

        /* Badge Styling */
        .badge {
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: 600;
            display: inline-block;
            margin-bottom: 15px;
        }

        .text-bg-primary {
            background: #3498db !important;
            color: white;
        }

        .text-bg-success {
            background: #27ae60 !important;
            color: white;
        }

        .text-bg-danger {
            background: #e74c3c !important;
            color: white;
        }

        .text-bg-warning {
            background: #f39c12 !important;
            color: white;
        }

        /* Profile Card Title */
        .profile-card-title {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .profile-card-title a {
            color: #2c3e50;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .profile-card-title a:hover {
            color: #e74c3c;
        }

        /* Profile Card Description */
        .profile-card-desc {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .profile-card-desc li {
            margin-bottom: 8px;
        }

        .profile-card-desc li p {
            font-size: 15px;
            color: #5a6c7d;
            margin: 0;
        }

        .profile-card-rate {
            font-weight: 700;
            color: #e74c3c;
            font-size: 18px;
        }

        /* Buttons */
        .common-btn {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            color: white;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            border: none;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .common-btn:hover {
            background: linear-gradient(135deg, #c0392b 0%, #a93226 100%);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        .common-btn i {
            margin-right: 5px;
        }

        .common-btn2 {
            background: white;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .common-btn2:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        /* Empty State */
        .order-list:empty::after {
            content: 'No orders found';
            display: block;
            text-align: center;
            padding: 60px 20px;
            color: #7f8c8d;
            font-size: 16px;
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .profile-detail {
                padding: 40px 0;
            }

            .main-title {
                font-size: 24px;
            }

            .profile-box {
                padding: 20px;
            }

            .order-list>li {
                padding: 20px;
            }

            .profile-card-img {
                height: 150px;
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .profile-detail {
                padding: 30px 0;
            }

            .main-title {
                font-size: 20px;
            }

            .profile-box-title {
                font-size: 18px;
            }

            .order-list>li {
                padding: 15px;
            }

            .profile-card-img {
                height: 200px;
            }

            .common-btn,
            .common-btn2 {
                font-size: 13px;
                padding: 8px 16px;
                margin-bottom: 10px;
                display: block;
                text-align: center;
            }

            .common-btn2.ms-3 {
                margin-left: 0 !important;
            }
        }

        @media (max-width: 576px) {
            .profile-card-title {
                font-size: 16px;
            }

            .profile-card-desc li p {
                font-size: 14px;
            }

            .profile-card-rate {
                font-size: 16px;
            }
        }

        /* Sidebar Spacing */
        .gx-2 {
            --bs-gutter-x: 1rem;
        }

        .gy-4 {
            --bs-gutter-y: 1.5rem;
        }

        /* Additional hover effects */
        .order-list>li {
            position: relative;
            overflow: hidden;
        }

        .order-list>li::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(231, 76, 60, 0.05), transparent);
            transition: left 0.5s ease;
        }

        .order-list>li:hover::before {
            left: 100%;
        }
    </style>

    <div class="profile-detail">
        <div class="container">
            <h5 class="main-title">Order History</h5>
            <div class="row gy-4 gx-2 mt-3">
                @include('frontend.user.sidebar')

                @if (session('success'))
                    <div id="successMessage" class="alert alert-success">
                        {{ session('success') }}
                    </div>

                    <script>
                        // Automatically hide the success message after 5 seconds
                        setTimeout(function() {
                            document.getElementById('successMessage').style.display = 'none';
                        }, 5000);
                    </script>
                @endif

                @if (session('error'))
                    <div id="errorMessage" class="alert alert-danger">
                        {{ session('error') }}
                    </div>

                    <script>
                        // Automatically hide the error message after 5 seconds
                        setTimeout(function() {
                            document.getElementById('errorMessage').style.display = 'none';
                        }, 5000);
                    </script>
                @endif

                <div class="col-lg-9 col-md-8">
                    <div class="profile-right">
                        <div class="profile-box">
                            <h5 class="profile-box-title">My Order History</h5><br>
                            <ul class="order-list">
                                @if ($orders)
                                    @foreach ($orders as $order)
                                        <li>
                                            <dl class="row gy-3 align-items-center">
                                                <dd class="col-lg-3 col-md-4 mb-3">
                                                    <div class="profile-card-img">
                                                        <?php
                                                        $orderDetails = App\Models\OrderDetail::where('order_id', $order->id)->get();
                                                        $product = null;
                                                        
                                                        if ($orderDetails->isNotEmpty()) {
                                                            // Get the first order detail
                                                            $firstOrderDetail = $orderDetails->first(); // or $orderDetails[0];
                                                            $orderDetailsCount = $orderDetails->count();
                                                        
                                                            // Fetch the product associated with the first order detail
                                                            $product = App\Models\Product::find($firstOrderDetail->product_id);
                                                        }
                                                        ?>

                                                        @if ($product)
                                                            <img src="{{ asset($product->product_img) }}"
                                                                alt="">
                                                        @endif

                                                        @php $orderDetailsCount = $orderDetailsCount - 1; @endphp
                                                        @if ($orderDetailsCount != 0)
                                                            <span class="count-clr">+{{ $orderDetailsCount }}</span>
                                                        @endif
                                                    </div>

                                                </dd>
                                                <dd class="col-lg-9 col-md-12">

                                                    @if ($order->order_status == 0)
                                                        <p class="badge text-bg-primary mb-3">Pending</p>
                                                    @elseif($order->order_status == 1)
                                                        <p class="badge text-bg-success mb-3">Approved</p>
                                                    @elseif($order->order_status == 2)
                                                        <p class="badge text-bg-danger mb-3">Cancelled</p>
                                                    @else
                                                        <p class="badge text-bg-warning mb-3">Waiting</p>
                                                    @endif

                                                    <h5 class="profile-card-title"><a
                                                            href="{{ route('user.order.details', $order->id) }}">{{ $order->payment_order_id }}</a>
                                                    </h5>
                                                    <ul class="profile-card-desc">

                                                        <li>
                                                            <p>Total Price : <span class="profile-card-rate">₹
                                                                    {{ $order->total_amount }}</span></p>
                                                        </li>
                                                    </ul>
                                                    <p class="mt-4">
                                                        <!--<a data-bs-toggle="modal" data-bs-target="#exampleModal" data-order-id="{{ $order->id }}" class="btn common-btn write-review-btn"><i class="bi bi-pencil me-2"></i>Write review</a> -->
                                                        <a href="{{ route('user.order.details', $order->id) }}"
                                                            class="common-btn"><i class="bi bi-pencil me-2"></i>Write
                                                            review</a>
                                                        <a href="{{ route('user.order.details', $order->id) }}"
                                                            class="common-btn2 ms-3">Order Details</a>
                                                    </p>
                                            </dl>
                                        </li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>

                    </div>
                </div>


            </div>
        </div>
    </div>




@endsection
