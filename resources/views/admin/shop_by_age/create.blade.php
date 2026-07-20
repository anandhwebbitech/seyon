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
                            <form method="POST" action="{{ route('shop.by.store') }}" enctype="multipart/form-data">
                                @csrf
                                <div class="row">
                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Age Title</label>
                                        <input type="text"
                                            name="title"
                                            class="form-control"
                                            value="{{ old('title', $shop_by_age->title ?? '') }}"
                                            placeholder="Enter Title"
                                            pattern="[A-Za-z0-9 _-]+"
                                            required>
                                        @error('title') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3 col-md-4">
                                        <label class="form-label">Image</label>
                                        <input type="file" name="image" class="form-control">
                                        @error('image') <div class="text-danger">{{ $message }}</div> @enderror
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
                                </div>

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">URL</label>
                                        <input type="url"
                                            name="url"
                                            class="form-control"
                                            value="{{ old('url', $shop_by_age->url ?? '') }}"
                                            placeholder="https://example.com"
                                            required>
                                        @error('url') <div class="text-danger">{{ $message }}</div> @enderror
                                    </div>

                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>

                                        <label class="me-3">
                                            <input type="radio" name="status" value="1"
                                                {{ old('status', $shop_by_age->status ?? 1) == 1 ? 'checked' : '' }}>
                                            Active
                                        </label>

                                        <label>
                                            <input type="radio" name="status" value="0"
                                                {{ old('status', $shop_by_age->status ?? 1) == 0 ? 'checked' : '' }}>
                                            Inactive
                                        </label>
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