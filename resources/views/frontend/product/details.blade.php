@extends('frontend.layouts.app')
@section('content')
    <style>
        .wishlist-section .btn {
            transition: all 0.25s ease-in-out;
        }

        .wishlist-section .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 8px rgba(0, 0, 0, 0.1);
        }

        /* Variant Container */
        .variant_picker {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            margin-top: 10px;
        }

        .variant_picker input[type="radio"] {
            position: absolute;
            opacity: 0;
            width: 0;
            height: 0;
        }

        .variant_label_btn {
            display: inline-block;
            padding: 10px 24px;
            background-color: #f0fdf4;
            color: #000000;
            font-size: 16px;
            font-weight: 500;
            border-radius: 12px;
            border: 1px solid transparent;
            cursor: pointer;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.08);
            transition: all 0.2s ease-in-out;
        }

        /* Hover state */
        .variant_label_btn:hover {
            transform: translateY(-1px);
            box-shadow: 0px 6px 8px rgba(0, 0, 0, 0.12);
        }

        .variant_picker input[type="radio"]:checked+.variant_label_btn {
            background-color: #000000;
            color: #ffffff;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
    </style>

    <section class="container my-5">
        <div class="product-container">
            <div class="row">
                <!-- Product Images -->
                <div class="col-lg-6">
                    <div class="image-section text-center position-relative">
                        <!-- Main Image with Zoom -->
                        <img src="{{ asset($productDetails->product_img ?? '') }}" alt="Main Product Image"
                            class="main-image img-fluid mb-3" id="mainImage">

                        <!-- Zoomed view -->
                        <div id="zoomResult" class="zoom-result"></div>


                    </div>
                    <!-- Thumbnails + Arrows -->
                    <div class="thumbnail-container d-flex justify-content-center align-items-center gap-2 mb-5">
                        <button class="btn btn-outline-secondary btn-sm" id="prevBtn">
                            <i class="fas fa-chevron-left"></i>
                        </button>

                        @foreach ($productImages as $key => $image)
                            <img src="{{ asset($image->path) }}"
                                class="thumbnail img-thumbnail {{ $key === 0 ? 'active' : '' }}">
                        @endforeach

                        <button class="btn btn-outline-secondary btn-sm" id="nextBtn">
                            <i class="fas fa-chevron-right"></i>
                        </button>
                    </div>
                </div>

                <!-- Product Details -->
                <div class="col-lg-6">
                    <div class="product-details">
                        <!-- Rating -->
                        @php
                            $averageRating = round($productDetails->reviews()->avg('star_count'), 1);
                            $ratingCount = $productDetails->reviews()->count();
                        @endphp

                        <div class="rating-section mb-3">
                            <span class="star-rating">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= floor($averageRating))
                                        <i class="fas fa-star text-warning"></i>
                                    @elseif ($i - $averageRating < 1)
                                        <i class="fas fa-star-half-alt text-warning"></i>
                                    @else
                                        <i class="far fa-star text-warning"></i>
                                    @endif
                                @endfor
                            </span>
                            <span class="rating-text">
                                {{ $averageRating ?? '0' }} Star Rating ({{ $ratingCount }} User
                                Feedback{{ $ratingCount > 1 ? 's' : '' }})
                            </span>
                        </div>

                        <!-- Product Title -->
                        <h1 class="product-title">{{ $productDetails->product_name }}</h1>

                        <!-- Product Meta Info -->
                        <div class="product-meta">
                            <div class="col-12 col-lg-5">
                                <div class="meta-item">
                                    @if ($productDetails->sku)
                                        <span class="meta-label">SKU:</span>
                                        <span class="meta-value">{{ $productDetails->sku }}</span>
                                    @endif
                                </div>
                                <div class="meta-item">
                                    @if ($productDetails->no_of_pages)
                                        <span class="meta-label">No of Pages:</span>
                                        <span class="meta-value">{{ $productDetails->no_of_pages }} pages</span>
                                    @endif
                                </div>
                                <div class="meta-item">
                                    <span class="meta-label">Category:</span>
                                    <span class="meta-value"><a href="#"
                                            class="brand-link">{{ $productDetails->category->name ?? '' }}</a></span>
                                </div>
                                {{-- <div class="meta-item">
                                    <span class="meta-label">Brand:</span>
                                    <span class="meta-value"><a href="#" class="brand-link">Apple</a></span>
                                </div> --}}
                            </div>
                            <div class="col-12 col-lg-5">
                                <div class="meta-item">
                                    <span class="meta-label">Availability:</span>
                                    @if ($productDetails->quantity >= 4)
                                        <span class="meta-value text-success">In Stock</span>
                                    @elseif ($productDetails->quantity >= 1)
                                        <span class="meta-value text-warning">Only {{ $productDetails->quantity }}
                                            left</span>
                                    @else
                                        <span class="meta-value text-danger">Out of Stock</span>
                                    @endif
                                </div>
                            </div>

                        </div>

                        <form action="{{ route('buy.now') }}" method="POST" id="buyNowForm">
                            @csrf
                            <!-- Price Section -->
                            <div class="price-section">
                                <span class="current-price">₹{{ $productDetails->offer_price }}</span>
                                <span class="original-price">₹{{ $productDetails->orginal_rate }}</span>
                                @if ($productDetails->discount)
                                    <span class="offer-badge">{{ $productDetails->discount }}% OFF</span>
                                @endif
                                <p class="detail-para">Tax Included, <a href="{{ route('product.proceed_to_checkout') }}"
                                        style="text-decoration: underline">Shipping</a> Calculated at Checkout.</p>
                                <style>
                                    .color_picker input {
                                        display: none;
                                    }

                                    .color_picker label {
                                        cursor: pointer;
                                        border: 1px solid #b5b5b5;
                                        border-radius: 10px;
                                        display: inline-block;
                                        width: 25px;
                                        height: 25px;
                                        margin-right: 4px;
                                    }

                                    .color_picker input:checked+label span {
                                        border: 2px solid rgb(12, 0, 0);
                                        border-radius: 6px;
                                        display: inline-block;
                                        width: 25px;
                                        height: 25px;
                                    }

                                    .product_detail_inner .product_detail_content .color_picker label:hover span {
                                        outline: unset;
                                        outline-offset: unset;
                                    }
                                </style>

                                @php
                                    $firstColor = isset($colors) && $colors->isNotEmpty() ? $colors->first() : null;
                                    $selectedColor =
                                        request('color') ??
                                        ($firstColor ? $firstColor->pivot_id ?? ($firstColor->id ?? null) : null);
                                    $isVariantType = false;

                                    if (isset($productDetails) && $productDetails->option_type === 'variant') {
                                        $isVariantType = true;
                                    } elseif ($firstColor && is_null($firstColor->color_id)) {
                                        $isVariantType = true;
                                    }
                                @endphp

                                @if (isset($colors) && $colors->isNotEmpty())
                                    <div class="mt-4" style="display: block !important; visibility: visible !important;">

                                        {{-- Header Title Toggle --}}
                                        @if ($isVariantType)
                                            <h5 class="detail_subtitle"
                                                style="display: block !important; color: #000 !important; font-weight: bold; margin-bottom: 10px;">
                                                SELECT TYPE</h5>
                                            <div class="variant_picker_clean d-flex flex-wrap gap-2"
                                                style="display: flex !important; flex-wrap: wrap !important; gap: 10px !important;">
                                            @else
                                                <h5 class="detail_subtitle">SELECT COLOR</h5>
                                                <div class="color_picker">
                                        @endif

                                        @foreach ($colors as $index => $color)
                                            @php
                                                // Fallback wrapper to guarantee an ID exists for standard objects
                                                $fallbackId = $color->pivot_id ?? ($color->id ?? $index);
                                            @endphp

                                            {{-- Variant (No Color) Block - Radio button removed --}}
                                            @if ($isVariantType || is_null($color->color_id))
                                                <div class="variant_btn_wrapper variant-clickable-btn"
                                                    data-value="{{ $fallbackId }}" data-qty="{{ $color->qty ?? 1 }}"
                                                    onclick="selectVariantElement(this)"
                                                    style="cursor: pointer; padding: 10px 20px; border: 2px solid {{ $selectedColor == $fallbackId ? '#ff5722' : '#ddd' }}; display: inline-flex !important; align-items: center; justify-content: center; border-radius: 5px; background: {{ $selectedColor == $fallbackId ? '#fff3f0' : '#fff' }}; font-weight: 500; color: #000 !important;">

                                                    {{ $color->variant_name ?? 'Default Variant' }}
                                                </div>
                                            @else
                                                {{-- Color Selection Block - Keeps radio for native color picking --}}
                                                <input type="radio" name="color" id="color-{{ $fallbackId }}"
                                                    value="{{ $fallbackId }}" data-qty="{{ $color->qty ?? 1 }}"
                                                    {{ $selectedColor == $fallbackId ? 'checked' : '' }}
                                                    onchange="selectColor(this)" required>

                                                <label for="color-{{ $fallbackId }}"
                                                    title="{{ $color->color_title ?? ($color->variant_name ?? '') }}"
                                                    style="background-color: {{ $color->color_code ?? '#ccc' }}; cursor: pointer;">
                                                    <span
                                                        style="background-color: {{ $color->color_code ?? '#ccc' }}"></span>
                                                </label>
                                            @endif
                                        @endforeach

                                        {{-- Hidden Input to hold the selected ID for Form submissions or Buy Now --}}
                                        <input type="hidden" id="selectedColorId" name="selected_color_id"
                                            value="{{ $selectedColor }}">

                                    </div>
                            </div>
                            @endif
                    </div>
                    


                        <input type="hidden" name="product_id" value="{{ $productDetails->id }}">

                        <div class="d-flex justify-content-between col-col">
                            <!-- Quantity Section -->
                            <div class="quantity-section">
                                <div class="quantity-control">
                                    <button type="button" class="quantity-btn" id="decreaseBtn">
                                        <i class="fas fa-minus"></i>
                                    </button>
                                    @if ($colors->isNotEmpty())
                                        <input type="text" class="quantity-input" id="quantityInput" name="quantity"
                                            value="1" min="1" inputmode="numeric">
                                    @else
                                        <input type="text" class="quantity-input" id="quantityInput" name="quantity"
                                            value="1" maxlength="2" max="{{ $productDetails->quantity }}"
                                            min="1" inputmode="numeric">
                                    @endif
                                    <button type="button" class="quantity-btn" id="increaseBtn">
                                        <i class="fas fa-plus"></i></button>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                @if ($productDetails->quantity > 0)
                                    @auth
                                        @if ($productDetails->cart && $productDetails->cart->product_id == $productDetails->id)
                                            <!-- Already in cart -->
                                            <a href="{{ route('show.cart.table') }}" class="btn-add-cart"
                                                style="text-decoration: none">
                                                <i class="fas fa-shopping-cart"></i>
                                                GO TO CART
                                            </a>
                                        @else
                                            <input type="hidden" id="selectedColorId"
                                                value="{{ $colors->first()->pivot->id ?? '' }}">
                                            <!-- Not in cart -->
                                            <a href="{{ route('addto.cart', $productDetails->id) }}" class="btn-add-cart"
                                                id="addToCartBtn" style="text-decoration: none"
                                                onclick="return appendColorToCartUrl(this)">
                                                <i class="fas fa-shopping-cart"></i>
                                                ADD TO CART
                                            </a>
                                        @endif
                                    @else
                                        <a href="{{ route('user.login') }}" class="btn-add-cart" style="text-decoration: none">
                                            <i class="fas fa-user"></i> LOGIN TO BUY
                                        </a>
                                    @endauth

                                    <form action="{{ route('buy.now') }}" method="POST" class="d-inline">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $productDetails->id }}">
                                        <input type="hidden" name="quantity" id="buyNowQuantity" value="1">
                                        <button type="submit" class="btn-buy-now" id="buyNowBtn">BUY NOW</button>
                                    </form>
                                @else
                                    <button type="button" class="btn-add-cart" disabled>OUT OF STOCK</button>
                                @endif
                            </div>

                        </div>
                    </form>


                    <!-- Wishlist and Share -->
                    <div class="wishlist-share">
                        <div class="wishlist-section">
                            @if ($productDetails->isWishlist)
                                <a href="{{ route('show.wishlist.list') }}"
                                    class="btn btn-outline-secondary btn-sm d-inline-flex align-items-center gap-2 px-3 py-2 wishlist-btn"
                                    title="Remove from Wishlist"
                                    style="border-radius: 50px; font-weight: 500; white-space: nowrap;">
                                    <i class="bi bi-heart-fill text-danger"></i>
                                    <span class="ms-4 text-dark">Remove from Wishlist</span>
                                </a>
                            @else
                                @auth
                                    <a href="javascript:void(0)"
                                        class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-2 px-3 py-2 wishlist-btn"
                                        data-id="{{ $productDetails->id }}"
                                        data-url="{{ route('addto.wishlist', $productDetails->id) }}"
                                        data-login="{{ route('user.login') }}" title="Add to Wishlist"
                                        style="border-radius: 50px; font-weight: 500; white-space: nowrap;">
                                        <i class="bi bi-heart"></i>
                                        <span class="ms-4">Add to Wishlist</span>
                                    </a>
                                @else
                                    <a href="{{ route('user.login') }}?type=guest"
                                        class="btn btn-outline-danger btn-sm d-inline-flex align-items-center gap-2 px-3 py-2"
                                        title="Add to Wishlist"
                                        style="border-radius: 50px; font-weight: 500; white-space: nowrap;">
                                        <i class="bi bi-heart"></i>
                                        <span class="ms-4">Add to Wishlist</span>
                                    </a>
                                @endauth
                            @endif
                        </div>

                        {{-- Share Buttons --}}
                        <div class="d-flex align-items-center mt-3">
                            <span class="me-3">Share product:</span>
                            <div class="share-buttons d-flex gap-2">

                                {{-- Copy Link --}}
                                <button
                                    onclick="copyUrl(this, '{{ route('product.details.show', $productDetails->id) }}')"
                                    title="Copy product link">
                                    <i class="fa fa-copy"></i>
                                </button>

                                {{-- WhatsApp --}}
                                <button class="share-btn whatsapp"
                                    onclick="shareOnWhatsApp('{{ route('product.details.show', $productDetails->id) }}', '{{ $productDetails->product_name }}')">
                                    <i class="fab fa-whatsapp"></i>
                                </button>

                                {{-- Instagram --}}
                                <button class="instagram"
                                    onclick="shareOnInstagram('{{ route('product.details.show', $productDetails->id) }}')">
                                    <i class="fa-brands fa-instagram"></i>
                                </button>

                                {{-- Facebook --}}
                                <button class="facebook"
                                    onclick="shareOnFacebook('{{ route('product.details.show', $productDetails->id) }}')">
                                    <i class="fab fa-facebook-f"></i>
                                </button>

                            </div>
                        </div>
                    </div>

                    <script>
                        function copyUrl(el, url) {
                            const originalTitle = el.getAttribute('title') || 'Copy product link';

                            if (navigator.clipboard && window.isSecureContext) {
                                navigator.clipboard.writeText(url).then(() => {
                                    showCopied(el, originalTitle);
                                });
                            } else {
                                // Fallback
                                const input = document.createElement('input');
                                input.value = url;
                                document.body.appendChild(input);
                                input.select();
                                document.execCommand('copy');
                                document.body.removeChild(input);
                                showCopied(el, originalTitle);
                            }
                        }

                        function showCopied(el, originalTitle) {
                            el.setAttribute('title', '✅ Product link copied!');

                            setTimeout(() => {
                                el.setAttribute('title', originalTitle);
                            }, 2000);
                        }

                        function shareOnWhatsApp(url, title) {
                            const whatsappUrl = `https://api.whatsapp.com/send?text=${encodeURIComponent(title + ' - ' + url)}`;
                            window.open(whatsappUrl, '_blank');
                        }

                        function shareOnInstagram(url) {
                            navigator.clipboard.writeText(url).then(() => {
                                window.open('https://www.instagram.com/', '_blank');
                            });
                        }

                        function shareOnFacebook(url) {
                            const fbUrl = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(url)}`;
                            window.open(fbUrl, '_blank', 'width=600,height=400');
                        }
                    </script>

                    <!-- Payment Security -->
                    <div class="payment-security">
                        <div class="security-title">
                            <i class="fas fa-shield-alt me-2"></i>
                            100% Guarantee Safe Checkout
                        </div>
                        <div class="payment-methods">
                            <div class="payment-card visa"><img src="{{ asset('frontend/img/maestro.png') }}"
                                    alt=""></div>
                            <div class="payment-card mastercard"><img src="{{ asset('frontend/img/visa-electron.png') }}"
                                    alt=""></div>
                            <div class="payment-card amex"><img src="{{ asset('frontend/img/visa.png') }}"
                                    alt=""></div>
                            <div class="payment-card paypal"><img src="{{ asset('frontend/img/paypal.png') }}"
                                    alt=""></div>
                            <div class="payment-card discover"><img src="{{ asset('frontend/img/american.png') }}"
                                    alt=""></div>
                            <div class="payment-card"><img src="{{ asset('frontend/img/master.png') }}" alt="">
                            </div>
                            <div class="payment-card"><img src="{{ asset('frontend/img/delta.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>
    </section>
    {{-- description --}}
    <section>
        <div class="container py-5">
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <!-- Nav tabs -->
                    <ul class="nav nav-tabs" id="productTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="description-tab" data-bs-toggle="tab"
                                data-bs-target="#description" type="button" role="tab" aria-controls="description"
                                aria-selected="true">
                                Description
                            </button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="reviews-tab" data-bs-toggle="tab" data-bs-target="#reviews"
                                type="button" role="tab" aria-controls="reviews" aria-selected="false">
                                Reviews
                            </button>
                        </li>
                    </ul>

                    <!-- Tab panes -->
                    <div class="tab-content" id="productTabsContent">
                        <div class="tab-pane fade show active" id="description" role="tabpanel"
                            aria-labelledby="description-tab">
                            <p>{!! $productDetails->description ?? '' !!}</p>
                        </div>

                        <div class="tab-pane fade" id="reviews" role="tabpanel" aria-labelledby="reviews-tab">
                            <p>Customer reviews will be displayed here. This section would typically contain user ratings,
                                comments, and feedback about the product.</p>

                            <p>You can add review components, star ratings, user avatars, and review text in this section.
                                The content structure would be similar to the description tab but focused on customer
                                feedback.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {{-- Best Seller Products --}}
    @if ($related_products->isNotEmpty())
        <section class="container py-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h4 mb-0 fs-1">Related Products</h2>
                <a href="#" class="d-inline-flex align-items-center text-decoration-none fw-medium text-dark">
                    View all Deals
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>

            <!-- Responsive grid: 2 cols on xs, 3 on md, 4 on lg, 5 on xl+ -->
            <div class="row row-cols-2 row-cols-md-2 row-cols-lg-4 row-cols-xl-5">
                <!-- CARD -->
                @foreach ($related_products as $seller)
                    <div class="col">
                        <div class="card product-card1">
                            <!-- <span class="badge text-dark discount-badge">25% OFF</span> -->
                            <div class="ratio ratio-4x3 position-relative">
                                <img src="{{ asset($seller->product_img) }}" class="main-img"
                                    alt="{{ $seller->product_name }}" loading="lazy">
                                <div class="product-actions">
                                    <a href="#" class="card-btun btn-sm action" title="Wishlist"
                                        aria-label="Add to wishlist">
                                        <i class="bi bi-heart"></i>
                                    </a>
                                    <a href="{{ route('product.details.show', $seller->id) }}"
                                        class="card-btun btn-sm action" title="Quick view" aria-label="Quick view">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="#" class="card-btun btn-sm action" title="Add to cart"
                                        aria-label="Add to cart">
                                        <i class="bi bi-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <p class="card-title small text-truncate-2 mb-1">{{ $seller->product_name }}</p>
                                <div class="price small">
                                    <span class="text-danger fw-semibold">{{ $seller->offer_price }}</span>
                                    <span
                                        class="text-muted text-decoration-line-through">{{ $seller->orginal_rate }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                <!-- Add as many .col as needed... -->
            </div>
        </section>
    @endif

    {{-- Best Seller Products --}}
@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script>
    // Global variable to keep track of allowed max stock quantity per color
    let maxQty = 1;

    // Triggered inline when a color radio option changes
    function selectColor(el) {
        document.getElementById('selectedColorId').value = el.value;
        maxQty = parseInt(el.dataset.qty) || 1;

        const qtyInput = document.getElementById('quantityInput');
        qtyInput.setAttribute('max', maxQty);

        // If current value exceeds the newly selected color's stock, snap it down
        if (parseInt(qtyInput.value) > maxQty) {
            qtyInput.value = maxQty;
            $("#buyNowQuantity").val(maxQty);
        }
    }

    // Dynamic URL builder for standard Cart additions
    // function appendColorToCartUrl(el) {
    //     // const colorId = document.getElementById('selectedColorId').value;

    //     // if (!colorId) {
    //     //     alert('Please select a color');
    //     //     return false;
    //     // }

    //     const baseUrl = el.getAttribute('href');
    //     // Prevent stacking query params if clicked multiple times
    //     const cleanUrl = baseUrl.split('?')[0];
    //     el.setAttribute('href', cleanUrl + '?color_id=' + colorId);
    //     return true;
    // }
    function appendColorToCartUrl(el) {
        const colorId = document.getElementById('selectedColorId').value;
        const qtyInput = document.getElementById('quantityInput');
        const quantity = qtyInput ? qtyInput.value : 1;

        // Custom validation check (optional, clean check if color is not selected)
        // if (!colorId) {
        //     alert('Please select a option');
        //     return false;
        // }

        const baseUrl = el.getAttribute('href');
        // URL split check to prevent stacking query params if clicked multiple times
        const cleanUrl = baseUrl.split('?')[0];
        
        // Dynamic-ah URL-il color_id matrum quantity rendaium append seigirom!
        el.setAttribute('href', cleanUrl + '?color_id=' + colorId + '&quantity=' + quantity);
        return true;
    }

    // Unified DOM Events
    $(document).ready(function() {
        let $input = $("#quantityInput");
        let $buyNowInput = $("#buyNowQuantity");
        let $thumbnails = $(".thumbnail");
        let $mainImage = $("#mainImage");
        let currentIndex = 0;

        /* --- QUANTITY HANDLERS --- */

        $("#decreaseBtn").on("click", function() {
            let currentValue = parseInt($input.val()) || 1;
            let min = parseInt($input.attr("min")) || 1;

            if (currentValue > min) {
                let newVal = currentValue - 1;
                $input.val(newVal);
                $buyNowInput.val(newVal);
            }
        });

        $("#increaseBtn").on("click", function() {
            let currentValue = parseInt($input.val()) || 1;
            // Respects dynamic max attribute if color selected or global maxQty fallback
            let currentMax = parseInt($input.attr("max")) || maxQty; 

            if (currentValue < currentMax) {
                let newVal = currentValue + 1;
                $input.val(newVal);
                $buyNowInput.val(newVal);
            }
        });

        $input.on("input", function() {
            let val = parseInt($(this).val()) || 1;
            let min = parseInt($(this).attr("min")) || 1;

            if (val > maxQty) val = maxQty;
            if (val < min) val = min;

            $(this).val(val);
            $buyNowInput.val(val);
        });

        /* --- GALLERY IMAGE CAROUSEL HANDLERS --- */

        // Thumbnail Click Handler
        $thumbnails.on("click", function() {
            $thumbnails.removeClass("active border-primary");
            $(this).addClass("active border-primary");

            let newSrc = $(this).attr("src");
            $mainImage.attr("src", newSrc);

            currentIndex = $thumbnails.index(this);
        });

        // Previous Button Click
        $("#prevBtn").on("click", function() {
            if ($thumbnails.length === 0) return;
            currentIndex = (currentIndex - 1 + $thumbnails.length) % $thumbnails.length;
            $thumbnails.eq(currentIndex).trigger("click");
        });

        // Next Button Click
        $("#nextBtn").on("click", function() {
            if ($thumbnails.length === 0) return;
            currentIndex = (currentIndex + 1) % $thumbnails.length;
            $thumbnails.eq(currentIndex).trigger("click");
        });

        /* --- INITIALIZATION ON LOAD --- */

        // Initialize first selected color attributes if predefined HTML checked attribute exists
        const checkedColor = document.querySelector('input[name="color"]:checked');
        if (checkedColor) {
            selectColor(checkedColor);
        }

        // Initialize gallery with the first thumbnail 
        if ($thumbnails.length > 0) {
            $thumbnails.first().trigger("click");
        }
    });

    function selectVariantElement(el) {
        $('.variant-clickable-btn').css({
            'border': '2px solid #ddd',
            'background': '#fff'
        });
        $(el).css({
            'border': '2px solid #ff5722',
            'background': '#fff3f0'
        });

        const variantId = $(el).data('value');
        document.getElementById('selectedColorId').value = variantId;

        maxQty = parseInt($(el).data('qty')) || 1;
        const qtyInput = document.getElementById('quantityInput');
        if (qtyInput) {
            qtyInput.setAttribute('max', maxQty);
            if (parseInt(qtyInput.value) > maxQty) {
                qtyInput.value = maxQty;
            }
        }
    }
</script>
<script src="{{ asset('frontend/js/product-detail.js') }}"></script>
