@extends('admin.index')
@section('admin')

@if(session('success'))
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
            <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">COLOR</a>
            </li>
        </ul>
        <div class="tab-content">
            <div id="profile-settings" class="tab-pane fade active show">
                <div class="pt-3">
                    <div class="settings-form">
                            <form method="POST" action="{{ route('admin.product.color.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Color</label>
                                        <input type="text" name="color" class="form-control" @error('color') is-invalid @enderror
                                         value="{{ old('color') }}" placeholder="Red, Blue, Black">

                                        @error('color')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Code</label>
                                        <input type="color" name="code" class="form-control"
                                         value="{{ old('code') }}" placeholder="#000000" readonly>
                                        @error('code')
                                            <div class="invalid-feedback d-block">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>
                                <br>
                            
                                <button class="btn btn-primary" type="submit">Submit</button>
                            </form>

                    </div>
                </div>
            </div> <br><br><br>
        </div>
    </div>

</div>

@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


