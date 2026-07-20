@extends('frontend.layouts.app')
@section('content')
    <div class="container-fluid login-container py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-12">
                    <div class="login-card">
                        <div class="row g-0">
                            <!-- Login Form Section -->
                            <div class="col-md-6">
                                <div class="login-form-section">
                                    <h1 class="login-title">Log In with OTP</h1>
                                    <!-- Message Display -->
                                    <div id="msg"></div>
                                    <form id="forgotForm">
                                        @csrf
                                        <div class="input-group">
                                            <label class="input-label">Mobile No</label>
                                            <input type="text" name="phone_or_email" class="input-field" placeholder="+91 00000 00000" required>
                                        </div>

                                        <button type="submit" class="btn btn-login" id="submitBtn">
                                            Get OTP
                                        </button>
                                    </form>

                                    <!-- OTP Section (hidden initially) -->
                                        <div id="otpSection" style="display:none; margin-top:20px;">
                                            <label class="input-label mb-2">Enter OTP</label>

                                            <!-- Hidden field to store user ID -->
                                            <input type="hidden" id="user_id">

                                            <!-- OTP inputs container -->
                                            <div class="d-flex gap-2 justify-content-start mb-3">
                                                <input type="number" minlength="1" maxlength="1" class="otp_input form-control text-center" style="width:45px; height:50px; font-size:20px;">
                                                <input type="number" minlength="1" maxlength="1" class="otp_input form-control text-center" style="width:45px; height:50px; font-size:20px;">
                                                <input type="number" minlength="1" maxlength="1" class="otp_input form-control text-center" style="width:45px; height:50px; font-size:20px;">
                                                <input type="number" minlength="1" maxlength="1" class="otp_input form-control text-center" style="width:45px; height:50px; font-size:20px;">
                                                <input type="number" minlength="1" maxlength="1" class="otp_input form-control text-center" style="width:45px; height:50px; font-size:20px;">
                                                <input type="number" minlength="1" maxlength="1" class="otp_input form-control text-center" style="width:45px; height:50px; font-size:20px;">
                                            </div>

                                            <!-- Verify OTP button -->
                                            <button class="btn btn-success w-50" id="verifyBtn">Verify OTP</button>
                                        </div>
                                </div>
                            </div>
                            <!-- Image Section -->
                            <div class="col-md-6">
                                <img src="{{ asset('frontend/img/log-img.png') }}" alt="">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            // Submit phone/email to send OTP
            $("#forgotForm").on('submit', function(e) {
                e.preventDefault();

                let phoneOrEmail = $("input[name='phone_or_email']").val();
                $("#msg").html('');
                $("#submitBtn").prop('disabled', true).text('Sending OTP...');

                $.ajax({
                    url: "{{ route('forgot_password_step2') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        phone_or_email: phoneOrEmail
                    },
                    success: function(res) {
                        $("#submitBtn").prop('disabled', false).text('Resend OTP')

                        if (res.status === true) {
                            $("#msg").html(`<div class="alert alert-success">${res.message}</div>`);
                            
                            // Show OTP section
                            $("#otpSection").show();
                            $("#user_id").val(res.user_id ?? '');

                        } else {
                            $("#msg").html(`<div class="alert alert-danger">${res.message}</div>`);
                        }
                    },
                    error: function(xhr) {
                        $("#submitBtn").prop('disabled', false).text('Submit');
                        $("#msg").html(`<div class="alert alert-danger">Something went wrong. Try again!</div>`);
                    }
                });
            });

            // Auto focus for OTP inputs
            $(".otp_input").on('input', function() {
                let $this = $(this);
                let val = $this.val();

                // Keep only the first digit (numeric only)
                val = val.replace(/[^0-9]/g, ''); // Remove non-numeric
                val = val.substring(0, 1);       // Keep only first character
                $this.val(val);

                // Highlight red if invalid (non-numeric)
                if (val === '') {
                    $this.css('border', '2px solid red');
                } else {
                    $this.css('border', '1px solid #ced4da');
                    // Move to next input automatically if available
                    $this.next('.otp_input').focus();
                }
            });

            $(".otp_input").on('keydown', function(e) {
                let $this = $(this);
                if (e.key === "Backspace" && $this.val() === '') {
                    // Move to previous input if exists
                    $this.prev('.otp_input').focus().val('');
                }
            });

            // Verify OTP
            $("#verifyBtn").on('click', function(e) {
                e.preventDefault();

                let otp = '';
                let invalid = false;
                $(".otp_input").each(function() {
                    let val = $(this).val();

                    // Check if value is a single digit number
                    if (!/^\d$/.test(val)) {
                        $(this).css('border', '2px solid red'); // Highlight invalid input
                        invalid = true;
                    } else {
                        $(this).css('border', '1px solid #ced4da'); // Reset border
                        otp += val;
                    }
                });

                let userId = $("#user_id").val();
                if (otp.length < 6) {
                    $("#msg").html(`<div class="alert alert-danger">Please enter complete OTP</div>`);
                    return;
                }

                $("#verifyBtn").prop('disabled', true).text('Verifying...');

                $.ajax({
                    url: "{{ route('verification_code') }}",
                    type: "POST",
                    data: {
                        _token: "{{ csrf_token() }}",
                        user_id: userId,
                        otp: otp
                    },
                    success: function(res) {
                        $("#verifyBtn").prop('disabled', false).text('Verify OTP');

                        if (res.status === true) {
                            $("#msg").html(`<div class="alert alert-success">${res.message}</div>`);
                            setTimeout(() => {
                                window.location.href = res.redirect;
                            }, 1000);
                        } else {
                            $("#msg").html(`<div class="alert alert-danger">${res.message}</div>`);
                        }
                    },
                    error: function(xhr) {
                        $("#verifyBtn").prop('disabled', false).text('Verify OTP');
                        $("#msg").html(`<div class="alert alert-danger">Something went wrong. Try again!</div>`);
                    }
                });
            });
        });
    </script>

@endsection
