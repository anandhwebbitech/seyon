@extends('frontend.layouts.app')
@section('content')
    <style>
        /* Main Products Section */
        .shop-products-section {
            padding: 40px 0;
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .shop-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 15px;
        }

        .shop-row {
            display: flex;
            flex-wrap: wrap;
            margin: -15px;
        }

        .shop-row>* {
            padding: 15px;
        }

        /* Sidebar Styles */
        .shop-sidebar {
            background: #fff;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.08);
            height: fit-content;
            position: sticky;
            top: 20px;
        }

        .shop-sidebar-header {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .shop-sidebar-subheading {
            font-size: 16px;
            font-weight: 600;
            color: #34495e;
            margin-bottom: 15px;
            margin-top: 10px;
        }

        .shop-filter-form {
            margin-bottom: 20px;
        }

        .shop-category-list {
            margin: 0;
            padding: 0;
        }

        .shop-category-item {
            margin-bottom: 12px;
        }

        .shop-checkbox {
            display: flex;
            align-items: center;
            cursor: pointer;
        }

        .shop-checkbox input[type="checkbox"] {
            width: 18px;
            height: 18px;
            cursor: pointer;
            margin-right: 10px;
            accent-color: #e74c3c;
        }

        .shop-checkbox label {
            cursor: pointer;
            font-size: 14px;
            color: #555;
            margin: 0;
            user-select: none;
        }

        .shop-checkbox:hover label {
            color: #e74c3c;
        }

        /* Products Grid */
        .shop-products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 25px;
        }

        .shop-product-card {
            background: #fff;
            /* border-radius: 8px; */
            overflow: visible;
            transition: all 0.3s ease;
            /* box-shadow: 0 1px 4px rgba(0, 0, 0, 0.1); */
            position: relative;
            border: 1px solid #e0e0e0;
        }

        .shop-product-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        .shop-product-image-wrapper {
            position: relative;
            overflow: hidden;
            height: 280px;
            background: #fff;
            /* border: 8px solid #f5f5f5; */
            /* border-radius: 8px; */
            margin: 12px 12px 0 12px;
        }

        .shop-discount-badge {
            display: none;
        }

        .shop-action-icons {
            position: absolute;
            bottom: -20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
            z-index: 3;
            opacity: 0;
            transition: all 0.3s ease;
        }

        .shop-product-card:hover .shop-action-icons {
            opacity: 1;
            bottom: 10px;
        }

        .shop-action-btn {
            background: #fff;
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.2);
            border: 2px solid #fff;
        }

        .shop-action-btn:hover {
            transform: scale(1.1);
        }

        .shop-action-btn.wishlist-btn:hover {
            background: #e74c3c;
            color: #fff;
        }

        .shop-action-btn.view-btn:hover {
            background: #3498db;
            color: #fff;
        }

        .shop-action-btn.cart-btn:hover {
            background: #f39c12;
            color: #fff;
        }

        .shop-action-btn i {
            font-size: 20px;
            color: #555;
        }

        .shop-action-btn:hover i {
            color: #fff;
        }

        .shop-action-btn.active {
            background: #e74c3c;
            color: #fff;
        }

        .shop-action-btn.active i {
            color: #fff;
        }

        .shop-wishlist-btn {
            display: none;
        }

        .shop-product-link {
            display: block;
            height: 100%;
        }

        .shop-product-image {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .shop-product-card:hover .shop-product-image {
            transform: scale(1.08);
        }

        .shop-product-info {
            padding: 15px 20px 20px 20px;
        }

        .shop-add-cart-wrapper {
            display: none;
        }

        .shop-cart-btn {
            background: #f39c12;
            color: #fff;
            border: none;
            width: 42px;
            height: 42px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
            font-size: 18px;
        }

        .shop-cart-btn:hover {
            background: #e67e22;
            transform: rotate(90deg);
        }

        .shop-cart-success {
            background: #27ae60;
            cursor: default;
        }

        .shop-cart-success:hover {
            transform: none;
        }

        .shop-stock-status {
            color: #e74c3c;
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .shop-rating {
            display: none;
        }

        .shop-no-reviews {
            display: none;
        }

        .shop-product-name {
            font-size: 14px;
            font-weight: 400;
            margin-bottom: 8px;
            line-height: 1.5;
            color: #333;
            min-height: 42px;
        }

        .shop-product-name a {
            color: #333;
            text-decoration: none;
            transition: color 0.3s ease;
        }

        .shop-product-name a:hover {
            color: #e74c3c;
        }

        .shop-product-price {
            font-size: 18px;
            font-weight: 700;
            color: #e74c3c;
            margin: 0;
        }

        .shop-old-price {
            font-size: 14px;
            color: #999;
            text-decoration: line-through;
            margin-left: 8px;
            font-weight: 400;
        }

        /* Modal Styles */
        .shop-modal {
            display: none;
            position: fixed;
            z-index: 9999;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            backdrop-filter: blur(4px);
        }

        .shop-modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .shop-modal-dialog {
            max-width: 900px;
            width: 90%;
            margin: 20px;
        }

        .shop-modal-content {
            background: #fff;
            border-radius: 16px;
            overflow: hidden;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.3);
        }

        .shop-modal-header {
            padding: 20px 30px;
            border-bottom: 1px solid #eee;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .shop-modal-title {
            font-size: 22px;
            font-weight: 600;
            color: #2c3e50;
            margin: 0;
        }

        .shop-modal-close {
            background: none;
            border: none;
            font-size: 28px;
            cursor: pointer;
            color: #999;
            width: 35px;
            height: 35px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 50%;
            transition: all 0.3s ease;
        }

        .shop-modal-close:hover {
            background: #f5f5f5;
            color: #e74c3c;
        }

        .shop-modal-body {
            padding: 30px;
            max-height: 70vh;
            overflow-y: auto;
        }

        /* Responsive Styles */
        @media (max-width: 991px) {
            .shop-sidebar {
                margin-bottom: 30px;
            }

            .shop-products-grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
            }
        }

        @media (max-width: 767px) {
            .shop-products-grid {
                grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));
                gap: 15px;
            }

            .shop-product-image-wrapper {
                height: 220px;
            }

            .shop-modal-dialog {
                width: 95%;
            }
        }

        /* Column Layout */
        .shop-col-lg-3 {
            width: 25%;
        }

        .shop-col-lg-9 {
            width: 75%;
        }

        .shop-col-lg-4 {
            flex: 0 0 33.333333%;
        }

        .shop-col-md-6 {
            flex: 0 0 50%;
        }

        .shop-col-12 {
            flex: 0 0 100%;
        }

        @media (max-width: 991px) {

            .shop-col-lg-3,
            .shop-col-lg-9,
            .shop-col-lg-4,
            .shop-col-md-6 {
                width: 100%;
                flex: 0 0 100%;
            }
        }

        /* Hidden class */
        .shop-hidden {
            display: none !important;
        }
    </style>
    <section class="shop-products-section">
        <div class="shop-container">
            <div class="shop-row">
                <!-- Sidebar Filter -->
                <div class="shop-col-lg-3 shop-col-md-12">
                    <div class="shop-sidebar">
                        <h1 class="shop-sidebar-header">
                            <i class="bi bi-grid"></i>Filter
                        </h1>
                        <div class="shop-row">
                            <form class="shop-filter-form" id="search-form" action="" method="GET">
                                <div class="shop-col-12 shop-col-md-6 shop-col-lg-12">
                                    <h5 class="shop-sidebar-subheading">Categories</h5>
                                    <dl class="shop-category-list">
                                        @php
                                            $categories = App\Models\ProductCategory::where('status', 1)->get();
                                        @endphp

                                        @foreach ($categories as $category)
                                            <dt class="shop-category-item">
                                                <div class="shop-checkbox">
                                                    <input class="form-check-input" type="checkbox"
                                                        name="selected_categories[]" value="{{ $category->id }}"
                                                        @if (in_array($category->id, $selected_categories)) checked @endif
                                                        onchange="filter()">
                                                    <label for="flexCheckDefault">
                                                        {{ $category->name }}
                                                    </label>
                                                </div>
                                            </dt>
                                        @endforeach
                                    </dl>
                                </div>
                            </form>

                            <div class="shop-col-12 shop-col-md-6 shop-col-lg-12">
                                <!-- Additional filters can go here -->
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Products Grid -->
                <div class="shop-col-lg-9">
                    <div class="shop-products-grid">
                        @if ($product)
                            @foreach ($product as $key => $item)
                                <div class="shop-product-card">
                                    <div class="shop-product-image-wrapper">
                                        <!-- Action Icons on Hover -->
                                        <div class="shop-action-icons">
                                            <a href="javascript:void(0);" data-product-id="{{ $item->id }}"
                                                id="wishlist-btn-{{ $item->id }}"
                                                class="shop-action-btn wishlist-btn add-to-wishlist-button"
                                                title="Add to Wishlist">
                                                <i class="bi bi-heart"></i>
                                            </a>

                                            <a href="{{ route('product.details.show', $item->id) }}"
                                                class="shop-action-btn view-btn" title="Quick View">
                                                <i class="bi bi-eye"></i>
                                            </a>

                                            @if ($item->quantity != 0 && $item->quantity != '')
                                                <a href="javascript:void(0);" data-product-id="{{ $item->id }}"
                                                    id="cart-btn-{{ $item->id }}"
                                                    class="shop-action-btn cart-btn add-to-cart-button" title="Add to Cart">
                                                    <i class="bi bi-cart"></i>
                                                </a>
                                            @endif
                                        </div>

                                        <a href="{{ route('product.details.show', $item->id) }}" class="shop-product-link">
                                            <img src="{{ asset($item->product_img) }}"
                                                alt="{{ $item->product_name }}" class="shop-product-image">
                                        </a>
                                    </div>

                                    <div class="shop-product-info">
                                        <div class="shop-product-name">
                                            <a href="{{ route('product.details.show', $item->id) }}">
                                                {{ $item->product_name }}
                                            </a>
                                        </div>

                                        <p class="shop-product-price">
                                            ₹{{ number_format($item->offer_price) }}
                                            @if ($item->discount > 0)
                                                <span
                                                    class="shop-old-price">₹{{ number_format($item->price ?? $item->offer_price * (100 / (100 - $item->discount))) }}</span>
                                            @endif
                                        </p>

                                        @if ($item->quantity == 0 || $item->quantity == '')
                                            <span class="shop-stock-status">(Out of stock)</span>
                                        @endif
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="shop-modal" id="productDetailsModal" tabindex="-1" role="dialog"
        aria-labelledby="productDetailsModalLabel" aria-hidden="true">
        <div class="shop-modal-dialog" role="document">
            <div class="shop-modal-content">
                <div class="shop-modal-header">
                    <h5 class="shop-modal-title" id="productDetailsModalLabel">Product Details</h5>
                    <button type="button" class="shop-modal-close" data-bs-dismiss="modal" aria-label="Close">
                        &times;
                    </button>
                </div>
                <div class="shop-modal-body" id="productDetailsBody">
                    <!-- Product details will be populated here -->
                </div>
            </div>
        </div>
    </div>




@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script type="text/javascript">
    function filter() {
        $('#search-form').submit();
    }
</script>

<script>
    $(document).ready(function() {
        // Event listener for Add to Cart button
        $('.add-to-cart-button').on('click', function() {
            var productId = $(this).data('product-id');

            // Fetch product details using AJAX
            $.ajax({
                url: '{{ url('get-product-details') }}',
                method: 'GET',
                data: {
                    id: productId
                },
                success: function(response) {
                    // Populate modal with product details
                    $('#productDetailsBody').html(response);
                    // Open the modal
                    $('#productDetailsModal').modal('show');
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function() {
        // Check if the item is in the cart and show the message if necessary
        @if (session('cart'))
            @foreach (session('cart') as $id => $details)
                $('#adding-cart-{{ $id }}').show();
                $('#add-cart-btn-{{ $id }}').hide();
            @endforeach
        @endif
        @if (session('wishlist'))
            @foreach (session('wishlist') as $id => $details)
                $('#adding-wishlist-{{ $id }}').show();
                $('#add-wishlist-btn-{{ $id }}').hide();
            @endforeach
        @endif

    });
</script>



<script>
    $(document).ready(function() {
        $('.add-to-wishlist-button').on('click', function() {
            var productId = $(this).data('product-id');

            $.ajax({
                type: 'GET',
                url: '{{ url('add-to-wishlist') }}/' + productId,
                success: function(data) {
                    $("#adding-wishlist-" + productId).show();
                    $("#add-wishlist-btn-" + productId).hide();
                    window.location.reload();
                },
                error: function(error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
    });
</script>
