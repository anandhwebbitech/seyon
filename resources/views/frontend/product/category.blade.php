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

        .product-card1 {
            width: 100%;
            position: relative;
            overflow: hidden;
        }

        .image-box {
            display: block;
            width: 100%;
            height: 100%;
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

        .hover-img {
            opacity: 0;
            transform: scale(1.05);
        }

        .image-box:hover .hover-img {
            opacity: 1;
            transform: scale(1);
        }

        .image-box:hover .main-img {
            opacity: 0;
            transform: scale(1.05);
        }

        .color_picker .color-dot {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            cursor: pointer;
            border: 1px solid #ccc;
            display: inline-block;
        }

        /* AJAX loading animation */
        #product-container {
            transition: opacity 0.3s ease-in-out;
        }
    </style>

    <div class="container-fluid container py-4">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3">
                <div class="sidebar">
                    <div class="price-filter-container">
                        <h3>Product Categories</h3>
                        <form class="mb-4" id="search-form" action="" method="GET">
                            <div class="col-12 col-md-6 col-lg-12">
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
                                <div class="price-values">
                                    ₹<span id="min-price">{{ intval($req_min_price) }}</span> –
                                    ₹<span id="max-price">{{ intval($req_max_price) }}</span>
                                </div>

                                <div class="slider">
                                    <div class="progress"></div>
                                </div>

                                <div class="range-input">
                                    <input type="range" name="req_min" id="range-min" min="50" max="9999"
                                        value="{{ intval($req_min_price) }}" step="1" onchange="filter()">

                                    <input type="range" name="req_max" id="range-max" min="50" max="9999"
                                        value="{{ intval($req_max_price) }}" step="1" onchange="filter()">

                                    <input type="hidden" name="min" value="50">
                                    <input type="hidden" name="max" value="9999">
                                    <input type="hidden" name="shop_by_price_id" value="{{ $shop_by_price_id ?? '' }}">
                                </div>

                                <button type="button" class="btn reset-btn w-100 mt-2" id="reset-filter">
                                    Reset Filter
                                </button>
                            </div>

                            <input type="hidden" name="sort_by" value="{{ $sort_by }}" id="sort-by">
                            <input type="hidden" name="search" value="{{ $search }}">
                        </form>
                    </div>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9">
                <div class="main-content">
                    <!-- Results Header -->
                    <div class="results-header d-flex justify-content-between align-items-center mb-3">
                        <div class="results-text" id="results-count-text">
                            Showing {{ $products->firstItem() ?? 0 }}–{{ $products->lastItem() ?? 0 }} of
                            {{ $products->total() }}
                            Results
                        </div>
                        <div class="sort-dropdown">
                            <div class="custom-sort-dropdown">
                                <select class="form-select" name="sort_by_value" id="sort_by_value" onchange="filter()">
                                    <option value="">Sort By</option>
                                    <option value="best-selling" @selected($sort_by == 'best-selling')>Best selling</option>
                                    <option value="new-arrival" @selected($sort_by == 'new-arrival')>New Arrival</option>
                                    <option value="low-to-high" @selected($sort_by == 'low-to-high')>Low to High</option>
                                    <option value="high-to-low" @selected($sort_by == 'high-to-low')>High to Low</option>
                                    <option value="newest-first" @selected($sort_by == 'newest-first')>Newest First</option>
                                    <option value="a-to-z" @selected($sort_by == 'a-to-z')>A to Z</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Dynamic Product Grid Area -->
                    <div id="product-container">
                        @include('frontend.product.partials.product_list', ['products' => $products])
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="text/javascript">
        // Global Filter Function using AJAX
        function filter(page = 1) {
            const sort_by = document.getElementById('sort_by_value').value;
            document.getElementById('sort-by').value = sort_by;

            let formData = $('#search-form').serialize();
            formData += '&page=' + page;

            // Fade Effect while loading
            $('#product-container').css('opacity', '0.4');

            $.ajax({
                url: window.location.pathname,
                type: "GET",
                data: formData,
                success: function(response) {
                    $('#product-container').html(response.html).css('opacity', '1');
                    if (response.total_text) {
                        $('#results-count-text').text(response.total_text);
                    }
                },
                error: function() {
                    $('#product-container').css('opacity', '1');
                    alert('Failed to fetch products. Please try again.');
                }
            });
        }

        // Handle Pagination click without reload
        $(document).on('click', '.pagination a', function(e) {
            e.preventDefault();
            let page = $(this).attr('href').split('page=')[1];
            filter(page);
        });

        // Price Slider logic
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

                document.getElementById('min-price').innerText = minVal;
                document.getElementById('max-price').innerText = maxVal;

                const totalRange = absoluteMax - absoluteMin;
                const percentMin = totalRange > 0 ? ((minVal - absoluteMin) / totalRange) * 100 : 0;
                const percentMax = totalRange > 0 ? ((maxVal - absoluteMin) / totalRange) * 100 : 100;

                progress.style.left = percentMin + "%";
                progress.style.right = (100 - percentMax) + "%";
            }

            rangeMin.addEventListener("input", updateSlider);
            rangeMax.addEventListener("input", updateSlider);

            resetBtn.addEventListener("click", (e) => {
                e.preventDefault();

                // Uncheck checkboxes
                $('#search-form input[type="checkbox"]').prop('checked', false);

                // Reset Price Slider
                rangeMin.value = absoluteMin;
                rangeMax.value = absoluteMax;

                // Reset Sort Dropdown
                document.getElementById('sort_by_value').value = '';
                document.getElementById('sort-by').value = '';

                updateSlider({
                    target: rangeMin
                });
                filter();
            });

            updateSlider({
                target: rangeMin
            });
        });
    </script>
@endsection
