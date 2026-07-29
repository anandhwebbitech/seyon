@extends('frontend.layouts.app')
@section('content')
    <style>
        .product-card1 {
            width: 100%;
            position: relative;
            overflow: hidden;
            height: 100% !important;
        }

        .image-box {
            display: block;
            width: 100%;
            height: 100%;
            /* position: relative; */
            overflow: hidden;
        }

        .image-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            position: absolute;
            top: 0;
            left: 0;
            transition: .4s ease-in-out;
        }

        /* Hide hover image initially */
        .hover-img {
            opacity: 0;
            transform: scale(1.05);
        }

        /* Show hover image on hover */
        .image-box:hover .hover-img {
            opacity: 1;
            transform: scale(1);
        }

        /* Hide main image on hover */
        .image-box:hover .main-img {
            opacity: 0;
            transform: scale(1.05);
        }

        /* Preloader wrapper */
        #preloader {
            position: fixed;
            inset: 0;
            background: #fff;
            z-index: 99999;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        /* Ripple animation (your existing design-safe loader) */
        .lds-ripple {
            position: relative;
            width: 80px;
            height: 80px;
        }

        .lds-ripple div {
            position: absolute;
            border: 4px solid #f71517;
            opacity: 1;
            border-radius: 50%;
            animation: lds-ripple 1.5s cubic-bezier(0, 0.2, 0.8, 1) infinite;
        }

        .lds-ripple div:nth-child(2) {
            animation-delay: -0.75s;
        }

        @keyframes lds-ripple {
            0% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 0;
            }

            4.9% {
                opacity: 0;
            }

            5% {
                top: 36px;
                left: 36px;
                width: 0;
                height: 0;
                opacity: 1;
            }

            100% {
                top: 0;
                left: 0;
                width: 72px;
                height: 72px;
                opacity: 0;
            }
        }
        .hero-banner {
            position: relative;
            height: 520px;
            background-size: cover;
            background-position: center;
            display: flex;
            align-items: center;
        }

        .hero-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(
                90deg,
                rgba(0,0,0,0.65) 0%,
                rgba(0,0,0,0.35) 50%,
                rgba(0,0,0,0.1) 100%
            );
        }

        
        .hero-content {
            position: relative;
            max-width: 520px;
            margin: 0 auto;  /* 🔥 centers block */
            text-align: center;
            color: white;
        }

        .hero-title {
            font-size: 42px;
            font-weight: 700;
            margin-bottom: 10px;
            color: white;
        }

        .hero-text {
            font-size: 18px;
            margin-bottom: 20px;
        }
        .hero-text {
            color: #eeeef0 !important;
        }

        .hero-cta {
            display: inline-block;
            /* padding: 12px 28px; */
            background: #ff6a00;
            color: #fff;
            font-weight: 600;
            border-radius: 30px;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .hero-cta:hover {
            background: #e85d00;
        }
        .hero-cta {
            margin-top: 20px;
            display: inline-block;
        }
        .new-price-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            border: 1px solid #eee;
            background: #fff;
        }

        .new-price-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.1) !important;
        }

        .new-price-tag {
            color: #333;
            font-size: 0.95rem;
        }
        .input-group{
            margin: 15px 0;
        }
    </style>

    <!-- Style css -->

    {{-- <link href="<?php echo url(''); ?>/css/style.css" rel="stylesheet"> --}}



    {{-- Bootstrap --}}

    <script>
        window.addEventListener('load', function() {
            const preloader = document.getElementById('preloader');
            if (preloader) {
                preloader.style.opacity = '0';
                preloader.style.transition = 'opacity 0.4s ease';

                setTimeout(() => {
                    preloader.style.display = 'none';
                    document.body.style.overflow = 'auto';
                }, 400);
            }
        });
    </script>

    {{-- <div id="preloader">
        <div class="lds-ripple">
            <div></div>
            <div></div>
        </div>
    </div> --}}
    <section class="">
        <div id="kidsHero" class="carousel slide hero-wrap" data-bs-ride="carousel" data-bs-interval="3000"
            data-bs-touch="true">

            <div class="carousel-inner">
                <!-- Slide 1 -->
                @php
                    $sliders = \App\Models\BannerImages::get();
                @endphp
                @if ($sliders->isNotEmpty())
                    @foreach ($sliders as $slider)
                        <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                            <div class="hero-banner"
                                style="background-image: url('{{ asset($slider->image) }}')">

                                <div class="hero-overlay"></div>

                                <div class="container">
                                    <div class="hero-content">
                                        <h2 class="hero-title">{{ $slider->title }}</h2>
                                        <p class="hero-text">{{ $slider->description }}</p>

                                        @if($slider->banner_link)
                                            <a href="{{ $slider->banner_link }}" class="hero-cta">
                                                Shop Now
                                            </a>
                                        @endif
                                    </div>
                                </div>

                            </div>
                        </div>

                    @endforeach
                @endif
            </div>

            <!-- Arrows -->
            <button class="carousel-control-prev hero-prev" type="button" data-bs-target="#kidsHero" data-bs-slide="prev">
                <span class="hero-ctrl" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16"
                        class="hero-chevron">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M10.854 1.646a.5.5 0 0 1 0 .708L6.207 7l4.647 4.646a.5.5 0 0 1-.708.708l-5-5a.5.5 0 0 1 0-.708l5-5a.5.5 0 0 1 .708 0z" />
                    </svg>
                </span>
            </button>

            <button class="carousel-control-next hero-next" type="button" data-bs-target="#kidsHero" data-bs-slide="next">
                <span class="hero-ctrl" aria-hidden="true">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16"
                        class="hero-chevron">
                        <path fill="currentColor" fill-rule="evenodd"
                            d="M5.146 1.646a.5.5 0 0 1 .708 0l5 5a.5.5 0 0 1 0 .708l-5 5a.5.5 0 0 1-.708-.708L9.793 7 5.146 2.354a.5.5 0 0 1 0-.708z" />
                    </svg>
                </span>
            </button>
        </div>
    </section>

    <!-- cata brows -->
    <section class="categories py-5">
        <div class="container">
            <div class="row align-items-center">
                @php
                    $colors = ['red', 'yellow', 'green', 'blue'];
                @endphp

                <!-- Left Column -->
                <div class="col-12 col-md-3 mb-4 mb-md-0">
                    <h5 class="text-uppercase fw-semibold text-muted">Categories</h5>
                    <h2 class="fs-1 fw-bold mb-4">Browsing Top Categories</h2>

                    <!-- Swiper Controls -->
                    <div class="d-flex gap-3">
                        <button class="btn btn-outline-dark rounded-circle swiper-prev">
                            &#10094;
                        </button>
                        <button class="btn btn-outline-dark rounded-circle swiper-next">
                            &#10095;
                        </button>
                    </div>
                </div>

                <!-- Right Column (Swiper Slider) -->
                <div class="col-12 col-md-9">
                    <div class="swiper categorySwiper">
                        <div class="swiper-wrapper">
                            @foreach ($categories as $category)
                                @php
                                    $color = $colors[$loop->index % count($colors)];
                                @endphp
                                <div class="swiper-slide">
                                    <div class="category-card {{ $color }} text-center p-3 rounded shadow-sm">
                                        <img src="{{ asset($category->category_image) }}" alt="{{ $category->name }}"
                                            class="img-fluid mb-3 rounded">
                                        <p class="mb-0 fw-semibold">
                                            <a href="{{ route('category.list') }}?selected_categories[]={{ $category->id }}"
                                                class="text-decoration-none text-dark">{{ $category->name }}</a>
                                        </p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script src="{{ asset('frontend/js/product-detail.js') }}"></script>


    <!-- add cards -->

    <section class="container py-5">
        <div class="row g-4">
            <!-- Left Large Card -->
            <div class="col-md-6">
                @if (!empty($call_to_actions['call_to_action_main']))
                    @php $cta = $call_to_actions['call_to_action_main']; @endphp
                    <div class="custom-card big-card"
                        style="background-image: url('{{ asset($cta->image) }}'); background-color: #0ad6e4;">
                        <div class="card-content">
                            <h3>{{ $cta->title }}</h3>
                            <p>{{ $cta->description }}</p>
                            <a href="{{ $cta->url }}" class="btnn">EXPLORE NOW</a>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Right Column -->
            <div class="col-md-6">
                <div class="row gy-4">
                    <!-- Top Right Card -->
                    <div class="col-12">
                        @if (!empty($call_to_actions['call_to_action_sub']))
                            @php $cta = $call_to_actions['call_to_action_sub']; @endphp
                            <div class="custom-card small-card bg-card d-flex flex-column justify-content-center align-items-start pt-3"
                                style="background-image: url('{{ asset($cta->image) }}'); background-color: #00c97e;">
                                <div class="card-content">
                                    <h5>{{ $cta->title }}</h5>
                                    <a href="{{ $cta->url }}" class="btnn">EXPLORE NOW</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <!-- Bottom Right Cards -->
                    <div class="col-6">
                        @if (!empty($call_to_actions['call_to_action_sub1']))
                            @php $cta = $call_to_actions['call_to_action_sub1']; @endphp
                            <div class="custom-card small-card"
                                style="background-color: #ffb347; background-image: url('{{ asset($cta->image) }}')">
                                <div class="card-content">
                                    <h5>{{ $cta->title }}</h5>
                                    <a href="{{ $cta->url }}" class="btnn">EXPLORE</a>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-6">
                        @if (!empty($call_to_actions['call_to_action_sub2']))
                            @php $cta = $call_to_actions['call_to_action_sub2']; @endphp
                            <div class="custom-card small-card d-flex flex-column justify-content-center align-items-start"
                                style="background-color: #ea4c89; background-image: url('{{ asset($cta->image) }}')">
                                <div class="card-content">
                                    <h5>{{ $cta->title }}</h5>
                                    <a href="{{ $cta->url }}" class="btnn">EXPLORE</a>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>



    <!-- new arrival -->
    @if ($new_arrivals->isNotEmpty())
        <section class="container py-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h4 mb-0 fs-1">New Arrivals</h2>
                <div class="d-flex gap-2" id="newarrow">
                    <!-- custom controls -->
                    {{-- <button class="btn btn-outline-secondary btn-sm rounded-circle" type="button"
                        data-bs-target="#newArrivals" data-bs-slide="prev" aria-label="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="btn btn-outline-secondary btn-sm rounded-circle" type="button"
                        data-bs-target="#newArrivals" data-bs-slide="next" aria-label="Next">
                        <i class="bi bi-chevron-right"></i>
                    </button> --}}
                    <div
                        class="swiper-button-prev d-none d-lg-flex btn btn-outline-secondary btn-sm rounded-circle swip-btn-pre">
                    </div>
                    <div
                        class="swiper-button-next d-none d-lg-flex btn btn-outline-secondary btn-sm rounded-circle swip-btn-nxt">
                    </div>
                </div>
            </div>

            <div class="swiper new-arrivals" id="newArrivals">
                <div class="swiper-wrapper">

                    @foreach ($new_arrivals as $new_arrival)
                        <div class="swiper-slide">
                            <div class="card product-card1 h-100">

                                @if ($new_arrival->discount != 0)
                                    <span class="badge text-dark discount-badge">{{ $new_arrival->discount }}% OFF</span>
                                @endif

                                <div class="ratio ratio-4x3 position-relative">
                                    <a href="{{ route('product.details.show', $new_arrival->id) }}" class="image-box">

                                        <!-- Main Image -->
                                        <img src="{{ asset($new_arrival->product_img) }}" class="main-img"
                                            alt="{{ $new_arrival->product_name }}" loading="lazy">

                                        <!-- Hover Image -->
                                        <img src="{{ asset($new_arrival->proImages->last()->path ?? $new_arrival->product_img) }}"
                                            class="hover-img" alt="Product">

                                    </a>

                                    <div class="product-actions">
                                        @if ($new_arrival->isWishlist)
                                            <a href="{{ route('show.wishlist.list') }}"
                                                class="card-btun btn-sm action text-danger" title="Remove from wishlist">
                                                <i class="bi bi-heart-fill"></i>
                                            </a>
                                        @else
                                            @auth
                                                <a href="javascript:void(0)" class="card-btun btn-sm action wishlist-btn"
                                                    data-id="{{ $new_arrival->id }}"
                                                    data-url="{{ route('addto.wishlist', $new_arrival->id) }}"
                                                    data-login="{{ route('user.login') }}" title="Add To Wishlist">
                                                    <i class="bi bi-heart"></i>
                                                </a>
                                            @else
                                                <a href="{{ route('user.login') }}?type=guest"
                                                    class="card-btun btn-sm action" title="Add To Wishlist">
                                                    <i class="bi bi-heart"></i>
                                                </a>
                                            @endauth
                                        @endif

                                        <a href="{{ route('product.details.show', $new_arrival->id) }}"
                                            class="card-btun btn-sm action" title="Quick view">
                                            <i class="bi bi-eye"></i>
                                        </a>

                                        <a href="{{ route('addto.cart', $new_arrival->id) }}"
                                            class="card-btun btn-sm action" title="Add to cart">
                                            <i class="bi bi-cart"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="card-body p-2">
                                    <p class="card-title small text-truncate-2 mb-1">
                                        {{ \Illuminate\Support\Str::limit($new_arrival->product_name, 15) }}
                                    </p>
                                    <div class="price small d-flex align-items-center gap-2 flex-wrap">
                                        {{-- <span class="text-danger text-decoration-line-through" style="color:red !important">₹{{ $new_arrival->orginal_rate }}</span>
                                        <span class="fw-semibold">₹{{ $new_arrival->offer_price }}</span> --}}
                                        @if($new_arrival->orginal_rate != $new_arrival->offer_price)
                                            <span class="text-danger text-decoration-line-through" style="color:red !important">₹{{ $new_arrival->orginal_rate }}</span>
                                        @endif
                                        <span class="fw-semibold">₹{{ $new_arrival->offer_price }}</span>
                                        @php
                                            $colors = $new_arrival->colors;
                                            $selectedColor = request('color') ?? optional($new_arrival)->color;
                                        @endphp

                                        <div class="color_picker d-flex align-items-center gap-1 ms-2">
                                            @foreach ($colors as $index => $color)
                                                {{-- <input type="radio"
                                                    name="color"
                                                    id="color-{{ $color->id }}"
                                                    value="{{ $color->id }}"
                                                    class="d-none"
                                                    {{ (request('color') == $color->id || (!request('color') && $index === 0)) ? 'checked' : '' }}
                                                    onchange="selectColor({{ $color->id }})"
                                                    required> --}}

                                                <label for="color-{{ $color->id }}"
                                                    title="{{ $color->color }}"
                                                    class="color-dot"
                                                    style="background-color: {{ $color->color_code }}">
                                                </label>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    @endforeach

                </div>

                <!-- Pagination & nav -->
                {{-- <div class="swiper-pagination"></div> --}}


            </div>
        </section>
    @endif

    <style>
        #newarrow .swiper-button-prev, #newarrow .swiper-button-next{
            width: 40px !important;
        }
    </style>


    {{-- shop by age --}}
    @if ($shop_by_age->isNotEmpty())
        <section class="shop-by-age py-5 mt-4" style="overflow: hidden;">
            <div class="container">
                <h3 class="text-center">Shop By Age</h3>
            </div>

            <div class="age-section">
                <div class="container">
                    <div class="row justify-content-center g-5">
                        @foreach ($shop_by_age as $shop)
                            <div class="col-6 col-md-4 col-lg-3 age-card d-flex justify-content-center">
                                <div class="age-thumb">
                                    <a href="{{ route('category.list') }}?shop_by_age_id={{ $shop->id }}">
                                        {{-- <img src="{{ asset($shop->image) }}" alt="{{ $shop->title ?? '' }}" class="img-fluid rounded shadow-sm"> --}}
                                        <p class="mt-2">{{ $shop->title ?? '' }}<br>Collection</p>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
        </section>
    @endif
    {{-- shop by age --}}

    {{-- Best Seller Products --}}
    @if ($best_seller->isNotEmpty())
        <section class="container py-4">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h2 class="h4 mb-0 fs-1">Best Seller Products</h2>
                <a href="{{ route('category.list') }}?sort_by=best-selling"
                    class="d-inline-flex align-items-center text-decoration-none fw-medium text-dark">
                    View all Deals
                    <i class="bi bi-arrow-right ms-2"></i>
                </a>
            </div>

            <!-- Responsive grid: 2 cols on xs, 3 on md, 4 on lg, 5 on xl+ -->
            <div class="best-seller row row-cols-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
                <!-- CARD -->
                <style>
                    .color_picker .color-dot {
                        width: 14px;
                        height: 16px;
                        border-radius: 55%;
                        gap: -0.75rem!important;
                    }
                </style>
                @foreach ($best_seller as $seller)
                    <div class="col">
                        <div class="card product-card1 mb-3">
                            <!-- <span class="badge text-dark discount-badge">25% OFF</span> -->
                            <div class="ratio ratio-4x3 position-relative">
                                <a href="{{ route('product.details.show', $seller->id) }}" class="image-box">

                                    <!-- Main Image -->
                                    <img src="{{ asset($seller->product_img) }}" class="main-img" alt="Product">

                                    <!-- Hover Image -->
                                    <img src="{{ asset($seller->proImages->last()->path ?? $seller->product_img) }}"
                                        class="hover-img" alt="Product">
                                </a>
                                <div class="product-actions">
                                    @if ($seller->isWishlist)
                                        <a href="{{ route('show.wishlist.list') }}"
                                            class="card-btun btn-sm action text-danger" title="Remove from wishlist">
                                            <i class="bi bi-heart-fill"></i>
                                        </a>
                                    @else
                                        @auth
                                            <a href="javascript:void(0)" class="card-btun btn-sm action wishlist-btn"
                                                data-id="{{ $seller->id }}"
                                                data-url="{{ route('addto.wishlist', $seller->id) }}"
                                                data-login="{{ route('user.login') }}" title="Add To Wishlist">
                                                <i class="bi bi-heart"></i>
                                            </a>
                                        @else
                                            <a href="{{ route('user.login') }}" class="card-btun btn-sm action"
                                                title="Add To Wishlist">
                                                <i class="bi bi-heart"></i>
                                            </a>
                                        @endauth
                                    @endif
                                    <a href="{{ route('product.details.show', $seller->id) }}"
                                        class="card-btun btn-sm action" title="Quick view" aria-label="Quick view">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('addto.cart', $seller->id) }}" class="card-btun btn-sm action"
                                        title="Add to cart" aria-label="Add to cart">
                                        <i class="bi bi-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body">
                                <p class="card-title small text-truncate-2 mb-1">
                                    {{ \Illuminate\Support\Str::limit($seller->product_name, 15) }}
                                </p>
                                <div class="price small d-flex align-items-center gap-2 flex-wrap">
                                    {{-- <span class="text-danger text-decoration-line-through" style="color:red !important">₹{{ $seller->orginal_rate }}</span>
                                    <span class="fw-semibold">₹{{ $seller->offer_price }}</span> --}}
                                    @if($seller->orginal_rate != $seller->offer_price)
                                        <span class="text-danger text-decoration-line-through" style="color:red !important">₹{{ $seller->orginal_rate }}</span>
                                    @endif
                                    <span class="fw-semibold">₹{{ $seller->offer_price }}</span>
                                    @php
                                        $colors = $seller->colors;
                                        $selectedColor = request('color') ?? optional($seller)->color;
                                    @endphp

                                    <div class="color_picker d-flex align-items-center ms-2">
                                        @foreach ($colors as $index => $color)
                                            {{-- <input type="radio"
                                                name="color"
                                                id="color-{{ $color->id }}"
                                                value="{{ $color->id }}"
                                                class="d-none"
                                                {{ (request('color') == $color->id || (!request('color') && $index === 0)) ? 'checked' : '' }}
                                                onchange="selectColor({{ $color->id }})"
                                                required> --}}

                                            <label for="color-{{ $color->id }}"
                                                title="{{ $color->color }}"
                                                class="color-dot"
                                                style="background-color: {{ $color->color_code }}">
                                            </label>
                                        @endforeach
                                    </div>
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
    <div class="marquee-container p-2">
        <div class="marquee-content text-light">
            <i class="fa-solid fa-star-of-david text-light mx-5"></i> Get 15% off your first purchase
            <i class="fa-solid fa-star-of-david text-light mx-5"></i> 7 days Return & Refund
            <i class="fa-solid fa-star-of-david text-light mx-5"></i> Gift wrapping free service

        </div>
    </div>
    {{-- shop by reel --}}

    <section class="container py-4">
          <div class="elfsight-app-03d717df-86a7-46e8-9926-3ea8612a48b6" data-elfsight-app-lazy></div>
    </section>
    {{-- shop by reel --}}
 

    <style>
        /* Hide Elfsight branding */
        a[href*="elfsight.com"] {
            display: none !important;
        }

        /* Alternative */
        .eapps-instagram-feed-posts-grid + a,
        .eapps-widget-toolbar,
        .eapps-link {
            display: none !important;
        }
    </style>

    <!-- Elfsight Instagram Feed | Untitled Instagram Feed -->
    <script src="https://elfsightcdn.com/platform.js" async></script>
   

    <script>
        function removeElfsightBranding() {
        document.querySelectorAll('a[href*="elfsight.com"]').forEach(el => {
            el.remove();
        });
    }

    removeElfsightBranding();

    setInterval(removeElfsightBranding, 500);
    </script>

    <section class="banner-section-1">
        <div class="container">
            <div class="row align-items-center">

                <!-- Left Side: Kid Image -->
                <div class="col-6 text-center">
                    {{-- <img src="kid-image.png" alt="Kid" class="banner-img"> --}}
                </div>

                <!-- Right Side: Text and Button -->
                <div class="col-6 content">
                    <h2>Every color for every kid.</h2>
                    <a href="{{ route('category.list') }}" class="shop-btn" style="text-decoration: none;">SHOP NOW</a>
                </div>
            </div>
        </div>
    </section>

    <!-- Shop by Price Section -->
    <section class="new-price-section py-5">
        <div class="container">
            <div class="d-flex align-items-center justify-content-between mb-3">
                <h3 class="new-price-title mb-0">Shop By Price</h3>

                <!-- Navigation buttons -->
                <div class="new-price-nav d-flex align-items-center">
                    <button class="new-price-prev-btn" aria-label="Previous">
                        <i class="bi bi-chevron-left"></i>
                    </button>
                    <button class="new-price-next-btn" aria-label="Next">
                        <i class="bi bi-chevron-right"></i>
                    </button>
                </div>
            </div>

            <!-- Swiper Container -->
           <div class="swiper new-price-swiper" id="newPriceSwiper">
                <div class="swiper-wrapper">
                    @foreach ($shop_by_prices as $shop_by_price)
                        <div class="swiper-slide">
                            <div class="new-price-card position-relative overflow-hidden rounded shadow-sm">
                                <!-- URL Param: shop_by_price_id pass panroam -->
                                <a href="{{ route('category.list', ['shop_by_price_id' => $shop_by_price->id]) }}" class="d-block text-decoration-none">
                                    
                                    {{-- Image Wrapper --}}
                                    <div class="new-price-img-wrap">
                                        <img src="{{ asset($shop_by_price->image) }}" 
                                            alt="{{ $shop_by_price->title ?? 'Shop by Price' }}" 
                                            class="img-fluid w-100 object-fit-cover">
                                    </div>

                                    {{-- Price Tag Overlay --}}
                                    <div class="new-price-tag-wrap p-2 text-center">
                                        <span class="new-price-tag fw-bold">{{ $shop_by_price->title ?? '' }}</span>
                                    </div>

                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>
                
                {{-- Swiper Controls (Optional: Dots / Navigation arrows needed na use pannikonga) --}}
                {{-- <div class="swiper-pagination"></div> --}}
            </div>
        </div>
    </section>
@endsection

<!-- Swiper JS -->
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>

<!--

<script>
    // Helper: enable/disable looping based on item count vs visible slides
    (function() {
        const totalSlides = {{ count($new_arrivals) }};
        const swiper = new Swiper('#newArrivals', {
            speed: 500,
            spaceBetween: 12,
            slidesPerView: 1,
            loop: totalSlides > 5, // loop only if we have more than the desktop view
            autoplay: {
                delay: 3500,
                disableOnInteraction: false
            },
            freeMode: false,
            grabCursor: true,
            watchSlidesProgress: true,
            preloadImages: false,
            lazy: {
                loadPrevNext: true,
                loadPrevNextAmount: 2
            },
            pagination: {
                el: '.swiper-pagination',
                clickable: true
            },
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            },
            breakpoints: {
                // ~0px to 639px
                0: {
                    slidesPerView: 1
                },
                // >= 640px (sm tablets / landscape phones)
                640: {
                    slidesPerView: 2
                },
                // >= 992px (desktop)
                992: {
                    slidesPerView: 5
                }
            }
        });
    })();
</script>


Initialize Swiper -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const newPriceSwiper = new Swiper('#newPriceSwiper', {
            loop: true,
            speed: 600,
            spaceBetween: 16,
            // grabCursor: true,
            // autoplay: {
            //     delay: 3500,
            //     disableOnInteraction: false,
            // },
            pagination: {
                el: '.new-price-pagination',
                clickable: true,
            },
            navigation: {
                nextEl: '.new-price-next-btn',
                prevEl: '.new-price-prev-btn',
            },
            breakpoints: {
                0: {
                    slidesPerView: 1.2,
                },
                640: {
                    slidesPerView: 2,
                },
                992: {
                    slidesPerView: 4,
                },
                1200: {
                    slidesPerView: 5,
                },
            },
        });
    });
</script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sliders = document.querySelectorAll('.product-image-slider');
        let slideInterval;

        sliders.forEach(slider => {
            const image = slider.querySelector('img');
            const originalImage = slider.dataset.originalImage;
            let images = [];
            // Ensure that the dataset.images is not empty or null before parsing
            if (slider.dataset.images) {
                try {
                    images = JSON.parse(slider.dataset.images);
                } catch (e) {
                    console.error("Could not parse images JSON:", e);
                    return; // Exit if JSON is invalid
                }
            }

            // Add the original image to the beginning of the array for a seamless loop
            if (images.length > 0) {
                images.unshift(originalImage);
            }

            let currentIndex = 0;

            slider.addEventListener('mouseenter', () => {
                if (images.length > 1) {
                    slideInterval = setInterval(() => {
                        currentIndex = (currentIndex + 1) % images.length;
                        image.src = images[currentIndex];
                    }, 1000); // Change image every 1 second (1000ms)
                }
            });

            slider.addEventListener('mouseleave', () => {
                clearInterval(slideInterval);
                image.src = originalImage;
                currentIndex = 0;
            });
        });
    });
</script>

<!-- Optional CSS Styling -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>