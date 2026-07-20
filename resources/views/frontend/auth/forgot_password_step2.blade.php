@extends('frontend.layouts.app')
@section('content')
    <style>
        .otp-button-size {
            margin-right: 5px;
            width: 40px;
            height: 40px;
            border-radius: 7px;
            text-align: center;
            border: 1px solid #b33425;
        }

        /* Login Detail Container */
        .login-detail {
            padding: 30px 0;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
            min-height: 50vh;
            display: flex;
            align-items: center;
        }

        /* Login Left - Image Section */
        .login-left {
            padding: 20px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-left img {
            max-width: 100%;
            height: auto;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.15);
            animation: fadeInLeft 0.8s ease;
        }

        @keyframes fadeInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Login Box */
        .login-box {
            background: #fff;
            padding: 40px;
            border-radius: 12px;
            box-shadow: 0 8px 24px rgba(0, 0, 0, 0.1);
            animation: fadeInRight 0.8s ease;
        }

        @keyframes fadeInRight {
            from {
                opacity: 0;
                transform: translateX(30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        /* Login Title */
        .login-title {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 25px;
            text-align: center;
            position: relative;
            padding-bottom: 15px;
        }

        .login-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #d32f2f, #b71c1c);
            border-radius: 2px;
        }

        /* Alert Messages */
        .alert {
            border-radius: 8px;
            padding: 12px 20px;
            margin-bottom: 20px;
            border-left: 4px solid;
            animation: slideDown 0.5s ease;
            font-size: 14px;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #28a745;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #dc3545;
            color: #721c24;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* OTP Input Fields */
        .otp-button-size {
            width: 60px;
            height: 60px;
            font-size: 24px;
            font-weight: 600;
            text-align: center;
            border: 2px solid #e0e0e0;
            border-radius: 10px;
            margin: 0 8px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            color: #333;
        }

        .otp-button-size:focus {
            border-color: #d32f2f;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(211, 47, 47, 0.1);
            outline: none;
            transform: scale(1.05);
        }

        .otp-button-size:hover {
            border-color: #c0c0c0;
            background: #fff;
        }

        /* Remove number input arrows */
        .otp-button-size::-webkit-outer-spin-button,
        .otp-button-size::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        .otp-button-size[type=number] {
            -moz-appearance: textfield;
        }

        /* Resend OTP Link */
        .form-group {
            text-align: center;
            margin-top: 20px;
        }

        #resendOtpLink {
            color: #d32f2f;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            position: relative;
            transition: all 0.3s ease;
            display: inline-block;
        }

        #resendOtpLink::after {
            content: '';
            position: absolute;
            width: 0;
            height: 2px;
            bottom: -2px;
            left: 0;
            background: #d32f2f;
            transition: width 0.3s ease;
        }

        #resendOtpLink:hover {
            color: #b71c1c;
        }

        #resendOtpLink:hover::after {
            width: 100%;
        }

        /* Submit Button */
        .common-btn {
            background: linear-gradient(135deg, #d32f2f 0%, #b71c1c 100%);
            color: #fff;
            border: none;
            padding: 14px 50px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            transition: all 0.3s ease;
            cursor: pointer;
            box-shadow: 0 4px 15px rgba(211, 47, 47, 0.3);
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .common-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 25px rgba(211, 47, 47, 0.4);
            background: linear-gradient(135deg, #b71c1c 0%, #d32f2f 100%);
        }

        .common-btn:active {
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(211, 47, 47, 0.3);
        }

        .common-btn i {
            transition: transform 0.3s ease;
        }

        .common-btn:hover i {
            transform: translateX(5px);
        }

        /* Horizontal Rule */
        hr {
            border: none;
            border-top: 1px solid #dee2e6;
            margin: 30px 0;
        }

        /* Form Row Spacing */
        .login-box .gy-4>* {
            padding-top: 1.5rem;
        }

        /* Responsive Design */
        @media (max-width: 992px) {
            .login-left {
                order: 2;
                margin-top: 30px;
            }

            .login-box {
                order: 1;
            }
        }

        @media (max-width: 768px) {
            .login-detail {
                padding: 30px 0;
            }

            .login-box {
                padding: 30px 20px;
            }

            .login-title {
                font-size: 22px;
            }

            .otp-button-size {
                width: 50px;
                height: 50px;
                font-size: 20px;
                margin: 0 5px;
            }

            .common-btn {
                width: 100%;
                justify-content: center;
                padding: 14px 30px;
            }
        }

        @media (max-width: 480px) {
            .otp-button-size {
                width: 45px;
                height: 45px;
                font-size: 18px;
                margin: 0 3px;
            }

            .login-title {
                font-size: 20px;
            }
        }

        /* Loading State */
        .common-btn:disabled {
            background: #ccc;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        /* Focus Visible for Accessibility */
        .otp-button-size:focus-visible {
            outline: 3px solid #d32f2f;
            outline-offset: 3px;
        }

        /* Animation for filled OTP boxes */
        .otp-button-size.filled {
            background: #d32f2f;
            color: #fff;
            border-color: #d32f2f;
        }
    </style>

    <div class="login-detail">
        <div class="container">
            <div class="row gy-3 gx-0 justify-content-center align-items-center ">
                {{-- <div class="col-lg-6 col-md-6">
                    <div class="login-left">
                        <img src="<?php echo url(''); ?>/assets/images/forget.jpg" alt="">
                    </div>
                </div> --}}
                <div class="col-lg-6 col-md-6">
                    <div class="login-box">
                        <h1 class="login-title">Forget Password - OTP</h1>
                        @if (session('success'))
                            <div id="successMessage" class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        @if (session('danger'))
                            <div id="dangerMessage" class="alert alert-danger">{{ session('danger') }}</div>
                        @endif

                        <script>
                            setTimeout(function() {
                                $('#successMessage').fadeOut('slow');
                            }, 5000);

                            setTimeout(function() {
                                $('#dangerMessage').fadeOut('slow');
                            }, 5000);
                        </script>
                        <form class="row gy-4" method="POST" action="{{ route('verification_code') }}">
                            @csrf
                            <input type="hidden" class="form-input" name="user_id" value="{{ $user->id }}"
                                placeholder="Enter Email">
                            <div class="col-md-12 text-center">
                                <input class="otp-button-size" type="text" id="otp1" name="otp[]" maxlength="1"
                                    size="1" autofocus>
                                <input class="otp-button-size" type="text" id="otp2" name="otp[]" maxlength="1"
                                    size="1">
                                <input class="otp-button-size" type="text" id="otp3" name="otp[]" maxlength="1"
                                    size="1">
                                <input class="otp-button-size" type="text" id="otp4" name="otp[]" maxlength="1"
                                    size="1">
                            </div>
                            <div class="form-group">
                                <a href="#" id="resendOtpLink" data-user-id="{{ $user->id }}">Resend OTP</a>
                            </div>

                            <div class="col-12">
                                <p class="text-center"> <button type="submit" class="common-btn">Verify <i
                                            class="bi bi-arrow-right"></i></button> </p>
                            </div>
                        </form>

                        {{-- <hr class="my-4" style="opacity: 0.2;"> --}}

                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#resendOtpLink').click(function(e) {
                e.preventDefault();
                var userId = $(this).data('user-id');
                $.ajax({
                    url: '{{ url('user-resend-otp') }}/' + userId,
                    type: 'GET',
                    success: function(response) {
                        alert(response.success);
                    },
                    error: function(xhr, status, error) {
                        alert(xhr.responseText);
                    }
                });
            });
        });
    </script>



    <script>
        // JavaScript to move focus to the next input field after one character is entered
        document.getElementById('otp1').addEventListener('input', function() {
            if (this.value.length === 1) {
                document.getElementById('otp2').focus();
            }
        });

        document.getElementById('otp2').addEventListener('input', function() {
            if (this.value.length === 1) {
                document.getElementById('otp3').focus();
            }
        });

        document.getElementById('otp3').addEventListener('input', function() {
            if (this.value.length === 1) {
                document.getElementById('otp4').focus();
            }
        });
    </script>
@endsection
