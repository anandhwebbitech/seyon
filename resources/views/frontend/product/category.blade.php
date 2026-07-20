@extends('frontend.layouts.app')
@section('content')
    <style>
        .price-filter h4 {
            margin: 0 0 8px;
            font-size: 16px;
            font-weight: 600;
            color: #111;
        }

        .price-values {
            font-size: 16px;
            font-weight: 600;
            color: #111;
            margin-bottom: 18px;
        }

        .slider {
            position: relative;
            width: 100%;
            height: 5px;
            background: #ccc;
            border-radius: 3px;
        }

        .slider .progress {
            position: absolute;
            height: 100%;
            background: #0078d4;
            border-radius: 3px;
        }

        .range-input {
            position: relative;
        }

        .range-input input {
            position: absolute;
            top: -7px;
            width: 100%;
            height: 5px;
            -webkit-appearance: none;
            background: none;
            pointer-events: none;
        }

        input[type="range"]::-webkit-slider-thumb {
            height: 20px;
            width: 20px;
            border-radius: 50%;
            background: #0078d4;
            border: 4px solid #fff;
            box-shadow: 0 0 3px rgba(0, 0, 0, 0.4);
            pointer-events: auto;
            -webkit-appearance: none;
            cursor: pointer;
        }
    </style>
    <style>
    .product-card1 {
        width: 100%;
        position: relative;
        overflow: hidden;
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
</style>
    <div class="container-fluid container py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <!-- Product Categories -->
                    <div class="price-filter-container">
                        <h3>Product Categories</h3>
                        <form class="mb-4" id="search-form" action="" method="GET">
                            <div class="col-12 col-md-6 col-lg-12">
                                {{-- <h5 class="product-sidebar-subtitle">Categories</h5> --}}
                                <dl class="row gy-3">

                                    @php
                                        $categories = App\Models\ProductCategory::where('status', 1)->get();
                                    @endphp

                                    @foreach ($categories as $category)
                                        <dt class="col-10">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox"
                                                    id="category_{{ $category->id }}" name="selected_categories[]"
                                                    value="{{ $category->id }}" @checked(in_array($category->id, $selected_categories))
                                                    onchange="filter()">
                                                <label class="form-check-label" for="category_{{ $category->id }}">
                                                    {{ $category->name }}
                                                </label>
                                            </div>
                                        </dt>
                                    @endforeach

                                </dl>
                            </div>

                            <h3 class="price-filter-title mt-3">PRICE FILTER</h3>

                            <div class="price-filter">
                                {{-- constant display --}}
                                <div class="price-values">
                                    ₹<span id="min-price">{{ intval($req_min_price) }}</span> –
                                    ₹<span id="max-price">{{ intval($req_max_price) }}</span>
                                </div>

                                <div class="slider">
                                    <div class="progress"></div>
                                </div>

                                <div class="range-input">
                                    <input type="range" name="req_min" id="range-min" min="{{ intval($min_price) }}"
                                        max="{{ intval($max_price) }}" value="{{ intval($req_min_price) }}" step="1"
                                        onchange="filter()">

                                    <input type="range" name="req_max" id="range-max" min="{{ intval($min_price) }}"
                                        max="{{ intval($max_price) }}" value="{{ intval($req_max_price) }}" step="1"
                                        onchange="filter()">

                                    {{-- constant hidden min/max values --}}
                                    <input type="hidden" name="min" value="{{ $min_price }}">
                                    <input type="hidden" name="max" value="{{ $max_price }}">
                                </div>

                                <button type="reset" class="btn reset-btn w-100 mt-2" id="reset-filter">
                                    Reset Filter
                                </button>
                            </div>
                            <input type="hidden" name="sort_by" value="" id="sort-by">
                        </form>
                    </div>

                    <!-- Price Filter -->
                    {{-- <label for="range4" class="form-label">Example range</label>
                    <input type="range" class="form-range" min="0" max="100" value="50" id="range4">
                    <output for="range4" id="rangeValue" aria-hidden="true"></output> --}}

                    <!-- Average Rating -->
                    {{-- <div class="price-filter-container">
                        <h5>Average Rating</h5>
                        <div class="mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="5star">
                                <label class="form-check-label" for="5star">
                                    <div class="rating-stars">
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                        <i class="fas fa-star"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="4star">
                                <label class="form-check-label" for="4star">
                                    <div class="rating-stars empty">
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="1star">
                                <label class="form-check-label" for="1star">
                                    <div class="rating-stars partial">
                                        <i class="fas fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                        <i class="far fa-star"></i>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div> --}}
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="main-content">
                    <!-- Results Header -->
                    <div class="results-header d-flex justify-content-between align-items-center mb-3">
                        <div class="results-text">
                            Showing {{ $products->firstItem() }}–{{ $products->lastItem() }} of {{ $products->total() }}
                            Results
                        </div>
                        <div class="sort-dropdown">
                            <div class="custom-sort-dropdown">
                                <select class="form-select" name="sort_by_value" id="sort_by_value" onchange="filter()">
                                    <option value="">Sort By</option>
                                    <option value="best-selling" @selected($sort_by == "best-selling")>Best selling</option>
                                    <option value="new-arrival" @selected($sort_by == "new-arrival")>New Arrival</option>
                                    <option value="low-to-high" @selected($sort_by == "low-to-high")>Low to High</option>
                                    <option value="high-to-low" @selected($sort_by == "high-to-low")>High to Low</option>
                                    <option value="newest-first" @selected($sort_by == "newest-first")>Newest First</option>
                                    <option value="a-to-z" @selected($sort_by == "a-to-z")>A to Z</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    <div class="row">
                        @foreach ($products as $data)
                            <div class="col-lg-4 col-md-6 col-6 my-3">
                                <div class="card product-card1">
                                    <div class="ratio ratio-4x3 position-relative">
                                        <a href="{{ route('product.details.show', $data->id) }}" class="image-box">
                                            <!-- Main Image -->
                                            <img src="{{ asset($data->product_img) }}"
                                                class="main-img"
                                                alt="{{ $data->product_name }}"
                                                loading="lazy">

                                            <!-- Hover Image -->
                                            <img src="{{ asset($data->proImages->last()->path ?? $data->product_img) }}"
                                                class="hover-img"
                                                alt="Product">
                                        </a>
                                        <div class="product-actions">
                                            @if ($data->isWishlist)
                                                <a href="{{ route('show.wishlist.list') }}"
                                                    class="card-btun btn-sm action text-danger"
                                                    title="Remove from wishlist">
                                                    <i class="bi bi-heart-fill"></i>
                                                </a>
                                            @else
                                                <a href="javascript:void(0)" class="card-btun btn-sm action wishlist-btn"
                                                    data-id="{{ $data->id }}"
                                                    data-url="{{ route('addto.wishlist', $data->id) }}"
                                                    data-login="{{ route('user.login') }}" title="Wishlist">
                                                    <i class="bi bi-heart"></i>
                                                </a>
                                            @endif
                                            <a href="{{ route('product.details.show', $data->id) }}"
                                                class="card-btun btn-sm action" title="Quick view"><i
                                                    class="bi bi-eye"></i></a>
                                            <a href="{{ route('addto.cart', $data->id) }}" class="card-btun btn-sm action"
                                                title="Add to cart"><i class="bi bi-cart"></i></a>
                                        </div>
                                    </div>
                                    <style>
                                        .color_picker .color-dot {
                                            width: 18px;
                                            height: 18px;
                                            border-radius: 50%;
                                            cursor: pointer;
                                            border: 1px solid #ccc;
                                            display: inline-block;
                                        }

                                        .color_picker input[type="radio"]:checked + .color-dot {
                                            border: 2px solid #000;
                                        }
                                    </style>
                                    <div class="card-body p-2">
                                        <p class="card-title small text-truncate-2 mb-1">
                                            {{ \Illuminate\Support\Str::limit($data->product_name, 15) }}
                                        </p>
                                        <div class="price small d-flex align-items-center gap-2 flex-wrap">

                                           @if (!empty($data->orginal_rate) && $data->orginal_rate != $data->offer_price)
                                                <span class="text-danger text-decoration-line-through">
                                                    ₹ {{ $data->orginal_rate }}
                                                </span>
                                            @endif

                                            <span class="text-danger fw-semibold">
                                                ₹ {{ $data->offer_price ?? '-' }}
                                            </span>

                                            @php
                                                $colors = $data->colors;
                                                $selectedColor = request('color') ?? optional($data)->color;
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

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        {{ $products->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>


        </div>
    </div>
    <script type="text/javascript">
        function filter() {
            const sort_by = document.getElementById('sort_by_value').value;
            document.getElementById('sort-by').value = sort_by;
            const min = document.getElementById('range-min').value;
            const max = document.getElementById('range-max').value;
            $('#search-form').submit();
        }
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            const rangeMin = document.getElementById("range-min");
            const rangeMax = document.getElementById("range-max");
            const progress = document.querySelector(".slider .progress");
            const resetBtn = document.getElementById("reset-filter");

            const absoluteMin = parseInt(rangeMin.min);
            const absoluteMax = parseInt(rangeMax.max);
            const minGap = 1;

            function updateSlider(e) {
                let minVal = parseInt(rangeMin.value);
                let maxVal = parseInt(rangeMax.value);

                if (maxVal - minVal <= minGap) {
                    if (e?.target?.id === "range-min") {
                        rangeMin.value = maxVal - minGap;
                        minVal = maxVal - minGap;
                    } else {
                        rangeMax.value = minVal + minGap;
                        maxVal = minVal + minGap;
                    }
                }

                const totalRange = absoluteMax - absoluteMin;
                const percentMin = ((minVal - absoluteMin) / totalRange) * 100;
                const percentMax = ((maxVal - absoluteMin) / totalRange) * 100;

                progress.style.left = percentMin + "%";
                progress.style.right = (100 - percentMax) + "%";
            }

            rangeMin.addEventListener("input", updateSlider);
            rangeMax.addEventListener("input", updateSlider);

            resetBtn.addEventListener("click", (e) => {
                e.preventDefault();
                rangeMin.value = absoluteMin;
                rangeMax.value = absoluteMax;
                updateSlider({
                    target: rangeMin
                });
                document.getElementById('search-form').submit();
            });

            updateSlider({
                target: rangeMin
            });
        });

        function filter() {
            const sort_by = document.getElementById('sort_by_value').value;
            document.getElementById('sort-by').value = sort_by;
            document.getElementById('search-form').submit();
        }

        document.addEventListener("DOMContentLoaded", function() {
            const dropdownBtn = document.querySelector(".custom-dropdown-btn");
            const dropdownList = document.querySelector(".custom-dropdown-list");
            const dropdownItems = document.querySelectorAll(".custom-dropdown-item");
            const selectedText = dropdownBtn.querySelector("span");

            dropdownBtn.addEventListener("click", function() {
                dropdownList.classList.toggle("show");
            });

            dropdownItems.forEach(item => {
                item.addEventListener("click", function(e) {
                    e.preventDefault();
                    dropdownItems.forEach(i => i.classList.remove("active"));
                    this.classList.add("active");
                    selectedText.textContent = this.textContent;
                    dropdownList.classList.remove("show");
                });
            });

            document.addEventListener("click", function(e) {
                if (!dropdownBtn.contains(e.target) && !dropdownList.contains(e.target)) {
                    dropdownList.classList.remove("show");
                }
            });
        });
    </script>

    {{-- <script src="{{ asset('frontend/js/product-detail.js') }}"></script> --}}
@endsection