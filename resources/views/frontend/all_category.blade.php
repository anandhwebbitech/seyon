@extends('frontend.layouts.app')
@section('content')




   <div class="page-banner">
    <div class="container">
        <ul class="navigation-list">
            <li><a href="{{ route('home') }}">Home</a></li>
            <li>Categories</li>
        </ul>
    </div>
   </div>


    <section class="product-categorey">
        <div class="container">
            <h1 class="main-title"><span>Our Categories</span></h1>
            <div class="product-categorey-list mt-4">
                <div class="row gy-4">
                    
                    @php
                        $categories = App\Models\ProductCategory::all();
                    @endphp

                    @if($categories)
                        @foreach($categories as $key => $item)
                            <div class="col-lg-2 col-6 col-md-3">
                                <div class="card text-center border-0 shadow-sm">
                                    <div class="img-box">
                                        <a href="{{ route('category.list') }}?selected_categories[]={{ $item->id }}">
                                            <img 
                                                src="{{ url('public/product_images/category_images/' . $item->category_image) }}" 
                                                alt="{{ $item->name }}" 
                                                class="img-fluid rounded">
                                        </a>
                                    </div>
                                    <div class="card-content mt-2">
                                        <a 
                                            href="{{ route('category.list') }}?selected_categories[]={{ $item->id }}" 
                                            class="text-decoration-none text-dark fw-semibold">
                                            {{ $item->name }}
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    @endif

                    
                </div>
            </div>
        </div>
    </section>




    

    <section class="news-letter">
        <div class="container">
            <div class="news-letter-box">
                <div class="row gy-3">
                    <div class="col-lg-6 col-md-8">
                        <h1 class="letter-title">Join Our Newsletter and Get...</h1>
                        <p class="letter-text"></p>
                        <div class="input-group mt-3 ">
                            <input type="text" class="form-control" placeholder="What are you Looking For ?" aria-label="What are you Looking For ?" aria-describedby="button-addon2">
                            <button class="btn search-btn" type="button" id="button-addon2">Subscribe<i class="fa-solid fa-arrow-right"></i></button>
                          </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    



@endsection





<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>




<script>
$(document).ready(function() {
    // Check if the item is in the cart and show the message if necessary
    @if(session('cart'))
        @foreach(session('cart') as $id => $details)
            $('#adding-cart-{{ $id }}').show();
            $('#add-cart-btn-{{ $id }}').hide();
        @endforeach
    @endif
    
    @if(session('wishlist'))
        @foreach(session('wishlist') as $id => $details)
            $('#adding-wishlist-{{ $id }}').show();
            $('#add-wishlist-btn-{{ $id }}').hide();
        @endforeach
    @endif
    
});
</script>


<script>
    $(document).ready(function () {
        $('.add-to-wishlist-button').on('click', function () {
            var productId = $(this).data('product-id');
    
            $.ajax({
                type: 'GET',
                url: '{{ url("add-to-wishlist") }}/' + productId,
                success: function (data) {
                    $("#adding-wishlist-" + productId).show();
                    $("#add-wishlist-btn-" + productId).hide();
                    window.location.reload();
                },
                error: function (error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
    });
</script>