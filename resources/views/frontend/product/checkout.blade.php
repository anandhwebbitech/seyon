@extends('frontend.layouts.app')
@section('content')
    <style>
        .address-card {
            transition: all 0.2s ease-in-out;
            background: #fff;
        }

        .address-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.08);
            transform: translateY(-2px);
        }

        .address-card .badge {
            font-size: 0.7rem;
            padding: 4px 8px;
            border-radius: 6px;
        }

        .btn-light.btn-sm {
            font-size: 0.75rem;
            border-radius: 6px;
        }

        .btn-success {
            background: #28a745;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: #218838;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
        }

        .btn-danger {
            background: #dc3545;
            border: none;
            padding: 10px 25px;
            font-weight: 600;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .btn-danger:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
        }
        /* ===== ORDER SUMMARY CARD ===== */
        .order-summary-new {
            background: #ffffff;
            padding: 22px;
            border-radius: 14px;
            box-shadow: 0 6px 22px rgba(0,0,0,0.08);
            border: 1px solid #f1f1f1;
        }

        /* Title */
        .os-title {
            font-size: 20px;
            font-weight: 700;
            margin-bottom: 18px;
        }

        /* ===== MILESTONE ===== */
        .milestone-box-new {
            background: #faf7ff;
            padding: 14px;
            border-radius: 12px;
            border: 1px solid #e5d8ff;
            position: relative;
            overflow: hidden;
        }
        .milestone-num {
            display: none;
            font-size: 34px;
            font-weight: 800;
            text-align: center;
            color: #8a2be2;
        }
        .steps-new {
            display: flex;
            justify-content: space-between;
            font-size: 12px;
            color: #666;
        }

        /* POPUP */
        .popup {
            position: absolute;
            top: -50px;
            left: 50%;
            transform: translateX(-50%);
            background: #8a2be2;
            color: #fff;
            padding: 8px 18px;
            border-radius: 8px;
            font-size: 14px;
            opacity: 0;
            transition: .4s ease;
        }
        .popup.show {
            top: 10px;
            opacity: 1;
        }

        /* CONFETTI */
        .confetti {
            position: absolute;
            width: 8px;
            height: 12px;
            top: -20px;
            animation-name: fall;
            animation-timing-function: linear;
        }
        @keyframes fall {
            0% { transform: translateY(0) rotate(0); }
            100% { transform: translateY(160px) rotate(360deg); }
        }

        /* ===== PRODUCTS ===== */
        .product-item-new {
            display: flex;
            align-items: center;
            padding: 10px 0;
            margin-bottom: 6px;
            border-bottom: 1px dashed #e2e2e2;
        }

        .product-item-new img {
            width: 55px;
            height: 55px;
            border-radius: 8px;
            object-fit: cover;
        }
        .product-info {
            margin-left: 10px;
            flex-grow: 1;
        }
        .product-info h6 {
            margin: 0;
            font-size: 14px;
            font-weight: 600;
        }
        .product-info span {
            font-size: 12px;
            color: #777;
        }

        /* ===== COUPON ===== */
        .coupon-box {
            display: flex;
            gap: 8px;
            margin-top: 10px;
        }
        .coupon-box input {
            height: 38px;
            border-radius: 8px;
        }
        .apply-btn-new, .remove-btn-new {
            padding: 6px 16px;
            font-size: 13px;
            border-radius: 8px;
            font-weight: 600;
            border: none;
        }
        .apply-btn-new {
            background: #7c3aed;
            color: #fff;
        }
        .remove-btn-new {
            background: #f44336;
            color: #fff;
        }

        /* ===== PAYMENT ===== */
        .payment-option-new {
            padding: 10px;
            border: 1px solid #eaeaea;
            border-radius: 10px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 8px;
            transition: 0.2s;
        }
        .payment-option-new:hover {
            border-color: #7c3aed;
        }

        /* ===== TOTAL ===== */
        .summary-line {
            display: flex;
            justify-content: space-between;
            margin-bottom: 6px;
            font-size: 14px;
        }
        .summary-total {
            display: flex;
            justify-content: space-between;
            font-size: 18px;
            font-weight: 700;
            color: #7c3aed;
            padding-top: 10px;
            border-top: 1px solid #eee;
        }

        /* BUTTON */
        .place-order-new {
            background: #7c3aed;
            color: #fff;
            width: 100%;
            border-radius: 10px;
            padding: 12px;
            font-size: 16px;
            font-weight: 700;
            margin-top: 15px;
            border: none;
            transition: 0.2s;
        }
        .place-order-new:hover {
            background: #5b21b6;
        }
        /* Buttons */
        .common-btn1 {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #dc3545;
            color: white;
        }
        .common-btn2 {
            padding: 10px 20px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #ffffff;
            color: rgb(31, 219, 22);
            border: solid 1px rgb(31, 219, 22);
        }
        .common-btn2:hover {
            background: rgb(31, 219, 22);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(32, 219, 22, 0.19);
            color: white;
        }
        .common-btn1:hover {
            background: #c82333;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(220, 53, 69, 0.3);
            color: white;
        }

        .common-btn1 i {
            font-size: 14px;
        }

    </style>
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a class="text-decoration-none text-dark" href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Checkout</li>
            </ol>
        </nav>
        <h4 class="page-title">Checkout</h4>
    </section>

    <section>
        <div class="checkout-cont container">
            <h1 class="mb-4 fw-bold">Checkout</h1>

            <form action="{{ route('payment.process') }}" method="POST" enctype="multipart/form-data" id="place-order">
                <div class="row">
                    @csrf
                    <div class="col-lg-7">
                        <div class="billing-section">
                            <!-- Address Card -->
                            <h3 class="mb-4 fw-bold">Address Card</h3>
                            <div class="d-flex justify-content-between">
                                <div class="col-md-8 mx-2">
                                    @if ($addresses->isNotEmpty() && !$primary_address)
                                        <button class="btn-light border text-muted" data-bs-toggle="modal"
                                            data-bs-target="#changeAddressModal">
                                            <i class="bi bi-pencil-square"></i> Choose Address
                                        </button>
                                    @endif
                                    @if (isset($primary_address))
                                        <div class="address-card border rounded-4 shadow-sm p-3 mb-3"
                                            style="max-width: 420px;">
                                            <div class="d-flex align-items-start justify-content-between">
                                                <div class="d-flex align-items-center gap-2">
                                                    <input type="radio" name="shipping_address"
                                                        class="form-check-input mt-0" value="{{ $primary_address->id }}"
                                                        checked>

                                                    <div>
                                                        <h6 class="mb-0 fw-semibold">{{ $primary_address->shipping_name }}
                                                        </h6>
                                                        <div class="mt-1 d-flex flex-wrap gap-2 align-items-center">
                                                            @if ($primary_address->is_default == 1)
                                                                <span class="badge bg-success">Default</span>
                                                            @endif
                                                            <span
                                                                class="badge bg-primary">{{ strtoupper($primary_address->address_type) }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                @if ($addresses->isNotEmpty())
                                                    <button class="btn-light border text-muted" data-bs-toggle="modal"
                                                        data-bs-target="#changeAddressModal">
                                                        <i class="bi bi-pencil-square"></i> Change
                                                    </button>
                                                @endif
                                            </div>

                                            @if (isset($primary_address))
                                                <hr class="my-2">
                                                <div class="text-secondary small">
                                                    <div class="mb-1">
                                                        <strong class="text-dark">Address:</strong><br>
                                                        {{ $primary_address->shipping_address }},
                                                        {{ $primary_address->cityDetail->name ?? '' }},
                                                        {{ $primary_address->stateDetail->name ?? '' }},
                                                        {{ $primary_address->countryDetail->name ?? '' }}.
                                                    </div>
                                                    <div><strong class="text-dark">Pin Code:</strong>
                                                        {{ $primary_address->pincode }}
                                                    </div>
                                                    <div><strong class="text-dark">Email:</strong>
                                                        {{ $primary_address->shipping_email }}
                                                    </div>
                                                    <div><strong class="text-dark">Phone:</strong>
                                                        {{ $primary_address->shipping_phone }}</div>
                                                </div>
                                            @endif
                                        </div>
                                    @endif
                                </div>

                                <div class="col-md-4 d-flex justify-content-center align-items-center mx-2">
                                    <button type="button"
                                        class="btn-primary address-card border rounded-3 shadow-sm p-3 mb-3"
                                        data-bs-toggle="modal" data-bs-target="#addAddressModal">
                                        <i class="bi bi-plus-circle me-1"></i> Add Address
                                    </button>
                                </div>
                            </div>
                            @error('shipping_address')
                                <div class="alert alert-danger py-1 my-1">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                        <h3 class="mb-4 fw-bold">Billing details</h3>
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="courierPreference" class="form-label">Courier Preference</label>
                                <div class="row">
                                    <div class="courier-option m-0 col-6 col-md-4 ">
                                        <input type="radio" id="stCourier" name="courier_name" value="ST Courier"
                                            class="courier-radio" @checked(old('courier_name') == 'ST Courier')>
                                        <label for="stCourier">
                                            <img src="{{ asset('frontend/stc.webp') }}" alt="ST Courier"
                                                class="courier-img">
                                        </label>
                                    </div>
                                    <div class="courier-option m-0 col-6 col-md-4">
                                        <input type="radio" id="edcCourier" name="courier_name" value="DTDC"
                                            class="courier-radio" @checked(old('courier_name') == 'DTDC')>
                                        <label for="edcCourier">
                                            <img src="{{ asset('frontend/dtdc.webp') }}" alt="DTDC"
                                                class="courier-img">
                                        </label>
                                    </div>
                                    <div class="courier-option m-0 col-6 col-md-4">
                                        <input type="radio" id="professionalCourier" name="courier_name"
                                            value="Professional Courier" class="courier-radio"
                                            @checked(old('courier_name') == 'Professional Courier')>
                                        <label for="professionalCourier">
                                            <img src="{{ asset('frontend/proff.webp') }}" alt="Professional Courier"
                                                class="courier-img">
                                        </label>
                                    </div>
                                    <div class="courier-option m-0 col-6 col-md-4 ">
                                        <input type="radio" id="Delhivery" name="courier_name" value="Delhivery"
                                            class="courier-radio" @checked(old('courier_name') == 'Delhivery')>
                                        <label for="Delhivery">
                                            <img src="{{ asset('frontend/delhivery.png') }}" alt="Delhivery"
                                                class="courier-img">
                                        </label>
                                    </div>
                                    <div class="courier-option m-0 col-6 col-md-4">
                                        <input type="radio" id="indiaPost" name="courier_name" value="India Post"
                                            class="courier-radio" @checked(old('courier_name') == 'India Post')>
                                        <label for="indiaPost">
                                            <img src="{{ asset('frontend/india_post.png') }}" alt="India Post"
                                                class="courier-img">
                                        </label>
                                    </div>
                                </div> 
                                <div id="courier_name-error" class="text-danger courier-error"></div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-5">
                        <!-- Order Summary -->
                        <div class="order-summary">
                            @php
                                $subtotal = 0;

                                if ($cartItems->isNotEmpty()) {
                                    foreach ($cartItems as $item) {
                                        $subtotal += $item->product->offer_price * $item->quantity;
                                    }
                                }

                                $coupon = session('coupon');
                                $discount = 0;

                                if ($coupon && isset($coupon['percentage'])) {
                                    $discount = round(($subtotal * $coupon['percentage']) / 100);
                                    $subtotal -= $discount;
                                }

                                // if (isset($cartItems->first()->gift_wrap_id)) {
                                //     $subtotal += $cartItems->first()->giftWrap->price;
                                // }
                                
                                $shipping_cost = $primary_address->shippingPrice?->shipping_cost ?? 90;
                                // $subtotal += $shipping_cost;
                                $sub_total = $subtotal;
                            @endphp

                            <h4 class="mb-4 fw-bold">Your Order</h4>
                            @if($milestones->isNotEmpty())
                                <section class="milestone-box-new mb-3">
                                    <div id="successPopup" class="popup">
                                        🎉 Reached {{ $milestones[0]->name ?? 'Milestone' }}! 🎊
                                    </div>

                                    <div class="milestone-num" id="counter">0</div>
                                    @php
                                        $nextMilestone = $milestones->firstWhere('amount', '>', $subtotal);
                                    @endphp
                                    
                                    <p class="milestone-text text-success">
                                        @if($nextMilestone)
                                            Add ₹{{ $nextMilestone->amount - $subtotal }} more to get
                                            <strong>{{ $nextMilestone->name }}</strong>
                                        @else
                                            🎉 You have unlocked all rewards!
                                        @endif
                                    </p>

                                    <div class="progress mt-2" style="height: 10px;">
                                        <div id="progressBar" class="progress-bar bg-primary"></div>
                                    </div>

                                    <div class="steps-new mt-1 milestone-labels">
                                        <div class="step-label">
                                            <span class="step-value">₹0</span>
                                            <small>Start</small>
                                        </div>
                                        @foreach ($milestones as $milestone)
                                            <div class="step-label">
                                                <span class="step-value">₹{{ $milestone->amount }}</span>
                                                <small>{{ $milestone->name }}</small>
                                            </div>
                                        @endforeach
                                    </div>

                                </section>
                            @endif
                            <div class="mb-3">
                                <h6 class="text-muted mb-3">Products</h6>
                                @php
                                    $subtotal = 0;
                                @endphp

                                @if ($cartItems->isNotEmpty())
                                    @foreach ($cartItems as $cartItem)
                                        @php
                                            $product_total = $cartItem->product->offer_price * $cartItem->quantity;
                                            $subtotal += $product_total;
                                        @endphp
                                        <div class="product-item d-flex align-items-center mb-3 border-bottom pb-2">
                                            <div class="product-image-wrapper"
                                                style="width: 60px; height: 60px; overflow: hidden; border-radius: 8px;">
                                                <img src="{{ asset($cartItem->product->product_img) }}" alt="Product"
                                                    class="img-fluid">
                                            </div>

                                            <div class="product-details flex-grow-1 ms-3">
                                                <h6 class="mb-1">{{ $cartItem->product->product_name }}</h6>
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
                                                <div class="color_picker_or_variant">
                                                    @if($cartItem->color_id && $cartItem->colorData)
                                                        
                                                        @if($cartItem->colorData->color_code)
                                                            <div class="color_picker" style="display: inline-block;">
                                                                <label for="color" title="{{ $cartItem->colorData->color_title ?? '' }}" style="background-color: {{ $cartItem->colorData->color_code }}; cursor: default; margin-bottom: 0;">
                                                                    <span style="background-color: {{ $cartItem->colorData->color_code }}"></span>
                                                                </label>
                                                            </div>
                                                            
                                                        @elseif($cartItem->colorData->variant_name)
                                                            <div class="variant_badge mt-1">
                                                                <span class="badge bg-light text-dark border" style="padding: 5px 10px; font-weight: 500; font-size: 12px; border-radius: 4px;">
                                                                    Type: {{ $cartItem->colorData->variant_name }}
                                                                </span>
                                                            </div>
                                                        @endif

                                                    @endif
                                                </div>
                                                    <div class="text-muted small">Price:
                                                        ₹{{ number_format($cartItem->product->offer_price, 2) }}</div>
                                                </div>
                                            <div class="product-details flex-grow-1 ms-3">
                                                <div class="text-muted small">Qty: {{ $cartItem->quantity }}</div>
                                            </div>

                                            <div class="product-total text-end fw-semibold">
                                                ₹{{ number_format($product_total, 2) }}
                                            </div>
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                            @php    
                                $coupon = session('coupon');
                                $discount = 0;

                                $firstMilestone = $milestones ? $milestones->first() : null; 
                                
                                $milestoneAmount = $firstMilestone ? $firstMilestone->amount : 0;

                                $isFirstMilestoneReached = $subtotal >= $milestoneAmount;
                            @endphp
             
                            <span class="badge bg-success w-100">
                                @if($cartItems->first()->gift_wrap_id)
                                    <input type="checkbox" name="gift_wrap" 
                                    @if($cartItems->first()->gift_wrap_id) checked disabled 
                                    @endif> Applied Gift Wrap
                                {{-- @else
                                    <input type="checkbox" name="gift_wrap">Apply Gift Wrap --}}
                                @endif
                            </span>

                            <div class="coupon-section">
                                <div class="coupon-controls d-flex align-items-center gap-2">
                                    <input type="text" class="coupon-input form-control" name="coupon"
                                        placeholder="Enter Coupon Code" value="{{ session('coupon.code') ?? '' }}"
                                        style="max-width: 200px;" {{ session('coupon.code') ? 'readonly' : '' }}>

                                    @if (session()->has('coupon'))
                                        <button type="button" class="removed-btn">Remove</button>
                                    @else
                                        <button type="button" class="apply-btn">APPLY</button>
                                    @endif
                                </div>
                                @if (session()->has('coupon'))
                                    <span class="text-success">✅ Coupon applied successfully!</span>
                                @endif
                                <span class="text-danger coupon-error d-none">❌ Invalid or expired coupon code.</span>
                            </div>
                            <div class="mb-3">
                                <span class="d-block mb-2 fw-semibold">Payment Method</span>

                                <!-- Pay Online -->
                                <div class="payment-option d-flex align-items-center gap-3 mb-2">
                                    <input type="radio" name="payment_method" class="payment_method" id="payOnline"
                                        value="online" @checked(old('payment_method') == 'online')>
                                    <label for="payOnline"
                                        class="d-flex align-items-center gap-2 cursor-pointer p-2 border rounded">
                                        <span>Pay Online</span>
                                        <img src="{{ asset('frontend/img/google-pay.png') }}" alt="BHIM"
                                            style="height:30px;">
                                        <img src="{{ asset('frontend/img/visa.png') }}" alt="BHIM"
                                            style="height:10px;">
                                        <img src="{{ asset('frontend/img/paypal.png') }}" alt="BHIM"
                                            style="height:28px;">
                                    </label>
                                </div>

                                <!-- Cash on Delivery -->
                                <div class="payment-option d-flex align-items-center gap-3">
                                    <input type="radio" name="payment_method" class="payment_method" id="cod"
                                        value="cod" @checked(old('payment_method') == 'cod')>
                                    <label for="cod"
                                        class="d-flex align-items-center gap-2 cursor-pointer p-2 border rounded">
                                        <span>Cash On Delivery</span>
                                    </label>
                                </div>
                                <label id="payment_method-error" class="error text-danger" for="payment_method"></label>
                                <!-- Validation Error -->
                                @error('payment_method')
                                    <div class="text-danger mt-1">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="total-section border-top pt-3">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <h6 class="mb-0">Sub Total</h6>


                                    @if ($coupon)
                                        <div class="d-flex flex-column">
                                            <span
                                                class="total-amount"><strike>₹{{ number_format($subtotal, 2) }}</strike></span>
                                            @php
                                                if (!empty($coupon) && isset($coupon['percentage'])) {
                                                    $discount = round(($subtotal * $coupon['percentage']) / 100);
                                                }
                                                $subtotal = $subtotal - $discount;
                                            @endphp
                                            <span class="total-amount">₹{{ number_format($subtotal, 2) }}</span>
                                        </div>
                                    @else
                                        <span class="total-amount">₹{{ number_format($subtotal, 2) }}</span>
                                    @endif
                                </div>

                                @if (isset($cartItems->first()->gift_wrap_id))
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Gift Wrap Cost</h6>
                                        <span class="total-amount">₹{{ $cartItems->first()->giftWrap->price }}</span>
                                    </div>

                                    @php
                                        $subtotal = $subtotal + $cartItems->first()->giftWrap->price;
                                    @endphp
                                @endif
                                
                                @php
                                    $shipping_cost = $primary_address->shippingPrice?->shipping_cost ?? 90;

                                    $freeShippingMilestone = $milestones->sortByDesc('amount')->first();

                                    if ($freeShippingMilestone && $subtotal >= $freeShippingMilestone->amount) {
                                        $shipping_cost = 0;
                                    }

                                    $subtotal = $subtotal + $shipping_cost;
                                @endphp
                                @php
                                    $exitOffer = session('exit_offer');
                                    $exitDiscount = $exitOffer['amount'] ?? 0;
                                @endphp
                                @if (isset($shipping_cost))
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Shipping Cost</h6>
                                        <span class="total-amount">₹{{ $shipping_cost }}</span>
                                    </div>
                                @endif
                                <input name="shipping_cost" value="{{ $shipping_cost }}" type="hidden">
                                @if (session()->has('coupon'))
                                    @php
                                        $coupon_price = round($subtotal - $discount);
                                    @endphp

                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0">Coupon Discount({{ $coupon['percentage'] . '%' }})</h6>
                                        <span class="total-amount">(-) ₹{{ $discount }}</span>
                                    </div>
                                @endif
                               
                                @if($exitDiscount > 0)
                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                        <h6 class="mb-0 text-success">Surprise Offer</h6>
                                        <span class="total-amount text-success">(-) ₹{{ $exitDiscount }}</span>
                                    </div>

                                    @php
                                        $subtotal -= $exitDiscount;
                                    @endphp
                                @endif

                                <div class="d-flex justify-content-between align-items-center border-top pt-2">
                                    <h5 class="mb-0 fw-bold">Total</h5>
                                    <span
                                        class="total-amount fw-bold text-danger">₹{{ number_format($subtotal, 2) }}</span>
                                </div>
                                <span class="mt-4" style="font-size:13px">All the prices are inclusive of tax.</span>
                            </div>

                            <button type="submit" class="btn btn-danger w-100 mt-3 place-order-btn">
                                Place Order
                            </button>
                        </div>
                    </div>
                </div>
            </form>
            <!-- Change Address Modal -->
            <div class="modal fade" id="changeAddressModal" tabindex="-1" aria-labelledby="changeAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="changeAddressModalLabel">Select or Change Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <!-- Example: Loop through all saved addresses -->
                            @foreach ($addresses as $address)
                                <div class="border rounded-3 p-3 mb-2 d-flex justify-content-between align-items-start">
                                    <div>
                                        <strong>{{ $address->shipping_name }}</strong>
                                        @if ($address->is_default)
                                            <span class="badge bg-success ms-1">Default</span>
                                        @endif
                                        @if ($address->address_type)
                                            <span class="badge bg-primary">{{ strtoupper($address->address_type) }}
                                            </span>
                                        @endif
                                        <div class="text-muted small">
                                            {{ $address->shipping_address }},
                                            {{ $address->cityDetail->name ?? '' }},
                                            {{ $address->stateDetail->name ?? '' }},
                                            {{ $address->countryDetail->name ?? '' }},
                                            {{ $address->pincode ?? '' }},
                                        </div>
                                        @if ($address->shipping_email)
                                            <div class="text-muted small">Email: {{ $address->shipping_email }}
                                            </div>
                                        @endif
                                        @if ($address->shipping_phone)
                                            <div class="text-muted small">Phone: {{ $address->shipping_phone }}
                                            </div>
                                        @endif
                                    </div>
                                    <button type="button" class="btn-sm btn-success text-light select-address"
                                        data-id="{{ $address->id }}">
                                        Select
                                    </button>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add Address Modal -->
            <div class="modal fade" id="addAddressModal" tabindex="-1" aria-labelledby="addAddressModalLabel"
                aria-hidden="true">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-light">
                            <h5 class="modal-title" id="addAddressModalLabel">Add New Address</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <form action="{{ route('user.addNewAddress') }}" method="POST" class="p-3">
                            @csrf
                            <div class="modal-body">
                                <p class="text-muted small mb-3">
                                    <i class="bi bi-shield-check"></i> Your information is safe with us.
                                </p>

                                <!-- Address Type -->
                                <div class="mb-3">
                                    <label class="form-label d-block fw-semibold">Address Type</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="address_type"
                                                id="home" value="Home">
                                            <label class="form-check-label" for="home">Home</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="address_type"
                                                id="office" value="Office">
                                            <label class="form-check-label" for="office">Office</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="address_type"
                                                id="others" value="Others">
                                            <label class="form-check-label" for="others">Others</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Info -->
                                <div class="row g-3">
                                    <div class="col-lg-4">
                                        <label for="shipping_name" class="form-label">Full Name</label>
                                        <input type="text" class="form-control" id="shipping_name"
                                            name="shipping_name" placeholder="Enter full name" required>
                                        <div id="shipping_name_error" class="invalid-feedback d-block"></div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="shipping_email" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="shipping_email"
                                            name="shipping_email" placeholder="Enter email" required>
                                        <div id="shipping_email_error" class="invalid-feedback d-block"></div>
                                    </div>

                                    <div class="col-lg-4">
                                        <label for="shipping_phone" class="form-label">Phone</label>
                                        <input type="tel" class="form-control" id="shipping_phone"
                                            name="shipping_phone" placeholder="+91 8765***" required>
                                        <div id="shipping_phone_error" class="invalid-feedback d-block"></div>
                                    </div>
                                </div>

                                <!-- Address Info -->
                                <div class="row g-3 mt-2">
                                    <div class="col-lg-6">
                                        <label for="shipping_address" class="form-label">Address</label>
                                        <input type="text" class="form-control" id="shipping_address"
                                            name="shipping_address" placeholder="House no, street, etc." required>
                                        <div id="shipping_address_error" class="invalid-feedback d-block"></div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="country" class="form-label">Country</label>
                                        <select class="form-select" id="country" name="country" required>
                                            <option value="">Select Country</option>
                                            @foreach ($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        <div id="country_error" class="invalid-feedback d-block"></div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="state" class="form-label">State</label>
                                        <select class="form-select" id="state" name="state" required>
                                            <option value="">Select State</option>
                                        </select>
                                        <div id="state_error" class="invalid-feedback d-block"></div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="city" class="form-label">City</label>
                                        <select class="form-select" id="city" name="city" required>
                                            <option value="">Select City</option>
                                        </select>
                                        <div id="city_error" class="invalid-feedback d-block"></div>
                                    </div>

                                    <div class="col-lg-3">
                                        <label for="pincode" class="form-label">Pincode</label>
                                        <input type="number" class="form-control" id="pincode" name="pincode"
                                            placeholder="Pincode" required>
                                        <div id="pincode_error" class="invalid-feedback d-block"></div>
                                    </div>
                                </div>

                                <!-- Default Checkbox -->
                                <div class="form-check mt-3">
                                    <input type="checkbox" class="form-check-input" id="is_default" name="is_default">
                                    <label class="form-check-label" for="is_default">Set as default address</label>
                                </div>
                            </div>

                            <div class="modal-footer border-0">
                                <button type="button" class="btn-danger text-light"
                                    data-bs-dismiss="modal">Close</button>
                                <button type="submit" class="btn-success text-light">Save Address</button>
                            </div>
                        </form>

                    </div>
                </div>
            </div>

            <div class="modal fade" id="exitOfferModal" tabindex="-1">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Wait! Don’t leave 😲</h5>
                        </div>
                        <div class="modal-body text-center">
                            <p class="fw-bold">Why do you want to exit now?</p>
                            <p class="text-success fs-5">🎁 We have an ₹30 surprise offer for you!</p>
                        </div>
                        <div class="modal-footer text-center">
                            <button class="common btn common-btn1" data-bs-dismiss="modal">Exit</button>
                            <button class="common btn common-btn2" id="applyExitOffer">Apply Offer</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>

    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

    <script>
        function animateCounter(id, start, end, duration, milestones) {
            let obj = document.getElementById(id);
            if (!obj) return; // 🛡️ Fix 1: Stop if counter element doesn't exist

            let current = start;
            let range = end - start;
            if (range <= 0) {
                obj.textContent = end;
                return;
            }

            let increment = end > start ? 1 : -1;
            let stepTime = Math.abs(Math.floor(duration / range));
            let triggered = {};

            let timer = setInterval(() => {
                current += increment;
                
                // 🛡️ Fix 2: Safe textContent assignment
                if (obj) obj.textContent = current;

                // Dynamic progress bar
                let progressBar = document.getElementById("progressBar");
                if (progressBar && milestones && milestones.length > 0) {
                    let maxMilestone = Math.max(...milestones.map(m => m.amount));
                    let percentage = (current / maxMilestone) * 100;
                    progressBar.style.width = Math.min(percentage, 100) + "%";
                }

                // Loop through milestones dynamically
                if (milestones && Array.isArray(milestones)) {
                    milestones.forEach((m, index) => {
                        if (current === m.amount && !triggered[m.amount]) {
                            triggered[m.amount] = true;

                            let successPopup = document.getElementById("successPopup");
                            if (successPopup) {
                                successPopup.innerHTML = `🎉 Reached ${m.name}! 🎊`;
                                showSuccessPopup();
                            }
                            
                            launchConfetti();
                            if (index === milestones.length - 1) {
                                launchConfetti();
                            }
                        }
                    });
                }

                if (current === end) clearInterval(timer);

            }, stepTime);
        }

        function showSuccessPopup() {
            const popup = document.getElementById("successPopup");
            if (popup) { // 🛡️ Fix 3: Null check added
                popup.classList.add("show");
                setTimeout(() => popup.classList.remove("show"), 3000);
            }
        }

        function launchConfetti() {
            const section = document.querySelector(".milestone-box-new");
            if (!section) return; // 🛡️ Fix 4: Stop if confetti container doesn't exist

            for (let i = 0; i < 80; i++) {
                let confetti = document.createElement("div");
                confetti.classList.add("confetti");

                confetti.style.left = Math.random() * 100 + "vw";
                confetti.style.backgroundColor = "hsl(" + Math.random() * 360 + ", 100%, 50%)";
                confetti.style.animationDuration = Math.random() * 2 + 2 + "s";

                section.appendChild(confetti);

                setTimeout(() => confetti.remove(), 3000);
            }
        }

        window.onload = () => {
            let subTotal = parseInt("{{ $sub_total ?? 0 }}") || 0;
            let milestonesData = @json($milestones ?? []);

            // Only run counter if target element exists in HTML
            if (document.getElementById("counter") && subTotal > 0) {
                animateCounter(
                    "counter",
                    0,
                    subTotal,
                    3000,
                    milestonesData
                );
            }
        };

        $('#place-order').validate({
            rules: {
                select_address_id: {
                    required: true,
                    number: true
                },
                courier_name: {
                    required: true
                },
                payment_method: {
                    required: true,
                }
            },
            messages: {
                select_address_id: "Please select an address.",
                courier_name: "Please select a courier."
            },
            highlight: function(element) {
                if ($(element).attr('name') === 'courier_name') {
                    $('.courier-option').addClass('border border-danger rounded');
                } else {
                    $(element).addClass('is-invalid');
                }
            },
            unhighlight: function(element) {
                if ($(element).attr('name') === 'courier_name') {
                    $('.courier-option').removeClass('border border-danger rounded');
                } else {
                    $(element).removeClass('is-invalid');
                }
            },
            errorPlacement: function(error, element) {
                if (element.attr('name') === 'courier_name') {
                    $('#courier_name-error').html(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#country').on('change', function() {
                var countryID = $(this).val();
                if (countryID) {
                    $.ajax({
                        url: "{{ route('getStates') }}",
                        type: "POST",
                        data: {
                            country_id: countryID,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#state').empty().append(
                                '<option value="">Select State</option>');
                            $('#city').empty().append('<option value="">Select City</option>');
                            $.each(data, function(key, value) {
                                $('#state').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#state').empty().append('<option value="">Select State</option>');
                    $('#city').empty().append('<option value="">Select City</option>');
                }
            });

            $('#state').on('change', function() {
                var stateID = $(this).val();
                if (stateID) {
                    $.ajax({
                        url: "{{ route('getCities') }}",
                        type: "POST",
                        data: {
                            state_id: stateID,
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(data) {
                            $('#city').empty().append('<option value="">Select City</option>');
                            $.each(data, function(key, value) {
                                $('#city').append('<option value="' + value.id + '">' +
                                    value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#city').empty().append('<option value="">Select City</option>');
                }
            });

            $('.apply-btn').on('click', function() {
                var coupon = $('.coupon-input').val();

                if (coupon === '') {
                    alert('Please enter a coupon code');
                    return;
                }

                $.ajax({
                    url: "{{ route('apply.coupon') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        coupon: coupon
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        } else {
                            $('.coupon-error').removeClass('d-none');
                        }
                    },
                    error: function() {
                        alert('Something went wrong. Try again!');
                    }
                });
            });
            $('.removed-btn').on('click', function() {


                $.ajax({
                    url: "{{ route('remove.coupon') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                    },
                    success: function(response) {
                        if (response.status === 'success') {
                            location.reload();
                        } else {
                            alert(response.message);
                        }
                    },
                    error: function() {
                        alert('Something went wrong. Try again!');
                    }
                });
            });
        });
        $('.select-address').on('click', function() {
            var address_id = $(this).data('id');
            $('#changeAddressModal').modal('hide');
            if (address_id) {
                $.ajax({
                    url: '{{ route('set.primary') }}',
                    method: 'POST',
                    data: {
                        address_id: address_id,
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        if (response.success) {
                            location.reload();
                        } else {
                            alert('Failed to update address.');
                        }
                    },
                    error: function() {
                        alert('Something went wrong. Please try again.');
                    }
                });
            }
        });

        $('.payment_method').on('click', function() {
            var pay_type = $(this).val();
            var couriers = $('#stCourier, #edcCourier, #professionalCourier, #Delhivery');

            if (pay_type === "cod") {
                couriers.prop('disabled', true);
                $('#indiaPost').prop('checked', true);
            } else {
                couriers.prop('disabled', false);
                $('#indiaPost').prop('checked', false);
            }
        });
        $('#place-order').on('submit', function () {
            exitShown = true;
        });
    </script>
    <script>
        let exitShown = false;
        let isInitialLoad = true;
        let exitOfferApplied = {{ session()->has('exit_offer') ? 'true' : 'false' }};

        // Push history AFTER page fully loads
        window.addEventListener('load', function () {
            history.pushState({ checkout: true }, "", location.href);
            isInitialLoad = false;
        });

        // Detect BACK button only
        window.addEventListener('popstate', function (event) {
            if (
                !isInitialLoad &&
                !exitShown &&
                !exitOfferApplied
            ) {
                exitShown = true;

                // Show popup
                $('#exitOfferModal').modal('show');

                // Stop actual navigation
                history.pushState({ checkout: true }, "", location.href);
            }
        });

        // Apply exit offer
        $('#applyExitOffer').on('click', function () {
            $.ajax({
                url: "{{ route('apply.exit.offer') }}",
                type: "POST",
                data: {
                    _token: "{{ csrf_token() }}"
                },
                success: function () {
                    location.reload();
                }
            });
        });
    </script>
@endsection