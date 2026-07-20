<!DOCTYPE html>
<html lang="en" class="h-100">

<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="_token" content="{{ csrf_token() }}">
	
	<!-- PAGE TITLE HERE -->
	<title>Admin Dashboard</title>
	<link rel="icon" type="image/png" href="{{ asset('frontend/fav-icon.png') }}">
	<!-- FAVICONS ICON -->
	<link rel="shortcut icon" type="image/png" href="{{ asset('frontend/fav-icon.png') }}">
    <link href="{{ asset('backend/css/style.css')}}" rel="stylesheet">

</head>

<body class="vh-100">
    <div class="authincation h-100">
        <div class="container h-100">
            <div class="row justify-content-center h-100 align-items-center">
                <div class="col-md-6">
                    <div class="authincation-content">
                        <div class="row no-gutters">
                            <div class="col-xl-12">
                                <div class="auth-form">
									<div class="text-center mb-3">
										<a href="{{ route('home') }}"><img src="{{ asset('frontend/img/logo.png') }}" height="70px" alt=""></a>
									</div>
                                    <h4 class="text-center mb-4">Sign in your account</h4>
                                    
                                   @if (session('error'))
                                        <div class="alert alert-danger">
                                            {{ session('error') }}
                                        </div>
                                    @endif
                                    
                                    
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


    								
                                    <form action="{{ route('admin.login') }}" method="POST">
                                        @csrf
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Email</strong></label>
                                            <input type="email" name="email" class="form-control">
                                        </div>
                                        <div class="mb-3">
                                            <label class="mb-1"><strong>Password</strong></label>
                                            <input type="password" name="password" class="form-control">
                                        </div>
                                        <div class="text-center">
                                            <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="vendor/global/global.min.js"></script>
    <script src="{{ asset('backend/js/custom.min.js')}}"></script>
    <script src="{{ asset('backend/js/dlabnav-init.js')}}"></script>
	<!--<script src="js/styleSwitcher.js"></script>-->
</body>
</html>