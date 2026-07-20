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

    <style>
        .img-postion {
            position: relative;
            display: inline-block;
        }

        .delete-icon {
            position: absolute;
            top: -7px;
            right: -7px;
            font-size: 20px;

        }
        .delete-icon a {
            color: red;
        }
    </style>

    <div id="uploadimageModal" class="modal" role="dialog">
        <div class="modal-dialog cropimg">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="Javascript:void" class="btn-cropclose" onclick="modalclose();"><img
                            src="https://icones.pro/wp-content/uploads/2022/05/icone-fermer-et-x-rouge.png"
                            width="25px"></a>

                    <div class="row">
                        <div class="col-md-12 text-center">
                            <div id="image_demo" style="width:100%;"></div>
                        </div>
                        <input type="hidden" id="idval">
                        <div class="col-md-12 text-center mb-1">
                            <button type="button" class="btn btn-success crop_image">Upload</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="profile-tab">
        <div class="custom-tab-1">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab"
                        class="nav-link active show">SUBCATEGORY</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-3">
                        <div class="settings-form">
                            <form method="POST" action="{{ route('admin.product.subcategory.update') }}"
                                enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="subcategory_id" class="form-control"
                                    value="{{ $subcategory->id }}">
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Category</label>
                                        <select class="form-control" id="category" name="category_id"
                                            required>
                                            <option value="">Please select</option>
                                            @php $categories = App\Models\ProductCategory::get(); @endphp
                                            @if ($categories)
                                                @foreach ($categories as $cat)
                                                    <option value="{{ $cat->id }}"
                                                        @if ($cat->id == $subcategory->category_id) selected @endif>
                                                        {{ $cat->name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">SubCategory</label>
                                        <input type="text" name="name" class="form-control"
                                            value="{{ $subcategory->name }}" required>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">SubCategory Image (Size: 300 × 300 px, Max file size: 1 MB)</label>
                                        <input type="file" name="subcategory_image" class="form-control" id="subcategory_image" accept="image/*" required>
                                        <br>
                                        <img id="previewImage" 
                                            src="{{ $subcategory->subcategory_image ? asset($subcategory->subcategory_image) : '#' }}" 
                                            alt="Preview Image" 
                                            class="img-thumbnail" 
                                            width="100" 
                                            @if(!$subcategory->subcategory_image) style="display: none;" @endif>
                                    </div>
                                </div>
                                <div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="active"
                                                value="1" {{ $subcategory->status == 1 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inactive"
                                                value="0" {{ $subcategory->status == 0 ? 'checked' : '' }}>
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                    </div>
                                </div>
                                <br>

                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>
                        </div>
                    </div>
                </div> <br><br><br>
            </div>
        </div>
    </div>
@endsection
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

<script>
    $(document).ready(function() {
        $('#subcategory_image').on('change', function(event) {
            const input = event.target;
            const reader = new FileReader();
            reader.onload = function(e) {
                $('#previewImage').attr('src', e.target.result).show();
            };
            if (input.files && input.files[0]) {
                reader.readAsDataURL(input.files[0]);
            }
        });
    });    
</script>
