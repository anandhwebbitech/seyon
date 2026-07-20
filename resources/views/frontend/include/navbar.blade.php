<style>
    .search-form {
        width: 100%;
    }

    .search-input {
        border-radius: 50px 0 0 50px;
        padding: 0.75rem 1.25rem;
        border: 2px solid #e0e0e0;
        border-right: none;
        font-size: 0.95rem;
    }

    .search-input:focus {
        border-color: #e0e0e0;
        box-shadow: none;
        outline: none;
    }

    .search-btn {
        border-radius: 0 50px 50px 0;
        padding: 0.75rem 1.5rem;
        border: 2px solid #e0e0e0;
        border-left: none;
        width: 50px;
        height: 50px;
        color: #e0e0e0;
        font-size: 24px;
        border-radius: 50%;
        background: transparent;
    }

    .search-btn:hover {
        opacity: 0.9;
    }

    @media (max-width: 991px) {
        .search-form {
            padding: 0 15px;
        }

        .search-input {
            font-size: 0.9rem;
            padding: 0.6rem 1rem;
        }

        .search-btn {
            padding: 0.6rem 1.2rem;
        }
    }

    @media (max-width: 576px) {
        .search-input {
            font-size: 0.85rem;
        }
    }

    .col{
        padding: 10px !important;
    }
</style>

<!-- Top welcome bar -->
<div class="topbar">
    <div class="container d-flex justify-content-between align-items-center">
        <span class="text-white">Welcome to Seyon kids!</span>
        <a href="{{ route('user.order.history') }}" class="right-link"><i class="fa-solid fa-truck-fast me-2"></i>Track
            your
            order</a>
    </div>
</div>

<!-- Header: logo + search + actions -->
<div class="header-main">
    <div class="container">
        <div class="row align-items-center justify-content-between">
            <!-- Logo -->
            <div class="col-2 col-lg-2">
                <a href="{{ route('home') }}" class="logo d-inline-flex align-items-center">
                    <img src="{{ asset('frontend/img/logo.png') }}" alt="Logo" class="img-fluid d-block">
                </a>
            </div>

            <!-- Search Bar Section -->
            <div class="col-12 col-lg-6 order-3 order-lg-2 mt-3 mt-lg-0">
                <form action="{{ route('category.list') }}" method="GET" class="search-form">
                    <div class="input-group">
                        <input type="text" name="search" class="form-control search-input"
                            placeholder="Search for products..." aria-label="Search products"
                            value="{{ request('search') }}">
                        <button class=" btn-primary search-btn" type="submit" aria-label="Search">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                </form>
            </div>

            <!-- Actions -->
            @auth
                @if (auth()->user()->user_type === 'user')
                    <div
                        class="col-10 col-md-10 col-lg-4 d-flex justify-content-end align-items-center gap-3 order-2 order-lg-3 header-actions">
                        <!-- Cart & User Section -->
                        @php
                            if (auth()->check() && auth()->user()->cartItems) {
                                $cartItems = auth()->user()->cartItems;
                                $subtotal = $cartItems->sum(fn($item) => $item->price * $item->quantity);
                            } else {
                                $cartItems = collect([]);
                                $subtotal = 0;
                            }
                            // Wishlist
                            if (auth()->check() && auth()->user()->wishlistItems) {
                                $wishlistItems = auth()->user()->wishlistItems;
                            } else {
                                $wishlistItems = collect([]);
                            }
                        @endphp
                        <!-- Wishlist Button -->
                        <a href="{{ route('show.wishlist.list') }}" class="d-inline-flex align-items-center">
                            <i class="bi bi-heart me-1"></i>
                            <span class="d-none d-lg-inline wishlist_count">({{ $wishlistItems->count() }})</span>
                        </a>

                        <span class="divider d-none d-lg-inline-block" aria-hidden="true"></span>
                        <!-- Button trigger modal -->
                        <button class="btn btn-primary show-cart-btn d-inline-flex align-items-center" id="cart">
                            <i class="bi bi-cart me-1" aria-hidden="true"></i>
                            <span class="d-none d-lg-inline">Cart ({{ $cartItems->count() }})</span>
                        </button>
                        <span class="divider d-none d-lg-inline-block" aria-hidden="true"></span>
                        @if (auth()->user()->user_type === 'user')
                            <a href="{{ route('user.dashboard') }}" class="d-flex align-items-center text-decoration-none">
                                <i class="fa-regular fa-user me-2 fs-5" aria-hidden="true"></i>
                                <div class="d-flex flex-column lh-sm">
                                    <span class="text-primary fw-semibold">{{ auth()->user()->name }}</span>
                                    {{-- <small class="text-primary fw-semibold"></small> --}}
                                </div>
                            </a>
                        @endif

                        <!-- Backdrop -->
                        <div class="backdrop" id="backdrop" onclick="closeCart()"></div>

                        <!-- Cart Modal -->
                        {{-- <div class="cart-modal" id="cartModal" aria-modal="true" role="dialog" aria-labelledby="cartTitle"
                            aria-hidden="false">
                            <!-- Header -->
                            <div class="cart-header">
                                <h5 class="cart-title" id="cartTitle">
                                    Cart <span class="cart-badge" id="cart-count">{{ $cartItems->count() }}</span>
                                </h5>
                                <button class="close-btn" aria-label="Close cart">
                                    <i class="fas fa-times" aria-hidden="true"></i>
                                </button>
                            </div>

                            <!-- Body -->
                            <div class="cart-body">
                               
                            </div>

                            <!-- Footer -->
                            <div class="cart-footer">
                                {{-- <div class="coupon-section">
                    

                                <div class="subtotal">
                                    <span>Subtotal</span>
                                    <span id="subtotalAmount">${{ $subtotal }}</span>
                                </div>

                                <div class="d-block">
                                    <a class="checkout-btn" style="color: #fff"
                                        href="{{ route('product.proceed_to_checkout') }}">Checkout</a>
                                    <a class="view-cart-btn" href="{{ route('show.cart.table') }}">View
                                        Cart</a>
                                </div>
                            </div>
                        </div> --}}
                        <meta name="csrf-token" content="{{ csrf_token() }}">

                        <script>
                            const cartListUrl = "{{ route('cart.list') }}";
                            const increaseCartRoute = "{{ url('/cart/increase') }}";
                            const decreaseCartRoute = "{{ url('/cart/decrease') }}";
                            const removeCartRoute = "{{ route('cart.remove') }}";
                            const assetBase = "{{ asset('') }}";
                        </script>

                        <div class="cart-modal" id="cartModal">
                            <div class="cart-header">
                                <h5>Cart - <span id="cart-count"></span></h5>
                                <button class="close-btn">✕</button>
                            </div>

                            <div class="cart-body p-2"></div>

                            <div class="cart-footer">
                                <div class="subtotal">
                                    <span>Subtotal</span>
                                    <span id="subtotalAmount">₹ 0</span>
                                </div>

                                <a class="checkout-btn" style="color: #fff"
                                    href="{{ route('product.proceed_to_checkout') }}">Checkout</a>
                                <a class="view-cart-btn" href="{{ route('show.cart.table') }}">View
                                    Cart</a>
                            </div>
                        </div>


                    </div>
                @else
                    <div
                        class="col-10 col-md-10 col-lg-4 d-flex justify-content-end align-items-center gap-3 order-2 order-lg-3 header-actions">
                        <a href="{{ route('user.login') }}" class="d-inline-flex align-items-center">
                            <i class="fa-regular fa-user me-2" aria-hidden="true"></i>
                            <span class="text-label d-none d-lg-inline">Sign Up/Sign In</span>
                        </a>
                    </div>
                @endif
            @endauth

            @guest
                <!-- Show login/signup button if user is not logged in -->
                <div
                    class="signin col-10 col-md-10 col-lg-4 d-flex justify-content-end align-items-center gap-3 order-2 order-lg-3 header-actions">
                    <a href="{{ route('user.login') }}" class="d-inline-flex align-items-center hero-cta">
                        <i class="fa-regular fa-user me-2" aria-hidden="true"></i>
                        <span class="text-label d-none d-lg-inline">Sign In</span>
                    </a>
                </div>
            @endguest


            <!-- /Actions -->
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    const cartListUrl = "{{ route('cart.list') }}";
    const assetBase = "{{ asset('') }}";
    const increaseCartRoute = "{{ route('increase.cart.qty', '') }}";
    const decreaseCartRoute = "{{ route('decrease.cart.qty', '') }}";
</script>
<script>
    $(document).ready(function() {
        $('#cart').on('click', function() {
            $('#cartModal').addClass('show');
            cartList();
        });
        $('.close-btn').on('click', function() {
            $('#cartModal').removeClass('show');
        });

        $('#increase').on('click', function() {
            console.log(123);
        });
    });
</script>
<!-- Bottom navigation -->
<div class="main-nav">
    <div class="container">
        <nav class="navbar navbar-expand-lg p-0">
            <button class="navbar-toggler ms-auto my-2" style="background-color: #ffffff !important;" type="button" data-bs-toggle="collapse"
                data-bs-target="#mainNav" aria-controls="mainNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="mainNav">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <style>
                        .nav-item.dropdown:hover .dropdown-menu {
                            display: block;
                            margin-top: 0;
                        }

                        .nav-item.dropdown:hover>.nav-link::after {
                            transform: rotate(180deg);
                        }
                    </style>
                    @php
                        $categories = \App\Models\ProductCategory::with('subCategories')->where('status', 1)->get();
                    @endphp
                    <li class="nav-item"><a class="nav-link" href="{{ route('home') }}">Home</a></li>
                    @foreach ($categories as $category)
                        <li class="nav-item dropdown">
                            <a class="nav-link"
                                href="{{ route('category.list') }}?selected_categories[]={{ $category->id }}">{{ $category->name }}
                            </a>
                            @if ($category->subCategories->isNotEmpty())
                                <ul class="dropdown-menu">
                                    @foreach ($category->subCategories as $sub)
                                        <li class="@if ($sub->submenus->isNotEmpty()) dropdown-submenu @endif">
                                            <a class="dropdown-item dropdown-item-styled"
                                                href="{{ route('category.list') }}?selected_subcategories[]={{ $sub->id }}">
                                                <span>{{ $sub->name }}</span>
                                            </a>
                                            @if ($sub->submenus->isNotEmpty())
                                                <ul class="dropdown-menu">
                                                    @foreach ($sub->submenus as $menu)
                                                        <li>
                                                            <a class="dropdown-item"
                                                                href="{{ route('category.list') }}?selected_submenus[]={{ $menu->id }}">
                                                                {{ $menu->name }}
                                                            </a>
                                                        </li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </li>
                    @endforeach
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('contact') }}">Contact Us</a>
                    </li>
                </ul>
            </div>
        </nav>
    </div>
</div>


<style>
    /* Navbar Dropdown Styling */
    .navbar {
        font-family: 'Poppins', sans-serif;
    }

    .nav-item.dropdown {
        position: relative;
    }

    .nav-link {
        color: #333;
        font-weight: 500;
        transition: color 0.3s ease;
        padding: 10px 20px !important;
    }

    .nav-link:hover {
        color: #ff4757;
    }

    /* Main Dropdown Menu */
    .dropdown-menu {
        display: none;
        position: absolute;
        top: 100%;
        left: 0;
        background: #fff;
        border: none;
        border-radius: 12px;
        box-shadow: 0 10px 40px rgba(0, 0, 0, 0.15);
        padding: 10px 0;
        min-width: 250px;
        z-index: 1000;
        opacity: 0;
        transform: translateY(-10px);
        transition: all 0.3s ease;
        margin-top: 10px;
    }

    .nav-item.dropdown:hover>.dropdown-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
        margin-top: -8px;
    }

    /* Dropdown Items */
    .dropdown-item {
        padding: 12px 25px;
        color: #555;
        font-weight: 500;
        transition: all 0.3s ease;
        border-left: 3px solid transparent;
        display: flex;
        align-items: center;
    }

    .dropdown-item:hover {
        background: linear-gradient(135deg, #fff5f7 0%, #ffe5ea 100%);
        color: #ff4757;
        border-left-color: #ff4757;
        transform: translateX(5px);
        padding-left: 30px;
    }

    .dropdown-item i {
        margin-right: 10px;
        font-size: 18px;
    }

    /* Nested Dropdown */
    .dropdown-submenu {
        position: relative;
    }

    .dropdown-submenu>.dropdown-menu {
        top: 0;
        left: 100%;
        margin-top: 0;
        margin-left: 5px;
    }

    .dropdown-submenu:hover>.dropdown-menu {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .dropdown-submenu>.dropdown-item::after {
        content: "❯";
        float: right;
        margin-left: auto;
        font-size: 14px;
        transition: transform 0.3s ease;
    }

    .dropdown-submenu:hover>.dropdown-item::after {
        transform: translateX(5px);
    }

    /* Dropdown Divider */
    .dropdown-divider {
        margin: 10px 15px;
        border-top: 2px solid #f0f0f0;
    }

    /* Colorful Icon Backgrounds */
    .icon-wrapper {
        width: 35px;
        height: 35px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 12px;
        font-size: 16px;
    }

    .icon-pink {
        background: linear-gradient(135deg, #ff6b9d 0%, #ff4757 100%);
        color: white;
    }

    .icon-blue {
        background: linear-gradient(135deg, #5f9fff 0%, #4a7dff 100%);
        color: white;
    }

    .icon-green {
        background: linear-gradient(135deg, #2ed573 0%, #26de81 100%);
        color: white;
    }

    .icon-yellow {
        background: linear-gradient(135deg, #ffa502 0%, #ff6348 100%);
        color: white;
    }

    .icon-purple {
        background: linear-gradient(135deg, #a29bfe 0%, #6c5ce7 100%);
        color: white;
    }

    /* Dropdown Item with Icons */
    .dropdown-item-styled {
        display: flex;
        align-items: center;
        padding: 12px 20px;
    }

    /* Animation for dropdown appearance */
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

    .nav-item.dropdown:hover>.dropdown-menu {
        animation: slideDown 0.3s ease forwards;
    }

    /* Responsive Design */
    @media (max-width: 991px) {
        .dropdown-menu {
            position: static;
            box-shadow: none;
            border-left: 3px solid #ff4757;
            margin-left: 15px;
        }

        .dropdown-submenu>.dropdown-menu {
            position: static;
            margin-left: 20px;
        }
    }
</style>