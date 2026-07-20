@extends('admin.index')
@section('admin')
    @if (session('success'))
        <div id="successAlert" class="alert alert-success">
            {{ session('success') }}
        </div>

        <script>
            setTimeout(function() {
                $('#successAlert').fadeOut('fast');
            }, 3000); // 3000 milliseconds = 3 seconds
        </script>
    @endif


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
                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">Add Shop
                        Age</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-3">
                        <div class="settings-form">
                            <form method="POST" action="{{ route('shop.by.update', $shop_by_age->id) }}"
                                enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Age Title</label>
                                        <input type="text" name="title" class="form-control" placeholder="Enter Title"
                                            value="{{ $shop_by_age->title }}" pattern="[A-Za-z0-9 _-]+"
                                            title="Only letters, numbers, spaces, hyphen (-) and underscore (_) are allowed"
                                            oninput="this.value=this.value.replace(/[^A-Za-z0-9 _-]/g,'')">
                                        @error('title')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Image
                                            <span class="text-muted">
                                                (Recommended size: 1600 × 2400 px, Max file size: 1 MB)
                                            </span>
                                        </label>
                                        <input type="file" name="image" class="form-control"
                                            @if (!$shop_by_age->image) required @endif />
                                        @if (!$shop_by_age->image)
                                            <br>
                                            <div id="uploaded_image2"></div>
                                        @endif <br>
                                        @if ($shop_by_age->image)
                                            <div class="img-postion">
                                                <img src="{{ asset($shop_by_age->image) }}" alt="Image"
                                                    class="img-thumbnail" width="80px">
                                                {{-- <div class="delete-icon"><a href="{{ route('product.category.imagedelete', ['id' => $category->id, 'name' => $shop_by_age->image]) }}"><i class="fa fa-times-circle" aria-hidden="true"></i></a></div> --}}
                                            </div>
                                        @endif
                                    </div>
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Priority</label>
                                        <input type="number"
                                            name="priority"
                                            min="0"
                                            class="form-control"
                                            value="{{ old('priority', $shop_by_age->priority ?? 0) }}"
                                            required>
                                        @error('priority') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>
                                    <div class="row align-items-center">
                                        <div class="mb-3 col-md-6">
                                            <label for="url" class="form-label">Url</label>
                                            <input type="url" class="form-control" id="url" name="url"
                                                value="{{ $shop_by_age->url }}" placeholder="https://example.com"
                                                pattern="https?://.+"
                                                title="Enter a valid URL starting with http:// or https://" required>
                                        </div>

                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Status</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="active"
                                                    value="1" @checked($shop_by_age->status == 1)>
                                                <label class="form-check-label" for="active">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio" name="status" id="inactive"
                                                    value="0" @checked($shop_by_age->status == 0)>
                                                <label class="form-check-label" for="inactive">Inactive</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <button class="btn btn-primary" type="submit">Add Product</button>
                            </form>
                        </div>
                    </div>
                </div> <br><br><br>
            </div>
        </div>
    </div>
@endsection