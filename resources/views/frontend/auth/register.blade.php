@extends('frontend.layouts.app')
@section('content')
    <div class="container-fluid login-container py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="login-card">
                        <div class="row g-0">
                            <!-- Login Form Section -->
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <div class="col-md-6">
                                <div class="login-form-section">
                                    <h1 class="login-title">Register</h1>

                                    <form action="{{ route('signup') }}" method="POST" enctype="multipart/form-data">
                                        @csrf
                                        <div class="input-group">
                                            <label class="input-label">Full Name</label>
                                            <input type="text" name="name" class="input-field" placeholder="John Doe" required>
                                        </div>
                                        <div class="input-group">
                                            <label class="input-label">Phone Number</label>
                                            <input type="number" name="phone" class="input-field"
                                                placeholder="+91 00000 00000" required>
                                        </div>
                                        {{-- <div class="input-group">
                                            <label class="input-label">Email</label>
                                            <input type="email" name="email" class="input-field"
                                                placeholder="john.doe@gmail.com">
                                        </div> --}}

                                        <div class="input-group password-container">
                                            <label class="input-label">Password</label>
                                            <input type="password" name="password" class="input-field password-dots"
                                                placeholder="Example@123" id="passwordField" />
                                            <button type="button" class="password-toggle" data-target="passwordField"
                                                data-icon="eyeIcon" onclick="togglePassword(this)">
                                                <svg class="eye-icon" id="eyeIcon" viewBox="0 0 24 24">
                                                    <path class="eye-hidden"
                                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                    <line class="eye-hidden" x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                            </button>
                                        </div>

                                        <div class="input-group password-container">
                                            <label class="input-label">Confirm Password</label>
                                            <input type="password" name="password_confirmation" class="input-field password-dots"
                                                placeholder="Example@123" id="passwordField1" />
                                            <button type="button" class="password-toggle" data-target="passwordField1"
                                                data-icon="eyeIcon1" onclick="togglePassword(this)">
                                                <svg class="eye-icon" id="eyeIcon1" viewBox="0 0 24 24">
                                                    <path class="eye-hidden"
                                                        d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                                                    <line class="eye-hidden" x1="1" y1="1" x2="23" y2="23"></line>
                                                </svg>
                                            </button>
                                        </div>


                                        <!-- Remember & Forgot Password -->
                                        <div class="d-flex justify-content-between align-items-center mb-4">
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" required id="rememberMe">
                                                <label class="form-check-label" for="rememberMe">
                                                    I agree to all the <em>Terms </em>and<em> Privacy Policies</em>
                                                </label>
                                            </div>
                                        </div>

                                        <!-- Login Button -->
                                        <button type="submit" class="btn-login">Sign up</button>
                                        <!-- Divider -->
                                        <div class="divider-container">
                                            <div class="divider-line"></div>
                                            <span class="divider-text">Or</span>
                                            <div class="divider-line"></div>
                                        </div>

                                        <!-- Google Sign In Button -->
                                        <a href="{{ route('auth.google.redirect') }}" class="btn-google">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M19.8055 10.2292C19.8055 9.55156 19.7501 8.86719 19.6323 8.19531H10.2002V12.0492H15.6014C15.3773 13.2911 14.6571 14.3898 13.6053 15.0875V17.5867H16.8251C18.7175 15.8449 19.8055 13.2724 19.8055 10.2292Z"
                                                    fill="#4285F4" />
                                                <path
                                                    d="M10.2002 20.0008C12.9527 20.0008 15.2564 19.1152 16.8294 17.5867L13.6096 15.0875C12.7065 15.6972 11.5492 16.0429 10.2045 16.0429C7.54388 16.0429 5.30945 14.2845 4.51824 11.9097H1.19727V14.4822C2.80206 17.6794 6.34246 20.0008 10.2002 20.0008Z"
                                                    fill="#34A853" />
                                                <path
                                                    d="M4.51387 11.9097C4.05862 10.6678 4.05862 9.33548 4.51387 8.09359V5.52109H1.19731C-0.399025 8.68359 -0.399025 12.3197 1.19731 15.4822L4.51387 11.9097Z"
                                                    fill="#FBBC04" />
                                                <path
                                                    d="M10.2002 3.95805C11.6236 3.936 13.0033 4.47805 14.0377 5.45805L16.8954 2.60055C15.1712 0.990547 12.7283 0.0809687 10.2002 0.104219C6.34246 0.104219 2.80206 2.42555 1.19727 5.52109L4.51383 8.09359C5.29945 5.71242 7.53946 3.95805 10.2002 3.95805Z"
                                                    fill="#EA4335" />
                                            </svg>
                                            Sign up with Google
                                        </a>

                                        <!-- Sign Up Link -->
                                        <div class="signup-link">
                                            already have an account <a href="{{ route('user.login') }}">Sign in</a>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <!-- Image Section -->
                            <div class="col-md-6 d-flex justify-content-center">
                                <img src="{{ asset('frontend/img/log-img.png') }}" alt="">

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
