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
                <li class="nav-item"><a href="#profile-settings" data-bs-toggle="tab" class="nav-link active show">PRODUCT
                        COUPON CODE</a>
                </li>
            </ul>
            <div class="tab-content">
                <div id="profile-settings" class="tab-pane fade active show">
                    <div class="pt-3">
                        <div class="settings-form">

                            <form method="POST" action="{{ route('admin.product.coupon_code.store') }}"
                                enctype="multipart/form-data">
                                @csrf

                                <div class="row">
                                    <!-- Code Input -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Code</label>
                                        <input type="text" name="code" class="form-control" required>

                                        @error('code')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Percentage Input -->
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Percentage</label>
                                        <input type="number" name="percentage" class="form-control"
                                            placeholder="Enter percentage" min="1" max="100"
                                            value="{{ old('percentage') }}" required>
                                        @error('percentage')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <!-- Status Radio -->
                                <div class="row align-items-center">
                                    <div class="mb-3 col-md-6">
                                        <label class="form-label">Status</label><br>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="active"
                                                value="1" required>
                                            <label class="form-check-label" for="active">Active</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="status" id="inactive"
                                                value="0" required>
                                            <label class="form-check-label" for="inactive">Inactive</label>
                                        </div>
                                        @error('status')
                                            <div class="text-danger">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                <br>
                                <button class="btn btn-primary" type="submit">Add coupon code</button>
                            </form>


                        </div>
                    </div>
                </div> <br><br><br>
            </div>
        </div>

    </div>
@endsection


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
