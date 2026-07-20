@extends('frontend.layouts.app')
@section('content')

<div class="login-detail">
        <div class="container">
            <div class="row gy-3 gx-0 justify-content-center align-items-center ">
                {{-- <div class="col-lg-6 col-md-6">
                     <div class="login-left">
                        <img src="<?php echo url('');?>/assets/images/forget.jpg" alt="">
                     </div>
                </div> --}}
                <div class="col-lg-6 col-md-6">
                    <div class="login-box">
                    <h1 class="login-title">Change Password</h1>
                    @if (session('success'))
                        <div id="successMessage" class="alert alert-success">{{ session('success') }}</div>
                    @endif
                    
                    @if (session('danger'))
                        <div id="dangerMessage" class="alert alert-danger">{{ session('danger') }}</div>
                    @endif
                    
                    <script>
                        setTimeout(function () {
                            $('#successMessage').fadeOut('slow');
                        }, 5000);
                    
                        setTimeout(function () {
                            $('#dangerMessage').fadeOut('slow');
                        }, 5000);
                    </script>
                    <form id="resetPasswordForm" class="row gy-4" method="POST" action="{{ route('reset_password') }}">
                        @csrf
                        <input type="hidden" class="form-input" name="user_id" value="{{ $user->id }}">
                        <div class="col-md-12 position-relative">
                            <input type="password" name="password" placeholder="New Password" class="form-control" id="password" required>
                            <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePassword" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-md-12 position-relative">
                            <input type="password" name="password_confirmation" placeholder="Confirm Password" class="form-control" id="password_confirmation" required>
                            <i class="fa fa-eye position-absolute top-50 end-0 translate-middle-y me-3" id="togglePasswordConfirmation" style="cursor: pointer;"></i>
                        </div>
                        <div class="col-12">
                            <p class="text-center"><button type="submit" id="submitBtn" class="common-btn">Update<i class="bi bi-arrow-right"></i></button></p>
                        </div>
                    </form>
                    
                    {{-- <hr class="my-4" style="opacity: 0.2;"> --}}
                    
                </div>
            </div>
        </div>
    </div>
 </div>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<script>
    $(document).ready(function() {
        $('#submitBtn').click(function(e) {
            e.preventDefault();
            
            // Perform client-side validation
            var password = $('input[name="password"]').val();
            var confirmPassword = $('input[name="password_confirmation"]').val();
            
            if (password.length < 8) {
                alert('Password must be at least 8 characters long.');
                return;
            }
            
            if (password !== confirmPassword) {
                alert('Passwords do not match.');
                return;
            }
            
            // Submit the form via AJAX
            $.ajax({
                type: 'POST',
                url: $('#resetPasswordForm').attr('action'),
                data: $('#resetPasswordForm').serialize(),
                success: function(response) {
                    if (response.redirect) {
                        alert('Password has been updated, you can login now');
                        window.location.href = response.redirect;
                    } else {
                        // Handle other responses or success messages
                        console.log(response.message);
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error response
                    console.error(xhr.responseText);
                }
            });
        });
    });
</script>



<script>
    $(document).ready(function() {
        $('#togglePassword').on('click', function() {
            const passwordField = $('#password');
            const type = passwordField.attr('type') === 'password' ? 'text' : 'password';
            passwordField.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });

        $('#togglePasswordConfirmation').on('click', function() {
            const passwordConfirmationField = $('#password_confirmation');
            const type = passwordConfirmationField.attr('type') === 'password' ? 'text' : 'password';
            passwordConfirmationField.attr('type', type);
            $(this).toggleClass('fa-eye fa-eye-slash');
        });
    });
</script>



@endsection