@extends('admin.index')
@section('admin')
    @if (session('success'))
        <div id="successAlert" class="alert alert-success">
            {{ session('success') }}
        </div>
        <script>
            setTimeout(function() {
                $('#successAlert').fadeOut('fast');
            }, 3000);
        </script>
    @endif

    @php
        $selectedCategory = old('category_id', $product->category_id);
        $selectedSubcategory = old('subcategory', $product->subcategory);
        $selectedSubmenu = old('submenu', $product->sub_menu_id);
        $selectedAges = old('shop_by_age_id', isset($product) ? $product->shopByAges->pluck('id')->toArray() : []);
    @endphp

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.css" />

    <style>
        /* Force Modal Dimensions */
        #uploadimageModal .modal-dialog {
            max-width: 460px !important;
            margin: 50px auto !important;
            display: flex !important;
            align-items: center !important;
        }

        #uploadimageModal .modal-content {
            width: 100% !important;
            border-radius: 12px !important;
            border: none !important;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25) !important;
            background: #ffffff !important;
        }

        #uploadimageModal .modal-body {
            padding: 25px !important;
            position: relative !important;
        }

        /* Croppie Container Base */
        .croppie-container {
            padding: 0 !important;
            margin: 0 auto !important;
            display: block !important;
            width: 100% !important;
        }

        .croppie-container .cr-boundary {
            margin: 0 auto !important;
            background: #111111 !important;
            border-radius: 8px !important;
            position: relative !important;
        }

        .croppie-container .cr-viewport {
            box-shadow: 0 0 0 2000px rgba(0, 0, 0, 0.65) !important;
            border: 2px solid #ffffff !important;
        }

        /* CRITICAL FIX: Slider Container and Handle Alignment */
        .croppie-container .cr-slider-wrap {
            margin: 25px auto 10px auto !important;
            width: 85% !important;
            display: block !important;
            position: relative !important;
            text-align: center !important;
            float: none !important;
            clear: both !important;
        }

        /* Resetting any admin panel range layout breaks */
        .croppie-container input[type="range"].cr-slider {
            width: 100% !important;
            max-width: 100% !important;
            display: block !important;
            margin: 0 auto !important;
            padding: 0 !important;
            cursor: pointer !important;
            -webkit-appearance: slider-horizontal !important;
            appearance: slider-horizontal !important;
        }

        /* Modal Close Button */
        .btn-cropclose {
            position: absolute;
            top: 12px;
            right: 12px;
            z-index: 9999;
            cursor: pointer;
            transition: transform 0.2s;
        }

        .btn-cropclose:hover {
            transform: scale(1.15);
        }
    </style>

    <div class="profile-tab">
        <div class="custom-tab-1">
            <ul class="nav nav-tabs">
                <li class="nav-item">
                    <a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">EDIT PRODUCT</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-3">
                        <div class="settings-form">
                            <form method="POST" id="productForm" action="{{ route('admin.product.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">

                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Select Type</label>
                                        <select class="default-select form-control wide" id="product_type"
                                            name="product_type">
                                            <option value="">Please select</option>
                                            <option value="book" {{ 'book' == $product->type ? 'selected' : '' }}>Book
                                            </option>
                                            <option value="toys" {{ 'toys' == $product->type ? 'selected' : '' }}>Toys
                                            </option>
                                            <option value="school_essentials"
                                                {{ 'school_essentials' == $product->type ? 'selected' : '' }}>School
                                                Essentials</option>
                                        </select>
                                        @error('product_type')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select class="default-select form-control wide" id="category" name="category_id">
                                            <option value="">Please select</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $selectedCategory ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">SubCategory</label>
                                        <select class="form-control wide" id="subcategory" name="subcategory">
                                            <option value="">Please select</option>
                                        </select>
                                        @error('subcategory')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Sub Menu</label>
                                        <select class="form-control" id="submenu" name="submenu">
                                            <option value="">Please select</option>
                                        </select>
                                        @error('submenu')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label d-block">Select Shop By Age</label>
                                        @php $shop_by_ages = App\Models\ShopByAge::get(); @endphp
                                        <div class="row">
                                            @foreach ($shop_by_ages as $shop_by_age)
                                                <div class="col-md-6">
                                                    <div class="form-check">
                                                        <input class="form-check-input" type="checkbox"
                                                            name="shop_by_age_id[]" id="age_{{ $shop_by_age->id }}"
                                                            value="{{ $shop_by_age->id }}"
                                                            {{ in_array($shop_by_age->id, $selectedAges ?? []) ? 'checked' : '' }}>
                                                        <label class="form-check-label" for="age_{{ $shop_by_age->id }}">
                                                            {{ $shop_by_age->title }}
                                                        </label>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        @error('shop_by_age_id')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Select Shop By Price</label>
                                        @php $shop_by_prices = App\Models\ShopByPrice::get(); @endphp
                                        <select class="form-control wide" id="shop_by_price" name="shop_by_price" required>
                                            <option value="">Please select</option>
                                            @foreach ($shop_by_prices as $shop_by_price)
                                                <option value="{{ $shop_by_price->id }}"
                                                    {{ $shop_by_price->id == $product->shop_by_price_id ? 'selected' : '' }}>
                                                    {{ $shop_by_price->title }}
                                                </option>
                                            @endforeach
                                        </select>
                                        @error('shop_by_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Product Name</label>
                                        <input type="text" name="product_name" class="form-control"
                                            value="{{ old('product_name', $product->product_name) }}">
                                        @error('product_name')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Quantity</label>
                                        <input type="text" name="quantity" class="form-control"
                                            value="{{ old('quantity', $product->quantity) }}">
                                        @error('quantity')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row {{ old('pages') || $product->type == 'book' ? '' : 'd-none' }}"
                                    id="pages_row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">No of Pages</label>
                                        <input type="number" name="pages" class="form-control"
                                            placeholder="Ex: 120 Pages" value="{{ old('pages', $product->no_of_pages) }}"
                                            {{ $product->type == 'book' ? 'required' : '' }}>
                                        @error('pages')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">SKU</label>
                                        <input type="text" name="sku" class="form-control"
                                            value="{{ $product->sku }}" required>
                                        @error('sku')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Actual Price</label>
                                        <input type="number" name="actual_price" class="form-control"
                                            value="{{ old('actual_price', $product->orginal_rate) }}">
                                        @error('actual_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Offer Price</label>
                                        <input type="number" name="offer_price" class="form-control"
                                            value="{{ old('offer_price', $product->offer_price) }}">
                                        @error('offer_price')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-3">
                                        <label class="form-label">Discount</label>
                                        <div class="input-group">
                                            <input type="text" id="discount_text" class="form-control" readonly
                                                value="{{ old('discount', $product->discount ?? '') }}">
                                            <span class="input-group-text">%</span>
                                        </div>
                                        <input type="hidden" name="discount"
                                            value="{{ old('discount', $product->discount ?? '') }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Thumbnail Image</label>
                                        <!-- Added name attribute -->
                                        <input type="file" id="file1" name="file1" class="form-control"
                                            accept="image/*">
                                        <div id="imagePreview" class="mt-2">
                                            @if ($product->product_img)
                                                <img src="{{ asset($product->product_img) }}" class="img-thumbnail"
                                                    width="120">
                                            @endif
                                        </div>
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Gallery Images</label>
                                        <!-- Changed id to match validation name if multi-upload -->
                                        <input type="file" class="form-control" id="file2" name="file2[]"
                                            multiple accept="image/*" />
                                        <div id="imagePreviews" class="mt-2"></div>

                                        <div id="existingGalleryImages" class="mt-3">
                                            @php
                                                $galleryImages = App\Models\Upload::where(
                                                    'product_id',
                                                    $product->id,
                                                )->get();
                                            @endphp
                                            @foreach ($galleryImages as $image)
                                                <div class="image-container mb-3 gallery-item">
                                                    <img src="{{ asset($image->path) }}" class="img-thumbnail"
                                                        width="80" />
                                                    <a href="#" class="btn btn-danger remove-old-gallery"
                                                        data-id="{{ $image->id }}">Delete</a>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description" required>{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Key Words</label>
                                        <textarea name="keyword" class="form-control" id="keyword" rows="3">{{ old('keyword', $product->keyword) }}</textarea>
                                        @error('keyword')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="active"
                                                value="1" {{ old('status', $product->status) == 1 ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inactive"
                                                value="0" {{ old('status', $product->status) == 0 ? 'checked' : '' }}
                                                required>
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <br>
                                <input type="checkbox" id="best_sellers" name="best_sellers" value="1"
                                    {{ old('best_sellers', $product->best_sellers) == 1 ? 'checked' : '' }}>
                                <label for="best_sellers"> Best Sellers</label><br>
                                <input type="checkbox" id="new_arrival" name="new_arrival" value="1"
                                    {{ old('new_arrival', $product->new_arrival) == 1 ? 'checked' : '' }}>
                                <label for="new_arrival"> New Arrival</label><br>
                                <input type="checkbox" id="on_sale" name="on_sale" value="1"
                                    {{ old('on_sale', $product->on_sale) == 1 ? 'checked' : '' }}>
                                <label for="on_sale"> On Sale</label><br>
                                <input type="checkbox" id="featured" name="featured" value="1"
                                    {{ old('featured', $product->featured) == 1 ? 'checked' : '' }}>
                                <label for="featured"> Featured</label><br><br>

                                <div class="row">
    {{-- Is Color Radio Selection --}}
    <div class="mb-3 col-md-3">
        <label class="form-label fw-bold">Is Color?</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="iscolor_yes" name="is_color" value="1"
                    {{ old('is_color', $product->is_color) == '1' ? 'checked' : '' }}>
                <label class="form-check-label" for="iscolor_yes">Yes</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="iscolor_no" name="is_color" value="0"
                    {{ old('is_color', $product->is_color) == '0' ? 'checked' : '' }}>
                <label class="form-check-label" for="iscolor_no">No</label>
            </div>
        </div>
    </div>

    {{-- Option Type Selection: Dynamic wrapper display logic configured inline based on data value --}}
    <div class="mb-3 col-md-4" id="optionTypeWrapper" style="{{ old('is_color', $product->is_color) == '1' ? '' : 'display: none;' }}">
        <label class="form-label fw-bold">Option Type</label>
        <div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="option_color" name="option_type" value="color"
                    {{ old('option_type', $product->option_type ?? 'color') == 'color' ? 'checked' : '' }}>
                <label class="form-check-label" for="option_color">Color Only</label>
            </div>
            <div class="form-check form-check-inline">
                <input class="form-check-input" type="radio" id="option_variant" name="option_type" value="variant"
                    {{ old('option_type', $product->option_type) == 'variant' ? 'checked' : '' }}>
                <label class="form-check-label" for="option_variant">Variant</label>
            </div>
        </div>
    </div>
</div>

{{-- Main Color Elements Wrapper --}}
<div id="colorWrapper" style="{{ old('is_color', $product->is_color) == '1' ? '' : 'display: none;' }}">
    @if(isset($productVariants) && $productVariants->isNotEmpty())
        @foreach ($productVariants as $variant)
            <div class="row colorSection mb-2">
                {{-- Select Color Field --}}
                <div class="mb-3 col-md-3">
                    <label class="form-label">Select Colors</label>
                    <select class="form-select color-select" name="color[{{ $loop->iteration }}][colors]">
                        <option value=""> -- select -- </option>
                        @foreach(App\Models\Color::all() as $color)
                            <option value="{{ $color->id }}" {{ $variant->color_id == $color->id ? 'selected' : '' }}> 
                                {{ $color->color }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Variant Name Field: Inline style checks whether current product type option is variant --}}
                <div class="mb-3 col-md-3 variant-wrapper" style="{{ old('option_type', $product->option_type) == 'variant' ? '' : 'display: none;' }}">
                    <label class="form-label">Variant Name</label>
                    <input type="text" name="color[{{ $loop->iteration }}][variant_name]" class="form-control variant-input" 
                           value="{{ old('color.'.$loop->iteration.'.variant_name', $variant->variant_name ?? '') }}" placeholder="Ex: Premium, Pack-2">
                </div>

                {{-- Quantity Field --}}
                <div class="mb-3 col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="text" name="color[{{ $loop->iteration }}][color_quantity]" class="form-control color-qty" 
                           value="{{ old('color.'.$loop->iteration.'.color_quantity', $variant->qty ?? '') }}" placeholder="Ex: 2">
                </div>

                {{-- Row Controls Button --}}
                <div class="mb-3 col-md-2 d-flex align-items-end">
                    @if($loop->first)
                        <button type="button" class="btn btn-success addRow">+</button>
                    @else
                        <button type="button" class="btn btn-danger removeRow">−</button>
                    @endif
                </div>
            </div>
        @endforeach
    @else
        {{-- Default blank fallback row layout pattern --}}
        <div class="row colorSection mb-2">
            <div class="mb-3 col-md-3">
                <label class="form-label">Select Colors</label>
                <select class="form-select color-select" name="color[1][colors]">
                    <option value=""> -- select -- </option>
                    @foreach(App\Models\Color::all() as $color)
                        <option value="{{ $color->id }}"> {{ $color->color }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3 col-md-3 variant-wrapper" style="display: none;">
                <label class="form-label">Variant Name</label>
                <input type="text" name="color[1][variant_name]" class="form-control variant-input" placeholder="Ex: Premium, Pack-2">
            </div>

            <div class="mb-3 col-md-3">
                <label class="form-label">Quantity</label>
                <input type="text" name="color[1][color_quantity]" class="form-control color-qty" placeholder="Ex: 2">
            </div>

            <div class="mb-3 col-md-2 d-flex align-items-end">
                <button type="button" class="btn btn-success addRow">+</button>
            </div>
        </div>
    @endif
</div>

                                <button class="btn btn-primary" type="submit">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br><br><br>
            </div>
        </div>
    </div>

    <div id="uploadimageModal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true"
        data-bs-backdrop="static">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="javascript:void(0)" onclick="modalclose();" class="btn-cropclose">
                        <img src="https://icones.pro/wp-content/uploads/2022/05/icone-fermer-et-x-rouge.png"
                            width="23">
                    </a>
                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="image_demo"></div>
                        </div>
                        <div class="col-md-12 text-center mt-3">
                            <button type="button" class="btn btn-success crop_image px-4">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
<script>
    $(document).ready(function() {
        // Thumbnail Preview logic
        $('#file1').change(function() {
            if (this.files && this.files[0]) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    $('#imagePreview').html('<img src="' + e.target.result +
                        '" class="img-thumbnail" width="120">');
                }
                reader.readAsDataURL(this.files[0]);
            }
        });

        // Gallery Multiple Images Preview logic
        $('#file2').change(function() {
            $('#imagePreviews').html(''); // Clear previous previews
            if (this.files) {
                Array.from(this.files).forEach(file => {
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        $('#imagePreviews').append(`
                            <div class="position-relative d-inline-block m-2">
                                <img src="${e.target.result}" class="img-thumbnail" style="width:120px;height:120px;object-fit:cover;">
                            </div>
                        `);
                    }
                    reader.readAsDataURL(file);
                });
            }
        });

        // Remove old gallery image logic
        $(document).on('click', '.remove-old-gallery', function(e) {
            e.preventDefault();
            if (!confirm('Delete this image permanently from database?')) return;
            let imageId = $(this).data('id');
            $('<input>').attr({
                type: 'hidden',
                name: 'delete_gallery[]',
                value: imageId
            }).appendTo('#productForm');
            $(this).closest('.gallery-item').remove();
        });
    });
</script>

<script>
    $(document).ready(function() {
        // --- CKEditor Initializer ---
        CKEDITOR.replace('description');

        // --- Category Dependent Cascades ---
        let selectedCategory = "{{ $selectedCategory ?? '' }}";
        let selectedSubcategory = "{{ $selectedSubcategory ?? '' }}";
        let selectedSubmenu = "{{ $selectedSubmenu ?? '' }}";

        function loadSubcategories(categoryId, selectedId = null) {
            if (!categoryId) {
                $('#subcategory').html('<option value="">Please select</option>');
                $('#submenu').html('<option value="">Please select</option>');
                return;
            }
            $.ajax({
                url: "{{ route('get-subcategories', ':id') }}".replace(':id', categoryId),
                type: "GET",
                success: function(response) {
                    let html = '<option value="">Please select</option>';
                    $.each(response, function(id, name) {
                        html += `<option value="${id}" ${id == selectedId ? 'selected' : ''}>${name}</option>`;
                    });
                    $('#subcategory').html(html);
                    if (selectedId) {
                        loadSubmenus(selectedId, selectedSubmenu);
                    }
                }
            });
        }

        function loadSubmenus(subcategoryId, selectedId = null) {
            if (!subcategoryId) {
                $('#submenu').html('<option value="">Please select</option>');
                return;
            }
            $.ajax({
                url: "{{ route('get-submenu', ':id') }}".replace(':id', subcategoryId),
                type: "GET",
                success: function(response) {
                    let html = '<option value="">Please select</option>';
                    $.each(response, function(id, name) {
                        html += `<option value="${id}" ${id == selectedId ? 'selected' : ''}>${name}</option>`;
                    });
                    $('#submenu').html(html);
                }
            });
        }

        if (selectedCategory) {
            loadSubcategories(selectedCategory, selectedSubcategory);
        }

        $('#category').on('change', function() { loadSubcategories(this.value); });
        $('#subcategory').on('change', function() { loadSubmenus(this.value); });

        // --- Product Form Structural Toggles ---
        $('#product_type').on('change', function() {
            if ($(this).val() === 'book') {
                $('#pages_row').removeClass('d-none');
            } else {
                $('#pages_row').addClass('d-none');
            }
        });

        // --- Price & Discount Automation Rule ---
        $('[name="actual_price"], [name="offer_price"]').on('input', function() {
            let actual = parseFloat($('[name="actual_price"]').val()) || 0;
            let offer = parseFloat($('[name="offer_price"]').val()) || 0;
            if (offer > 0 && offer < actual) {
                let discount = ((actual - offer) / actual * 100).toFixed(0);
                $('#discount_text').val(discount);
                $('[name="discount"]').val(discount);
            } else {
                $('#discount_text').val('');
                $('[name="discount"]').val('');
            }
        });


        // =========================================================================
        // ADD FORM MAARI RECONFIGURED EDIT COLOR/VARIANT SYSTEM LOGIC 
        // =========================================================================

        // 1. Core Wrapper Handler (Is Color Toggle with Safe Field Control Rules)
        function toggleColorSection() {
            const isColor = $('input[name="is_color"]:checked').val() === '1';

            if (isColor) {
                $('#optionTypeWrapper').show();
                $('#colorWrapper').show();

                $('.color-select, .color-qty').each(function () {
                    this.disabled = false;
                });

                // Option yes-na variant status automatic synchroniser script call run aagum
                toggleVariantFields();
            } else {
                $('#optionTypeWrapper').hide();
                $('#colorWrapper').hide();

                $('.color-select, .color-qty, .variant-input').each(function () {
                    this.disabled = true;
                    this.value = '';
                });

                $('input[name="option_type"]').prop('checked', false);
                
                // Edit pagela cascade clear dynamic break aagama iruka, first element ah standard ah backp panrom
                $('.colorSection').not(':first').remove();
                $('.variant-wrapper').hide();
            }
        }

        // 2. Option Type Live Field Switcher (Required and Disabled controller toggle)
        function toggleVariantFields() {
            const optionType = $('input[name="option_type"]:checked').val();

            if (optionType === 'variant') {
                $('.variant-wrapper').show();
                $('.variant-input').prop('required', true).prop('disabled', false);
            } else {
                $('.variant-wrapper').hide();
                $('.variant-input').prop('required', false).prop('disabled', true).val('');
            }
        }

        // 3. DYNAMIC ADD NEW ROW (+) LOGIC WITH INTEGRATED EDIT MATRIX CONFIG
        $(document).on('click', '.addRow', function () {
            let index = $('.colorSection').length + 1; // Explicit secure index computation
            
            const currentOptionType = $('input[name="option_type"]:checked').val();
            const displayStyle = (currentOptionType === 'variant') ? 'block' : 'none';
            const isRequired = (currentOptionType === 'variant') ? 'required' : '';
            const isDisabled = (currentOptionType === 'variant') ? '' : 'disabled';

            let html = `
            <div class="row colorSection mt-2">
                <div class="mb-3 col-md-3">
                    <label class="form-label">Select Colors</label>
                    <select class="form-control color-select" name="color[${index}][colors]">
                        <option value=""> -- select -- </option>
                        @foreach(App\Models\Color::all() as $color)
                            <option value="{{ $color->id }}">{{ $color->color }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-3 variant-wrapper" style="display: ${displayStyle};">
                    <label class="form-label">Variant Name</label>
                    <input type="text" name="color[${index}][variant_name]" class="form-control variant-input" placeholder="Ex: Premium" ${isRequired} ${isDisabled}>
                </div>

                <div class="mb-3 col-md-3">
                    <label class="form-label">Quantity</label>
                    <input type="text" name="color[${index}][color_quantity]" class="form-control color-qty" placeholder="Ex: 2" required>
                </div>

                <div class="mb-3 col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removeRow">−</button>
                </div>
            </div>`;

            $('#colorWrapper').append(html);
        }); 

        // 4. DYNAMIC REMOVE ROW (-) LOGIC
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.colorSection').remove();
        });

        // Event Watchers Configuration Wire up
        toggleColorSection(); 
        $('input[name="is_color"]').on('change', toggleColorSection);
        $('input[name="option_type"]').on('change', toggleVariantFields);
    });
</script>
@endsection
