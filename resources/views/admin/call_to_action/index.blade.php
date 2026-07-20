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
                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">Call To
                        Action</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-3">
                        <div class="settings-form">
                            <form method="POST" action="{{ route('shop.by.call.to.action.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                @foreach ($types as $type)
                                    @php
                                        $cta = $call_to_action->where('name', $type)->first();
                                    @endphp
                                    @php
                                        $imageSizes = [
                                            'call_to_action_main' => '600 × 600 px, Max 1 MB)',
                                            'call_to_action_sub'  => '704 × 320 px, Max 1 MB)',
                                            'call_to_action_sub1' => '704 × 320 px, Max 1 MB)',
                                            'call_to_action_sub2' => '704 × 320 px, Max 1 MB)',
                                        ];
                                    @endphp

                                    <h4 class="mt-4">{{ ucfirst(str_replace('_', ' ', $type)) }}</h4>
                                    <div class="row border p-3 mb-3 rounded">
                                        <input type="hidden" name="types[]" value="{{ $type }}">

                                        <!-- Title -->
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Title</label>
                                            <input type="text" name="title[{{ $type }}]" class="form-control"
                                                placeholder="Enter Title"
                                                value="{{ old('title.' . $type, $cta->title ?? '') }}">
                                            @error('title.' . $type)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Description -->
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Description</label>
                                            <textarea name="description[{{ $type }}]" class="form-control" placeholder="Enter Description">{{ old('description.' . $type, $cta->description ?? '') }}</textarea>
                                            @error('description.' . $type)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Image -->
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">
                                                Image
                                                <span class="text-muted">
                                                    (Recommended: {{ $imageSizes[$type] ?? 'Max 1 MB' }})
                                                </span>
                                            </label>

                                            <input type="file" name="image[{{ $type }}]" class="form-control">
                                            @if (!empty($cta->image))
                                                <img src="{{ asset($cta->image) }}" width="100" class="mt-2 preview">
                                            @endif
                                            @error('image.' . $type)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- URL -->
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Url</label>
                                            <input type="text" class="form-control" name="url[{{ $type }}]"
                                                placeholder="https://example.com"
                                                value="{{ old('url.' . $type, $cta->url ?? '') }}">
                                            @error('url.' . $type)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                        <!-- Status -->
                                        <div class="mb-3 col-md-6">
                                            <label class="form-label">Status</label><br>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="status[{{ $type }}]" value="1"
                                                    {{ old('status.' . $type, $cta->status ?? 1) == 1 ? 'checked' : '' }}>
                                                <label class="form-check-label">Active</label>
                                            </div>
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="radio"
                                                    name="status[{{ $type }}]" value="0"
                                                    {{ old('status.' . $type, $cta->status ?? 0) == 0 ? 'checked' : '' }}>
                                                <label class="form-check-label">Inactive</label>
                                            </div>
                                            @error('status.' . $type)
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>

                                    </div>
                                @endforeach

                                <button class="btn btn-primary" type="submit">Save Change</button>
                            </form>

                        </div>
                    </div>
                </div> <br><br><br>
            </div>
        </div>
    </div>

    <script>
        function modalclose() {
            $('#uploadimageModal').hide();
        }

        // Optional: live image preview
        $('input[type="file"]').on('change', function(e){
            var reader = new FileReader();
            reader.onload = function(e){
                $(e.target).closest('.col-md-6').find('img.preview').remove();
                $(e.target).after('<img src="'+e.target.result+'" width="100" class="preview mt-2"/>');
            }
            reader.readAsDataURL(this.files[0]);
        });
    </script>
@endsection
