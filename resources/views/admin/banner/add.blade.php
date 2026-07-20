@extends('admin.index')
@section('admin')
    <div class="card">
        <div class="card-header">
            <h4>Add Banner Image</h4>
        </div>

        <div class="card-body">
            <form method="POST" action="{{ route('admin.banner.store') }}" enctype="multipart/form-data">
                @csrf

                <!-- Title -->
                <div class="mb-3">
                    <label class="form-label">Banner Title</label>
                    <input type="text" name="title" class="form-control" pattern="[A-Za-z0-9 _\.-]+"
                        title="Only letters, numbers, space, -, _, . allowed" required>
                </div>

                <!-- Description -->
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="3" required></textarea>
                </div>

                <!-- Image -->
                <div class="mb-3">
                    <label class="form-label">
                        Banner Image
                        <span class="text-muted">
                            (Recommended size: 648 × 420 px, Max file size: 1 MB)
                        </span>
                    </label>
                    <input type="file" name="image" class="form-control" accept="image/*" required>
                </div>

                <!-- Banner Link -->
                <div class="mb-3">
                    <label class="form-label">Banner Link</label>
                    <input type="url" name="banner_link" class="form-control" placeholder="https://example.com"
                        pattern="https?://.+" title="Enter valid URL starting with http:// or https://" required>
                </div>

                <div class="mt-4">
                    <button type="submit" class="btn btn-primary">Save Banner</button>
                    {{-- <a href="{{ route('admin.banner.show') }}" class="btn btn-secondary">Back</a> --}}
                </div>
            </form>
        </div>
    </div>
@endsection
