<!DOCTYPE html>
<html lang="en">
<head>
    @include('frontend.include.header')
</head>

<body>

    {{-- Preloader should be FIRST inside body --}}
    {{-- <div id="preloader">
        <div class="lds-ripple">
            <div>
                <p>TEST SDFT</p>
            </div>
            <div>sff</div>
        </div>
    </div> --}}

    @include('frontend.include.navbar')

    @yield('content')

    @include('frontend.include.footer')

    {{-- jQuery FIRST --}}
    <script src="{{ asset('frontend/js/jquery.min.js') }}"></script>

    {{-- CSRF Setup --}}
    <script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            }
        });
    </script>

    {{-- Main Scripts --}}
    <script src="{{ asset('frontend/js/script.js') }}"></script>
    <script src="{{ asset('frontend/js/custom_script.js') }}"></script>

    {{-- Bootstrap --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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
