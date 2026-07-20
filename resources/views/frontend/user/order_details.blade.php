@extends('frontend.layouts.app')
@section('content')
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/meyer-reset/2.0/reset.min.css"> --}}
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css">


    <section class="cart-detail">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="main-title"><span>Order Details</span></h1>
                </div>
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
            </div>
            <div class="mt-4">
                <div class="row gy-4">
                    <div class="col-lg-8">
                        <div class="order-box">
                            <div class="heading">
                                <div class="row gy-4 align-items-center">
                                    <div class="col-md-6">
                                        <h5 class="title">Order Details
                                            <span>{{ $orders->created_at->format('d M, Y') }}</span><span>{{ $orderDetailsCount }}
                                                Products</span>
                                        </h5>
                                    </div>
                                    <div class="col-md-6">
                                        <p class="text-end">
                                            @if ($orders->order_status == 0)
                                                <span class="order-status in-order">Order Pending</span>
                                            @elseif($orders->order_status == 1)
                                                <span class="order-status in-order">Order Confirmed</span>
                                            @elseif($orders->order_status == 2)
                                                <span class="order-status in-order">Order Cancelled</span>
                                            @else
                                                <span class="order-status in-order">Order Waiting</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="body">
                                <div class="address-detail">
                                    <h5 class="address-title">Shipping Address</h5>
                                    <h6 class="address-name">{{ $shippingAddress->shipping_name }}</h6>
                                    <p class="address-text">{{ $shippingAddress->shipping_address }}</p>
                                    @php
                                        $country = App\Models\Country::where('id', $shippingAddress->country)->first();
                                        $state = App\Models\State::where('id', $shippingAddress->state)->first();
                                        $city = App\Models\City::where('id', $shippingAddress->city)->first();
                                    @endphp
                                    <p class="address-text">
                                        {{ $city->name ?? '' }},&nbsp;{{ $state->name ?? '' }},&nbsp;{{ $country->name ?? '' }}
                                        - {{ $shippingAddress->pincode }}</p>
                                    <h5 class="address-subtitle">Email</h5>
                                    <p class="address-text">{{ $shippingAddress->shipping_email }}</p>
                                    <h5 class="address-subtitle">Phone</h5>
                                    <p class="address-text">{{ $shippingAddress->shipping_phone }}</p>
                                </div>

                                <div class="track-order">
                                    <div class="row justify-content-between">

                                        <div
                                            class="order-tracking {{ in_array($orders->shipping_status, [1, 2, 3, 4]) ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Order Received<br>
                                                <!--<span>Mon, June 24</span>-->
                                            </p>
                                        </div>

                                        <div
                                            class="order-tracking {{ in_array($orders->shipping_status, [2, 3, 4]) ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Shipped<br>
                                                <!--<span>Tue, June 25</span>-->
                                            </p>
                                        </div>

                                        <div
                                            class="order-tracking {{ in_array($orders->shipping_status, [3, 4]) ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Out Of Delivery<br>
                                                <!--<span>Fri, June 28</span>-->
                                            </p>
                                        </div>

                                        <div class="order-tracking {{ $orders->shipping_status == 4 ? 'completed' : '' }}">
                                            <span class="is-complete"></span>
                                            <p>Delivered<br>
                                                <!--<span>Fri, June 28</span>-->
                                            </p>
                                        </div>

                                    </div>
                                </div>


                            </div>
                            <div class="over-auto profile-cart">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th scope="col">Image</th>
                                            <th scope="col">Product</th>
                                            <th scope="col">Price</th>
                                            <th scope="col">Quantity</th>
                                            <th scope="col">Review</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders_details as $key => $item)
                                            <tr>
                                                <td>
                                                    <div class="img-box">
                                                        @php
                                                            $product_img = App\Models\Product::where(
                                                                'id',
                                                                $item->product_id,
                                                            )->first();
                                                        @endphp
                                                        @if ($product_img && $product_img->product_img != null && $product_img->product_img != '')
                                                            <a href=""><img
                                                                    src="{{ asset($product_img->product_img) }}"
                                                                    alt=""></a>
                                                        @else
                                                            <p>No image available</p>
                                                        @endif
                                                    </div>

                                                </td>
                                                <td>
                                                    <a style="line-height:20px;"
                                                        href="">{{ $item->productname }}</a>
                                                        <style>
                                                            .color_picker label {
                                                                border: 1px solid #b5b5b5;
                                                                border-radius: 10px;
                                                                display: inline-block;
                                                                width: 15px;
                                                                height: 15px;
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
                                                <td class="price">₹ {{ $item->offer_price }}</td>
                                                <td> {{ $item->quantity }} Nos
                                                </td>

                                                <td>
                                                    @php
                                                        $review = App\Models\Review::where(
                                                            'product_id',
                                                            $item->product_id,
                                                        )
                                                            ->where('order_id', $item->order_id)
                                                            ->where('user_id', $item->user_id)
                                                            ->first();
                                                    @endphp

                                                    @if ($review)
                                                        <a class="common-btn">Review submitted</a>
                                                    @else
                                                        @if($item->order->shipping_status == 4)
                                                            <a data-bs-toggle="modal" data-bs-target="#exampleModal"
                                                                data-order-id="{{ $item->id }}"
                                                                class="common-btn write-review-btn"><i
                                                                    class="bi bi-pencil me-2"></i>Write review</a>
                                                        @endif
                                                    @endif
                                                </td>

                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    @php
                        $grandTotal = 0;
                    @endphp
                    
                    @foreach ($orders_details as $key => $item)
                        @php
                            $grandTotal += $item->product->offer_price * $item->quantity;
                        @endphp
                    @endforeach
                    <div class="col-lg-4">
                        <div class="total-box">
                            <h1 class="total-title">Cart Total</h1>

                            <dl class="row mt-4 gy-2">
                                
                                {{-- <dd class="col-sm-6">
                                    <p>GST Charge(+)</p>
                                </dd>
                                <dd class="col-sm-6">
                                    <p class="text-end">₹{{ $orders->gst }}</p>
                                </dd> --}}
                                <dd class="col-sm-6">
                                    <p>Total</p>
                                </dd>
                                <dd class="col-sm-6">
                                    <p class="text-end">₹{{ $grandTotal }}</p>
                                </dd>
                                
                                <dd class="col-sm-6">
                                    <p>Shipping Cost</p>
                                </dd>
                                <dd class="col-sm-6">
                                    <p class="text-end">₹{{ $orders->shipping_cost ?? 0 }}</p>
                                </dd>
                                
                                <dd class="col-sm-6">
                                    <p>Coupen Discount(-)</p>
                                </dd>
                                <dd class="col-sm-6">
                                    <p class="text-end">₹ {{ $orders->coupon_discount }}</p>
                                </dd>
                                <dd class="col-sm-6">
                                    <p>Subtotal</p>
                                </dd>
                                <dd class="col-sm-6">
                                    <p class="text-end">₹{{ $orders->total_amount}}</p>
                                </dd>
                            </dl>
                            <div class="final-cost">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <h4 class="total-rate">Total</h4>
                                    </div>
                                    <div class="col-sm-6">
                                        <h5 class="total-rate text-end">
                                            ₹{{ str_replace(',', '', $orders->total_amount) + $orders->gst }}</h5>
                                    </div>
                                </div>
                            </div>

                            <p class="mt-3"><a href="{{ route('home') }}" class="common-btn1 w-100 d-block "><i
                                        class="bi bi-arrow-left"></i>Return to Home</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


<style>
.star {
    font-size: 40px;
    color: #e74c3c;
    cursor: pointer;
    margin: 0 5px;
}
</style>
    <style>
        /* Order Details Page Styling */
        body,
        li,
        a,
        span {
            font-family: "Montserrat", sans-serif;
            font-weight: 400;
            color: var(--text-dark);
        }

        .cart-detail {
            padding: 60px 0;
            background: #f8f9fa;
        }

        .main-title {
            font-size: 32px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 20px;
        }

        .main-title span {
            color: #e74c3c;
        }

        /* Success Message */
        .alert-success {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            animation: slideDown 0.3s ease-out;
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

        /* Order Box */
        .order-box {
            background: #ffffff;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .order-box .heading {
            background: linear-gradient(135deg, #e74c3c 0%, #c0392b 100%);
            padding: 25px 30px;
            color: white;
        }

        .order-box .heading .title {
            font-size: 20px;
            font-weight: 600;
            margin: 0;
            color: white;
        }

        .order-box .heading .title span {
            display: inline-block;
            margin-left: 15px;
            font-size: 14px;
            opacity: 0.9;
            padding: 4px 12px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 20px;
        }

        /* Order Status Badge */
        .order-status {
            display: inline-block;
            padding: 8px 20px;
            border-radius: 25px;
            font-size: 14px;
            font-weight: 600;
            background: #3498db;
            color: white;
        }

        .order-status.in-order {
            background: #f39c12;
        }

        /* Order Body */
        .order-box .body {
            padding: 30px;
        }

        /* Address Details */
        .address-detail {
            margin-bottom: 40px;
        }

        .address-title {
            font-size: 18px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 2px solid #e74c3c;
        }

        .address-name {
            font-size: 16px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 8px;
        }

        .address-subtitle {
            font-size: 14px;
            font-weight: 600;
            color: #7f8c8d;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        .address-text {
            font-size: 15px;
            color: #5a6c7d;
            margin-bottom: 8px;
            line-height: 1.6;
        }

        /* Order Tracking */
        .track-order {
            margin: 40px 0;
            padding: 30px 20px;
            background: #f8f9fa;
            border-radius: 10px;
        }

        .track-order .row {
            position: relative;
        }

        .track-order .row::before {
            content: '';
            position: absolute;
            top: 20px;
            left: 10%;
            right: 10%;
            height: 3px;
            background: #e0e0e0;
            z-index: 0;
        }

        .order-tracking {
            text-align: center;
            position: relative;
            z-index: 1;
            flex: 1;
        }

        .order-tracking span.is-complete {
            display: inline-block;
            width: 40px;
            height: 40px;
            background: #e0e0e0;
            border-radius: 50%;
            position: relative;
            margin-bottom: 15px;
            transition: all 0.3s ease;
        }

        .order-tracking span.is-complete::before {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 16px;
            height: 16px;
            background: white;
            border-radius: 50%;
        }

        .order-tracking.completed span.is-complete {
            background: #27ae60;
            box-shadow: 0 0 0 4px rgba(39, 174, 96, 0.2);
        }

        .order-tracking.completed span.is-complete::before {
            content: '✓';
            background: transparent;
            color: white;
            font-weight: bold;
            font-size: 20px;
            width: auto;
            height: auto;
        }

        .order-tracking p {
            font-size: 14px;
            font-weight: 600;
            color: #7f8c8d;
            margin: 0;
            line-height: 1.4;
        }

        .order-tracking.completed p {
            color: #27ae60;
        }

        /* Product Table */
        .profile-cart {
            margin-top: 30px;
        }

        .profile-cart table {
            background: white;
            border: 1px solid #dee2e6;
        }

        .profile-cart thead {
            background: #f8f9fa;
        }

        .profile-cart thead th {
            font-weight: 600;
            color: #2c3e50;
            padding: 15px;
            border-bottom: 2px solid #e74c3c;
            font-size: 14px;
        }

        .profile-cart tbody td {
            padding: 15px;
            vertical-align: middle;
            color: #5a6c7d;
        }

        .profile-cart .img-box {
            width: 80px;
            height: 80px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            overflow: hidden;
            border: 1px solid #e0e0e0;
        }

        .profile-cart .img-box img {
            max-width: 100%;
            max-height: 100%;
            object-fit: cover;
        }

        .profile-cart .price {
            font-weight: 600;
            color: #e74c3c;
            font-size: 16px;
        }

        /* Common Button */
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

        .write-review-btn {
            font-size: 13px;
            padding: 8px 16px;
        }

        /* Total Box */
        .total-box {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            position: sticky;
            top: 20px;
        }

        .total-title {
            font-size: 22px;
            font-weight: 700;
            color: #2c3e50;
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e74c3c;
        }

        .total-box dl.row dd {
            margin-bottom: 0;
        }

        .total-box dl.row dd p {
            font-size: 15px;
            color: #5a6c7d;
            margin: 0;
        }

        .total-box .final-cost {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 2px solid #ecf0f1;
        }

        .total-rate {
            font-size: 20px;
            font-weight: 700;
            color: #2c3e50;
            margin: 0;
        }

        .total-rate.text-end {
            color: #e74c3c;
        }

        .common-btn1 {
            background: white;
            color: #e74c3c;
            border: 2px solid #e74c3c;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 15px;
            font-weight: 600;
            transition: all 0.3s ease;
            text-decoration: none;
            text-align: center;
        }

        .common-btn1:hover {
            background: #e74c3c;
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(231, 76, 60, 0.3);
        }

        /* Responsive Design */
        @media (max-width: 991px) {
            .total-box {
                margin-top: 30px;
                position: static;
            }

            .track-order .row::before {
                display: none;
            }

            .order-tracking {
                margin-bottom: 20px;
            }
        }

        @media (max-width: 768px) {
            .cart-detail {
                padding: 40px 0;
            }

            .main-title {
                font-size: 24px;
            }

            .order-box .heading .title span {
                display: block;
                margin: 10px 0 0 0;
            }

            .profile-cart {
                overflow-x: auto;
            }

            .profile-cart table {
                min-width: 600px;
            }
        }
        .review-textarea {
            resize: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            border: 1px solid #ced4da;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        .review-textarea:focus {
            border-color: #28a745;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25);
        }
    </style>

        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header">
                        <h1 class="modal-title fs-5">Write a Review</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form id="review-form" action="{{ route('add.review') }}" method="post">
                            @csrf
                            <input type="hidden" name="order_id" id="order-id" value="{{ $orders->id }}">
                            <input type="hidden" name="rate_value" id="rate-value">

                            <div class="text-center mb-3">
                                <i class="far fa-star star" data-value="1"></i>
                                <i class="far fa-star star" data-value="2"></i>
                                <i class="far fa-star star" data-value="3"></i>
                                <i class="far fa-star star" data-value="4"></i>
                                <i class="far fa-star star" data-value="5"></i>
                            </div>
                            <label for="comment" class="form-label fw-semibold">Your Comment</label>
                            <textarea
                                id="comment"
                                name="comment"
                                class="form-control review-textarea"
                                rows="4"
                                placeholder="Write your experience here..."
                            ></textarea>
                            <small class="text-muted">Minimum 10 characters</small>
                            <div class="text-center">
                                <button type="submit" class="btn-success" id="submit-review" disabled>Add Review</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

@endsection

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>

<script>
    $(document).ready(function () {

        function toggleSubmitButton() {
            let rating  = $('#rate-value').val();
            let comment = $('#comment').val().trim();

            if (rating && comment.length >= 10) {
                $('#submit-review').prop('disabled', false);
            } else {
                $('#submit-review').prop('disabled', true);
            }
        }

        // Reset modal on open
        $('.write-review-btn').on('click', function () {
            let orderId = $(this).data('order-id');

            $('#order-id').val(orderId);
            $('#rate-value').val('');
            $('#comment').val('');

            $('.star').removeClass('fas').addClass('far');
            $('#submit-review').prop('disabled', true);
        });

        // Hover effect
        $('.star').on('mouseenter', function () {
            let onStar = parseInt($(this).data('value'));

            $('.star').each(function (index) {
                $(this)
                    .toggleClass('fas', index < onStar)
                    .toggleClass('far', index >= onStar);
            });
        }).on('mouseleave', function () {
            let rating = parseInt($('#rate-value').val()) || 0;

            $('.star').each(function (index) {
                $(this)
                    .toggleClass('fas', index < rating)
                    .toggleClass('far', index >= rating);
            });
        });

        // Click to select rating
        $('.star').on('click', function () {
            let onStar = parseInt($(this).data('value'));
            $('#rate-value').val(onStar);

            $('.star').each(function (index) {
                $(this)
                    .toggleClass('fas', index < onStar)
                    .toggleClass('far', index >= onStar);
            });

            toggleSubmitButton();
        });

        // Comment input validation
        $('#comment').on('input', function () {
            toggleSubmitButton();
        });

    });
</script>

{{-- <script>
    document.addEventListener("DOMContentLoaded", function() {
        var reviewButtons = document.querySelectorAll('.write-review-btn');
        var orderIdInput = document.getElementById('order-id');
        var displayOrderId = document.getElementById('display-order-id');

        reviewButtons.forEach(function(button) {
            button.addEventListener('click', function() {
                var orderId = this.getAttribute('data-order-id');
                orderIdInput.value = orderId;
                displayOrderId.textContent = orderId;
            });
        });

        // Rating and feedback tags functionality
        $(".rating-component .star").on("mouseover", function() {
            var onStar = parseInt($(this).data("value"), 10);
            $(this).parent().children("i.star").each(function(e) {
                if (e < onStar) {
                    $(this).addClass("hover");
                } else {
                    $(this).removeClass("hover");
                }
            });
        }).on("mouseout", function() {
            $(this).parent().children("i.star").each(function(e) {
                $(this).removeClass("hover");
            });
        });

        $(".rating-component .stars-box .star").on("click", function() {
            var onStar = parseInt($(this).data("value"), 10);
            var stars = $(this).parent().children("i.star");
            var ratingMessage = $(this).data("message");

            var msg = onStar;
            $('.rating-component .starrate .ratevalue').val(msg);

            $(".fa-smile-wink").show();
            $(".button-box .done").show();

            if (onStar === 5) {
                $(".button-box .done").removeAttr("disabled");
            } else if (onStar === 4 || onStar === 3 || onStar === 2 || onStar === 1) {
                $(".button-box .done").removeAttr("disabled");
            } else {
                $(".button-box .done").attr("disabled", "true");
            }

            for (i = 0; i < stars.length; i++) {
                $(stars[i]).removeClass("selected");
            }

            for (i = 0; i < onStar; i++) {
                $(stars[i]).addClass("selected");
            }

            $(".status-msg .rating_msg").val(ratingMessage);
            $(".status-msg").html(ratingMessage);
            $("[data-tag-set]").hide();
            $("[data-tag-set=" + onStar + "]").show();
        });

        $(".feedback-tags").on("click", function() {
            var choosedTagsLength = $(this).parent("div.tags-box").find("input").length + 1;

            if ($(this).hasClass("choosed")) {
                $(this).removeClass("choosed");
                choosedTagsLength -= 2;
            } else {
                $(this).addClass("choosed");
            }

            if (choosedTagsLength <= 0) {
                $(".button-box .done").attr("enabled", "false");
            }
        });

        $(".compliment-container .fa-smile-wink").on("click", function() {
            $(this).fadeOut("slow", function() {
                $(".list-of-compliment").fadeIn();
            });
        });

        $(".done").on("click", function() {
            $(".rating-component").hide();
            $(".feedback-tags").hide();
            $(".button-box").hide();
            $(".submitted-box").show();
            $(".submitted-box .loader").show();

            setTimeout(function() {
                $(".submitted-box .loader").hide();
                $(".submitted-box .success-message").show();
            }, 1500);
        });
    });
</script> --}}