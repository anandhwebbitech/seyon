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

    <div class="profile-tab">
        <div class="custom-tab-1">
            <ul class="nav nav-tabs">
                <li class="nav-item"><a href="#about-me" data-bs-toggle="tab" class="nav-link active show">Profile</a>
                </li>
                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link">Setting</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="about-me" class="tab-pane fade active show">
                    <br>
                    <div class="profile-personal-info">
                        <h4 class="text-primary mb-4">Personal Information</h4>
                        <div class="row mb-2">
                            <div class="col-sm-3 col-5">
                                <h5 class="f-w-500">Name <span class="pull-end">:</span>
                                </h5>
                            </div>
                            <div class="col-sm-9 col-7"><span>{{ $user->name }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3 col-5">
                                <h5 class="f-w-500">Email <span class="pull-end">:</span>
                                </h5>
                            </div>
                            <div class="col-sm-9 col-7"><span>{{ $user->email }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3 col-5">
                                <h5 class="f-w-500">Phone <span class="pull-end">:</span></h5>
                            </div>
                            <div class="col-sm-9 col-7"><span>{{ $user->phone }}</span>
                            </div>
                        </div>
                        <div class="row mb-2">
                            <div class="col-sm-3 col-5">
                                <h5 class="f-w-500">Digital signature <span class="pull-end">:</span></h5>
                            </div>
                            <div class="col-sm-9 col-7">
                                <span>
                                    @if ($user->image_name)
                                        <img src="{{ asset('images/' . $user->image_name) }}"
                                            alt="Digital signature" class="mt-2" style="max-width: 200px;">
                                    @else
                                        <p>No image uploaded</p>
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="profile-settings" class="tab-pane fade">
                    <div class="pt-3">
                        <div class="settings-form">
                            <h4 class="text-primary">Account Setting</h4>
                            <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                {{-- @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <ul class="mb-0">
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif --}}
                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ old('name', $user->name) }}">
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email"
                                            value="{{ old('email', $user->email) }}">
                                        @error('email')
                                            <small class="text-danger">{{ $message }}</small>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label">Phone Number</label>
                                    <input type="text" class="form-control" name="phone"
                                        value="{{ old('phone', $user->phone) }}" maxlength="10" pattern="[0-9]{10}"
                                        required oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,10)">
                                    @error('phone')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                                <div class="mb-3">
                                    <label for="image" class="form-label">Digital signature</label>
                                    <input type="file" class="form-control" id="image" name="image">
                                    @if ($user->image_name)
                                        <img src="{{ asset('images/' . $user->image_name) }}"
                                            alt="Digital signature" class="mt-2" style="max-width: 200px;">
                                    @else
                                        <p>No image uploaded</p>
                                    @endif
                                </div>

                                <button class="btn btn-primary" type="submit">Update</button>
                            </form>

                        </div>
                    </div>
                </div> <br><br><br>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="replyModal">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Post Reply</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <form>
                            <textarea class="form-control" rows="4">Message</textarea>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger light" data-bs-dismiss="modal">btn-close</button>
                        <button type="button" class="btn btn-primary">Reply</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
