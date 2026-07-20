@extends('frontend.layouts.app')
@section('content')
    <style>
        /* Profile Detail Container */
        .profile-detail {
            padding: 40px 0;
            background: #f8f9fa;
            min-height: calc(100vh - 200px);
        }

        /* Main Title */
        .main-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 0;
            padding-bottom: 15px;
            border-bottom: 3px solid #d32f2f;
            display: inline-block;
        }

        /* Profile Right Section */
        .profile-right {
            background: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 12px rgba(0, 0, 0, 0.08);
            padding: 30px;
            margin: 10px 0;
        }

        /* Profile Box */
        .profile-box {
            width: 100%;
        }

        .profile-box-title {
            font-size: 24px;
            font-weight: 600;
            color: #d32f2f;
            margin-bottom: 0;
            padding-bottom: 15px;
            border-bottom: 2px solid #f0f0f0;
        }

        /* Alert Messages */
        .alert {
            border-radius: 6px;
            padding: 15px 20px;
            margin-bottom: 25px;
            border-left: 4px solid;
            animation: slideDown 0.5s ease;
            position: relative;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
            border-left-color: #28a745;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
            border-left-color: #dc3545;
        }

        /* Form Styling */
        .profile-box form {
            margin-top: 30px;
        }

        .form-label {
            font-size: 15px;
            font-weight: 600;
            color: #555;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            padding: 12px 16px;
            font-size: 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            transition: all 0.3s ease;
            background: #fff;
        }

        .form-control:focus {
            border-color: #d32f2f;
            box-shadow: 0 0 0 0.2rem rgba(211, 47, 47, 0.15);
            outline: none;
        }

        .form-control:hover {
            border-color: #c0c0c0;
        }

        /* Invalid Feedback */
        .is-invalid {
            border-color: #dc3545 !important;
        }

        .invalid-feedback {
            display: block;
            color: #dc3545;
            font-size: 13px;
            margin-top: 5px;
            font-weight: 500;
        }

        /* Submit Button */
        .common-btn {
            background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
            color: #fff;
            border: none;
            padding: 12px 40px;
            border-radius: 6px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(211, 47, 47, 0.3);
        }

        .common-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(211, 47, 47, 0.4);
            background: linear-gradient(135deg, #b71c1c 0%, #d32f2f 100%);
        }

        .common-btn:active {
            transform: translateY(0);
            box-shadow: 0 2px 8px rgba(211, 47, 47, 0.3);
        }

        /* Row Spacing */
        .profile-box .gy-4>* {
            padding-top: 1rem;
            padding-bottom: 1rem;
        }

        .profile-box .gx-3>* {
            padding-left: 0.75rem;
            padding-right: 0.75rem;
        }

        /* Password Input Icon (Optional Enhancement) */
        .form-control[type="password"] {
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23999' viewBox='0 0 16 16'%3E%3Cpath d='M8 1a2 2 0 0 1 2 2v4H6V3a2 2 0 0 1 2-2zm3 6V3a3 3 0 0 0-6 0v4a2 2 0 0 0-2 2v5a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V9a2 2 0 0 0-2-2z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 16px center;
            padding-right: 45px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .profile-detail {
                padding: 20px 0;
            }

            .main-title {
                font-size: 22px;
            }

            .profile-right {
                padding: 20px 15px;
                margin-top: 20px;
            }

            .profile-box-title {
                font-size: 20px;
            }

            .form-control {
                padding: 10px 14px;
                font-size: 14px;
            }

            .common-btn {
                width: 100%;
                padding: 12px 20px;
            }

            .col-md-7 {
                width: 100%;
            }
        }

        /* Loading State for Form Submission */
        .common-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Focus Visible for Accessibility */
        .form-control:focus-visible {
            outline: 2px solid #d32f2f;
            outline-offset: 2px;
        }

        /* Smooth Transitions */
        * {
            transition: border-color 0.2s ease, box-shadow 0.2s ease;
        }
    </style>
    <div class="profile-detail">
        <div class="container">
            <h5 class="main-title">Change Password</h5>
            <div class="row gy-4 gx-2 mt-3">
                @include('frontend.user.sidebar')
                <div class="col-lg-9 col-md-8">
                    <div class="profile-right">
                        <div class="profile-box">
                            <h1 class="profile-box-title">Change Password</h1><br>

                            @if (session('success'))
                                <div id="successMessage" class="alert alert-success">
                                    {{ session('success') }}
                                </div>

                                <script>
                                    // Automatically hide the success message after 5 seconds
                                    setTimeout(function() {
                                        document.getElementById('successMessage').style.display = 'none';
                                    }, 5000);
                                </script>
                            @endif

                            @if (session('error'))
                                <div id="errorMessage" class="alert alert-danger">
                                    {{ session('error') }}
                                </div>

                                <script>
                                    // Automatically hide the error message after 5 seconds
                                    setTimeout(function() {
                                        document.getElementById('errorMessage').style.display = 'none';
                                    }, 5000);
                                </script>
                            @endif

                            <form class="row gx-3 gy-4" action="{{ route('user.update.password') }}" method="post"
                                id="passwordChangeForm">
                                @csrf

                                {{-- <div class="col-md-7">
                                    <label for="oldPassword" class="form-label">Current Password</label>
                                    <input id="current_password" type="password"
                                        class="form-control @error('current_password') is-invalid @enderror"
                                        name="current_password" required>

                                    @error('current_password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div> --}}

                                <div class="col-md-7">
                                    <label for="newPassword" class="form-label">New Password</label>
                                    <input id="password" type="password"
                                        class="form-control @error('password') is-invalid @enderror" name="password"
                                        required>

                                    @error('password')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                </div>

                                <div class="col-md-7">
                                    <label for="confirmPassword" class="form-label">Confirm Password</label>
                                    <input id="password_confirmation" type="password" class="form-control"
                                        name="password_confirmation" required>
                                </div>
                                <div class="col-12">
                                    <button type="submit" class="common-btn">Change Password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
