@extends('frontend.layouts.app')
@section('content')

<style>
    .otp-button-size{
        margin-right: 5px;
        width: 40px;
        height: 40px;
        border-radius: 7px;
        text-align: center;
        border: 1px solid #b33425;
    }
</style>

<div class="page-banner">
        <div class="container">
            <ul class="navigation-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Get OTP</li>
            </ul>
        </div>
       </div>
       
       
<div class="login-detail">
        <div class="container">
            <div class="row gy-3 gx-0 justify-content-center align-items-center ">
                <div class="col-lg-6 col-md-6">
                     <div class="login-left">
                        <img src="<?php echo url('');?>/assets/images/forget.jpg" alt="">
                     </div>
                </div>
                <div class="col-lg-6 col-md-6">
                    <div class="login-box">
                        
                    <h1 class="login-title">Log In</h1>
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
                    <form class="row gy-4" method="POST" action="{{ route('user.otp.verify') }}">
                        @csrf
                        <input type="hidden" class="form-input" name="user_id" value="{{ $user->id }}" placeholder="Enter Email">
                        <div class="col-md-12 text-center">
                            <input type="text" class="otp-button-size" id="otp1" name="otp[]" maxlength="1" size="1" autofocus>
                            <input type="text" class="otp-button-size" id="otp2" name="otp[]" maxlength="1" size="1">
                            <input type="text" class="otp-button-size" id="otp3" name="otp[]" maxlength="1" size="1">
                            <input type="text" class="otp-button-size" id="otp4" name="otp[]" maxlength="1" size="1">
                        </div>
                        <div class="form-group">
                            <a href="#" id="resendOtpLink" data-user-id="{{ $user->id }}">Resend OTP</a>
                        </div>
                        <div class="col-12">
                            <p class="text-center"> <button type="submit" class="btn common-btn">Log in <i class="bi bi-arrow-right"></i></button> </p>
                        </div>
                    </form>
                    
                    <hr class="my-4" style="opacity: 0.2;">
                    
                </div>
            </div>
        </div>
    </div>
 </div>


<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function () {
        $('#resendOtpLink').click(function (e) {
            e.preventDefault();
            var userId = $(this).data('user-id');
            $.ajax({
                url: '{{ url("user-resend-otp") }}/' + userId,
                type: 'GET',
                success: function (response) {
                    alert(response.success);
                },
                error: function (xhr, status, error) {
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