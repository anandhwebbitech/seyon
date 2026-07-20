@extends('admin.index')

@section('admin')

{{-- Success Alert --}}
@if(session('success'))
    <div id="successAlert" class="alert alert-success">
        {{ session('success') }}
    </div>

    <script>
        setTimeout(() => {
            document.getElementById('successAlert')?.remove();
        }, 3000);
    </script>
@endif

<div class="profile-tab">
    <div class="custom-tab-1">

        <ul class="nav nav-tabs">
            <li class="nav-item">
                <a href="#edit-reel" data-bs-toggle="tab"
                   class="nav-link active">
                    Edit Shop By Reel
                </a>
            </li>
        </ul>

        <div class="tab-content">
            <div id="edit-reel" class="tab-pane fade show active">

                <div class="pt-3">
                    <div class="settings-form">

                        <form method="POST"
                              action="{{ route('shop-by-reels.update', $shopByReel->id) }}">
                            @csrf
                            @method('PUT')

                            <div class="row">

                                {{-- Title --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Reel Title</label>
                                    <input type="text"
                                           name="title"
                                           class="form-control"
                                           value="{{ old('title', $shopByReel->title) }}">
                                    @error('title')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Reel URL --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Reel URL</label>
                                    <input type="text"
                                           name="url"
                                           class="form-control"
                                           value="{{ old('url', $shopByReel->url) }}">
                                    @error('url')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Redirect URL --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Redirect URL</label>
                                    <input type="text"
                                           name="redirect_url"
                                           class="form-control"
                                           value="{{ old('redirect_url', $shopByReel->redirect_url) }}">
                                    @error('redirect_url')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                {{-- Status --}}
                                <div class="mb-3 col-md-6">
                                    <label class="form-label d-block">Status</label>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="status"
                                               value="1"
                                               {{ old('status', $shopByReel->status) == 1 ? 'checked' : '' }}>
                                        <label class="form-check-label">Active</label>
                                    </div>

                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input"
                                               type="radio"
                                               name="status"
                                               value="0"
                                               {{ old('status', $shopByReel->status) == 0 ? 'checked' : '' }}>
                                        <label class="form-check-label">Inactive</label>
                                    </div>

                                    @error('status')
                                        <small class="text-danger d-block">{{ $message }}</small>
                                    @enderror
                                </div>

                            </div>

                            <button type="submit" class="btn btn-primary mt-3">
                                Update Reel
                            </button>

                            <a href="{{ route('shop-by-reels.index') }}"
                               class="btn btn-secondary mt-3 ms-2">
                                Back
                            </a>

                        </form>

                    </div>
                </div>

            </div>
        </div>

    </div>
</div>

@endsection
