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
                            <form method="POST" action="{{ route('admin.product.update') }}" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="product_id" value="{{ $product->id }}">


                                <!-- Product Type / Category / Subcategory / Submenu -->
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

                                <!-- Shop By Age / Price -->
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

                                <!-- Product Info -->
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

                                <!-- Pages (Book Only) -->
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

                                <!-- SKU / Prices / Discount -->
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

                                        <!-- Hidden numeric value for DB -->
                                        <input type="hidden" name="discount"
                                            value="{{ old('discount', $product->discount ?? '') }}">
                                    </div>

                                </div>

                                <!-- Images -->
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Thumbnail Image</label>
                                        <input type="file" name="file1" class="form-control image_input"
                                            id="file1" />
                                        <div id="imagePreview">
                                            @if ($product->product_img)
                                                <img src="{{ asset($product->product_img) }}" class="img-thumbnail"
                                                    width="80" />
                                            @endif
                                        </div>
                                        @error('file1')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Gallery Images</label>
                                        <input type="file" name="file2[]" class="form-control image_input"
                                            id="file2" multiple />
                                        <div id="imagePreviews"></div>

                                        <div id="existingGalleryImages">
                                            @php
                                                $galleryImages = App\Models\Upload::where(
                                                    'product_id',
                                                    $product->id,
                                                )->get();
                                            @endphp
                                            @foreach ($galleryImages as $image)
                                                <div class="image-container mb-3">
                                                    <img src="{{ asset($image->path) }}" class="img-thumbnail"
                                                        width="80" />
                                                    <a href="#" class="btn btn-danger delete-image"
                                                        data-id="{{ $image->id }}">Delete</a>
                                                </div>
                                            @endforeach
                                        </div>

                                        @error('file2')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                        @error('file2.*')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="row">
                                    <div class="mb-3 col-md-12">
                                        <label class="form-label">Description</label>
                                        <textarea name="description" class="form-control" id="description" required>{{ old('description', $product->description) }}</textarea>
                                        @error('description')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status -->
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

                                <!-- Flags -->
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
                                <div class="mb-3 col-md-3">
                                    <label class="form-label">Is Color</label>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="iscolor_yes" name="is_color" value="1"
                                            {{ old('is_color', $product->is_color) == '1' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="iscolor_yes">Yes</label>
                                    </div>

                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" id="iscolor_no" name="is_color" value="0"
                                            {{ old('is_color', $product->is_color) == '0' ? 'checked' : '' }}>
                                        <label class="form-check-label" for="iscolor_no">No</label>
                                    </div>
                                </div>
                                
                                @if(isset($product->colors) && $product->colors->isNotEmpty())
                                    <div id="colorWrapper">
                                        @foreach ($product->colors as $index => $productColor)
                                            <div class="row colorSection">
                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Select Colors</label>

                                                    <select class="form-select" name="color[{{ $loop->iteration }}][colors]" required>
                                                        <option value=""> -- select -- </option>
                                                        @foreach(App\Models\Color::all() as $color)
                                                            <option value="{{ $color->id }}"
                                                                {{ $productColor->id == $color->id ? 'selected' : '' }}>
                                                                {{ $color->color }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <div class="mb-3 col-md-4">
                                                    <label class="form-label">Quantity</label>

                                                    <input type="text"
                                                        name="color[{{ $loop->iteration }}][color_quantity]"
                                                        class="form-control"
                                                        value="{{ old("color_quantity.$loop->iteration", $productColor->pivot->qty) }}"
                                                        placeholder="Ex: 2"
                                                        required>
                                                </div>

                                                <div class="mb-3 col-md-2 d-flex align-items-end">
                                                    @if($loop->first)
                                                        <button type="button" class="btn btn-success addRow">+</button>
                                                    @else
                                                        <button type="button" class="btn btn-danger removeRow">−</button>
                                                    @endif
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <div id="colorWrapper">
                                        <div class="row colorSection">
                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Select Colors</label>

                                                <select class="form-select" name="color[1][colors]" >
                                                    <option value=""> -- select -- </option>
                                                    @foreach(App\Models\Color::all() as $color)
                                                        <option value="{{ $color->id }}" {{ old('colors.1') == $color->id ? 'selected' : '' }}> {{ $color->color }}</option>
                                                    @endforeach
                                                </select>

                                                @error('colors.1')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-4">
                                                <label class="form-label">Quantity</label>

                                                <input type="text"
                                                    name="color[1][color_quantity]"
                                                    class="form-control"
                                                    value="{{ old('quantity.1') }}"
                                                    placeholder="Ex: 2" >

                                                @error('quantity.1')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>

                                            <div class="mb-3 col-md-2 d-flex align-items-end">
                                                <button type="button" class="btn btn-success addRow">+</button>
                                            </div>
                                        </div>
                                    </div>
                                @endif

                                <button class="btn btn-primary" type="submit">Update Product</button>
                            </form>
                        </div>
                    </div>
                </div>
                <br><br><br>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.16.2/standard/ckeditor.js"></script>
<script>
    $(document).ready(function () {

        // CKEditor
        CKEDITOR.replace('description');

        let selectedCategory    = "{{ $selectedCategory }}";
        let selectedSubcategory = "{{ $selectedSubcategory }}";
        let selectedSubmenu     = "{{ $selectedSubmenu }}";

        /* ===============================
        LOAD SUBCATEGORIES
        =============================== */
        function loadSubcategories(categoryId, selectedId = null) {
            if (!categoryId) {
                $('#subcategory').html('<option value="">Please select</option>');
                $('#submenu').html('<option value="">Please select</option>');
                return;
            }

            $.ajax({
                url: "{{ route('get-subcategories', ':id') }}".replace(':id', categoryId),
                type: "GET",
                success: function (response) {
                    let html = '<option value="">Please select</option>';
                    $.each(response, function (id, name) {
                        html += `<option value="${id}" ${id == selectedId ? 'selected' : ''}>${name}</option>`;
                    });
                    $('#subcategory').html(html);

                    if (selectedId) {
                        loadSubmenus(selectedId, selectedSubmenu);
                    }
                }
            });
        }

        /* ===============================
        LOAD SUBMENUS
        =============================== */
        function loadSubmenus(subcategoryId, selectedId = null) {
            if (!subcategoryId) {
                $('#submenu').html('<option value="">Please select</option>');
                return;
            }

            $.ajax({
                url: "{{ route('get-submenu', ':id') }}".replace(':id', subcategoryId),
                type: "GET",
                success: function (response) {
                    let html = '<option value="">Please select</option>';
                    $.each(response, function (id, name) {
                        html += `<option value="${id}" ${id == selectedId ? 'selected' : ''}>${name}</option>`;
                    });
                    $('#submenu').html(html);
                }
            });
        }

        /* ===============================
        ON PAGE LOAD (EDIT + VALIDATION)
        =============================== */
        if (selectedCategory) {
            loadSubcategories(selectedCategory, selectedSubcategory);
        }

        /* ===============================
        ON CHANGE EVENTS
        =============================== */
        $('#category').on('change', function () {
            loadSubcategories(this.value);
        });

        $('#subcategory').on('change', function () {
            loadSubmenus(this.value);
        });

        /* ===============================
        PRODUCT TYPE → PAGES
        =============================== */
        $('#product_type').on('change', function () {
            if ($(this).val() === 'book') {
                $('#pages_row').removeClass('d-none');
            } else {
                $('#pages_row').addClass('d-none');
            }
        });

        /* ===============================
        DISCOUNT CALCULATION
        =============================== */
        $('[name="actual_price"], [name="offer_price"]').on('input', function () {
            let actual = parseFloat($('[name="actual_price"]').val()) || 0;
            let offer  = parseFloat($('[name="offer_price"]').val()) || 0;

            if (offer > 0 && offer < actual) {
                let discount = ((actual - offer) / actual * 100).toFixed(0);

                $('#discount_text').val(discount);     // UI
                $('[name="discount"]').val(discount);  // DB
            } else {
                $('#discount_text').val('');
                $('[name="discount"]').val('');
            }
        });


        $(document).on('click', '.delete-image', function() {
            var imageId = $(this).data('id');
            var imageContainer = $(this).closest('.image-container');

            $.ajax({
                type: "POST",
                url: "{{ route('admin.product.image.delete') }}",
                data: {
                    id: imageId,
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    imageContainer.remove();
                },
                error: function(xhr, status, error) {
                    console.error("AJAX error:", status, error);
                    alert('Error deleting image.');
                }
            });
        });
        // ADD ROW
        $(document).on('click', '.addRow', function () {

            let index = $('.colorSection').length;
            index++;
            let html = `
            <div class="row colorSection mt-2">
                <div class="mb-3 col-md-4">
                    <label class="form-label">Select Colors</label>
                    <select class="form-control" name="color[${index}][colors]" required>
                        @foreach(App\Models\Color::all() as $color)
                            <option value="{{ $color->id }}">{{ $color->color }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-3 col-md-4">
                    <label class="form-label">Quantity</label>
                    <input type="text"
                        name="color[${index}][color_quantity]"
                        class="form-control"
                        placeholder="Ex: 2" required>
                </div>

                <div class="mb-3 col-md-2 d-flex align-items-end">
                    <button type="button" class="btn btn-danger removeRow">−</button>
                </div>
            </div>
            `;

            $('#colorWrapper').append(html);
        });

        // REMOVE ROW
        $(document).on('click', '.removeRow', function () {
            $(this).closest('.colorSection').remove();
        });
    });
</script>
<script>
    $(document).ready(function () {

        function toggleColorSection() {
            if ($('input[name="is_color"]:checked').val() == '1') {
                $('#colorWrapper').show();
            } else {
                $('#colorWrapper').hide();
            }
        }

        toggleColorSection(); // initial check on page load

        $('input[name="is_color"]').on('change', function () {
            toggleColorSection();
        });

    });
</script>

@endsection