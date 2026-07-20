<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="keywords" content="">
	<meta name="author" content="">
	<meta name="robots" content="">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<meta name="csrf-token" content="{{ csrf_token() }}">
	<link rel="icon" type="image/png" href="{{ asset('frontend/fav-icon.png') }}">
	<!-- PAGE TITLE HERE -->
	<title>Admin Dashboard</title>
	<!-- Datatable -->
    <link href="<?php echo url('');?>/vendor/datatables/css/jquery.dataTables.min.css" rel="stylesheet">
	
	<!-- FAVICONS ICON -->
	<link href="<?php echo url('');?>/vendor/jquery-nice-select/css/nice-select.css" rel="stylesheet">
	<link href="<?php echo url('');?>/vendor/owl-carousel/owl.carousel.css" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo url('');?>/vendor/nouislider/nouislider.min.css">
	<!-- Style css -->
    <link href="<?php echo url('');?>/css/fancybox.min.css" rel="stylesheet">
    <link href="<?php echo url('');?>/css/style.css" rel="stylesheet">
    
    <link href="<?php echo url('');?>/assets/crop/croppie.css" rel="stylesheet" type="text/css" />
    
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

   
    

	
</head>
<body>
    
    <style>
        .outer-box {
            background-color: #fff;
            transition: all .5s ease-in-out;
            position: relative;
            border: 0rem solid transparent;
            border-radius: 1.25rem;
            box-shadow: 0rem 0.3125rem 0.3125rem 0rem rgba(82, 63, 105, 0.05);
            /* height: calc(100% - 30px); */
            padding: 20px;
        }
    </style>

    <!--*******************
        Preloader start
    ********************-->
    <div id="preloader">
		<div class="lds-ripple">
			<div></div>
			<div></div>
		</div>
    </div>
    <!--*******************
        Preloader end
    ********************-->

    <!--**********************************
        Main wrapper start
    ***********************************-->
    <div id="main-wrapper">

        
		@include('admin.include.header')
		
		@include('admin.include.sidebar')

		



		
		<!--**********************************
            Content body start
        ***********************************-->
        <div class="content-body">
            <!-- row -->
			<div class="container-fluid">
				<div class="outer-box">
				    <div class="row">
    				    @yield('admin')
    				</div>
				</div>
            </div>
        </div>
        <!--**********************************
            Content body end
        ***********************************-->

        @include('admin.include.footer')



	</div>
    <!--**********************************
        Main wrapper end
    ***********************************-->

    <!--**********************************
        Scripts
    ***********************************-->
    <!-- Required vendors -->
    <script src="<?php echo url('');?>/vendor/global/global.min.js"></script>
	<script src="<?php echo url('');?>/vendor/chart.js/Chart.bundle.min.js"></script>
	<script src="<?php echo url('');?>/vendor/jquery-nice-select/js/jquery.nice-select.min.js"></script>
	
	<!-- Apex Chart -->
	{{-- <script src="<?php echo url('');?>/vendor/apexchart/apexchart.js"></script> --}}
	<script src="<?php echo url('');?>/vendor/chart.js/Chart.bundle.min.js"></script>
	<!-- Chart piety plugin files -->
    <script src="<?php echo url('');?>/vendor/peity/jquery.peity.min.js"></script>
	<!-- Dashboard 1 -->
	<script src="<?php echo url('');?>/js/dashboard/dashboard-1.js"></script>
	
	<script src="<?php echo url('');?>/vendor/owl-carousel/owl.carousel.js"></script>
	
    <script src="<?php echo url('');?>/js/custom.min.js"></script>
	<script src="<?php echo url('');?>/js/dlabnav-init.js"></script>
	<script src="<?php echo url('');?>/js/demo.js"></script>
	<script src="<?php echo url('');?>/js/fancybox.min.js"></script>
	
	<!-- Datatable -->
    <script src="<?php echo url('');?>/vendor/datatables/js/jquery.dataTables.min.js"></script>
    <script src="<?php echo url('');?>/js/plugins-init/datatables.init.js"></script>
    
       
    
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-pzjw8f+0bKk0W2HI7JSn9j5e6shd2TAvgISy8jNwFgk0xh6w+rVbwabtTE0s5E3I" crossorigin="anonymous"></script>
    
    <!-- Croppie JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/croppie/2.6.5/croppie.min.js"></script>
    

	<script>
		function cardsCenter()
		{
			
			/*  testimonial one function by = owl.carousel.js */
			
	
			
			jQuery('.card-slider').owlCarousel({
				loop:true,
				margin:0,
				nav:true,
				//center:true,
				slideSpeed: 3000,
				paginationSpeed: 3000,
				dots: true,
				navText: ['<i class="fas fa-arrow-left"></i>', '<i class="fas fa-arrow-right"></i>'],
				responsive:{
					0:{
						items:1
					},
					576:{
						items:1
					},	
					800:{
						items:1
					},			
					991:{
						items:1
					},
					1200:{
						items:1
					},
					1600:{
						items:1
					}
				}
			})
		}
		
		jQuery(window).on('load',function(){
			setTimeout(function(){
				cardsCenter();
	}, 1000); 
		});
		
	</script>

</body>
</html>