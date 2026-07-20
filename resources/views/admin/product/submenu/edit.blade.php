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

    <div class="profile-tab">
        <div class="custom-tab-1">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                        class="nav-link active show">EDIT SUB MENU</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-3">
                        <div class="settings-form">
                            <form method="POST" id="subcategory-form"
                                action="{{ route('admin.product.submenu.update',$submenu->id) }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Menu Name</label>
                                        <input type="text" name="name" class="form-control" value="{{ $submenu->name }}" required>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Category</label>
                                        <select class="form-control" id="category" name="category_id" required>
                                            <option value="">Please select</option>
                                            @php $categories = App\Models\ProductCategory::get(); @endphp
                                            @if ($categories)
                                                @foreach ($categories as $category)
                                                    <option value="{{ $category->id }}" @selected($submenu->category_id == $category->id)>{{ $category->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">SubCategory</label>
                                        <select class="form-control" id="subcategory" name="subcategory" required>
                                            <option value="" data-display="Select">Please select</option>
                                            @foreach ($subcategories as $subcategory)
                                                <option value="{{ $subcategory->id }}" @selected($submenu->subcategory_id == $subcategory->id)>{{ $subcategory->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('subcategory')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="active"
                                                value="1" checked>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inactive"
                                                value="0">
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <button class="btn btn-primary" type="submit">Update Menu</button>
                            </form>
                        </div>
                    </div>
                </div> <br><br><br>
            </div>
        </div>
    </div>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

<script type="text/javascript">
    $(document).ready(function () {
        var selectedCategory = "{{ old('category', $selectedCategory ?? '') }}";
        var selectedSubcategory = "{{ old('subcategory', $selectedSubcategory ?? '') }}";

        function loadSubcategories(category_id, selectedSubcategory = null) {
            if (category_id) {
                $.ajax({
                    type: "GET",
                    url: "{{ route('get-subcategories', ['id' => ':category_id']) }}".replace(':category_id', category_id),
                    success: function (data) {
                        var $subcategory = $('select[name="subcategory"]');
                        $subcategory.empty().append('<option value="">Please select</option>');

                        $.each(data, function (key, value) {
                            var isSelected = (key == selectedSubcategory) ? 'selected' : '';
                            $subcategory.append('<option value="' + key + '" ' + isSelected + '>' + value + '</option>');
                        });
                    },
                    error: function (xhr, status, error) {
                        console.error("AJAX error:", status, error);
                    }
                });
            } else {
                $('select[name="subcategory"]').empty().append('<option value="">Please select</option>');
            }
        }

        $('#category').change(function () {
            var category_id = $(this).val();
            loadSubcategories(category_id);
        });

        if (selectedCategory) {
            $('#category').val(selectedCategory);
            loadSubcategories(selectedCategory, selectedSubcategory);
        }
    });
</script>
<script>
    $(document).ready(function() {
        $('#subcategory_image').on('change', function(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').removeClass('d-none').attr('src', e.target.result).show();
            };
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        });
    });
</script>
