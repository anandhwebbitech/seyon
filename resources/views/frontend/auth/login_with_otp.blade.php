@extends('frontend.layouts.app')
@section('content')

<div class="page-banner">
        <div class="container">
            <ul class="navigation-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Login with OTP</li>
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
                    <h1 class="login-title">Log In with OTP</h1>
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
                    <form class="row gy-4" method="POST" action="{{ route('verify.user.otp') }}">
                        @csrf
                        <div class="col-md-12">
                            <input type="text" name="phone_or_email" class="form-control" placeholder="Email or Phone" id="inputEmail4" required>
                        </div>
                        <div class="col-12">
                            <p class="text-center"> <button type="submit" class="btn common-btn">Get OTP <i class="bi bi-arrow-right"></i></button> </p>
                        </div>
                    </form>
                    
                    <hr class="my-4" style="opacity: 0.2;">
                    
                    <div class="row gy-4">
                        <div class="col-md-7">
                            <p class="login-text text-end">If you don’t have an account register you can <a href="{{ route('register') }}">Register</a></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
 </div>



@endsection