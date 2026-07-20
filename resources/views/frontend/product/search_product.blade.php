@extends('frontend.layouts.app')
@section('content')

<div class="page-banner">
        <div class="container">
            <ul class="navigation-list">
                <li><a href="{{ route('home') }}">Home</a></li>
                <li>Products</li>
            </ul>
        </div>
       </div>

   
       <section class="products-section">
        <div class="container">
            <div class="row gy-4">
                  
                  
                
                
  
                <div class="col-lg-12">
                    <div class="card-list">
                        <div class="row gy-4">
                            @if($product)
                                @foreach($product as $key => $item)
                                    <div class="col-lg-3 col-md-6">
                                        <div class="card">
                                            <div class="card-img">
                                                <div class="offer-badge">{{ $item->discount }} % off</div>
                                                
                                                
                                                <a href="javascript:void(0);"
                                                    data-product-id="{{ $item->id }}"
                                                    id="add-wishlist-btn-{{ $item->id }}"
                                                    class="like-icon add-wishlist-btn add-to-wishlist-button"><i class="bi bi-heart"></i>
                                                </a>
                                                
                                                <a id="adding-wishlist-{{ $item->id }}"
                                                    class="like-icon added-msg"
                                                    style="display: none"><i class="bi bi-heart-fill"></i></a>
                                                
                                              <a href="{{ route('product.details.show',$item->id) }}" class="card-img-link">  <img src="{{ url('public/product_images/'.$item->product_img) }}" alt=""></a>
                                            </div>
                                            
                                            <div class="card-body">
                                                
                                                @if($item->quantity != 0 && $item->quantity != '')
                                                <div class="add-icon">
                                                    <a href="javascript:void(0);"
                                                    data-product-id="{{ $item->id }}"
                                                    id="add-cart-btn-{{ $item->id }}"
                                                    class="btn btn-warning btn-block text-center add-cart-btn add-to-cart-button"><i class="bi bi-plus"></i></a>

                                                  <a id="adding-cart-{{ $item->id }}"
                                                    class="btn btn-warning btn-block text-center added-msg"
                                                    style="display: none"><i class="bi bi-check-circle"></i></a>
                                                </div>
                                                
                                                @else
                                                    <span style="color: #EA4B48;font-size: 15px;">(Out of stock)</span><br>
                                                @endif
                                                
                                                @php 
                                                    $reviews = App\Models\Review::where('product_id', $item->id)->get(); 
                                                    $averageRating = round($reviews->avg('star_count'), 2);
                                                @endphp
                                                
                                                @if($reviews->isNotEmpty())
                                                <span class="star-rating">
                                                    <i class="bi bi-star{{ in_array($averageRating, [1, 2, 3, 4, 5]) ? '-fill' : ' ' }}"></i>
                                                    <i class="bi bi-star{{ in_array($averageRating, [2, 3, 4, 5]) ? '-fill' : ' ' }}"></i>
                                                    <i class="bi bi-star{{ in_array($averageRating, [3, 4, 5]) ? '-fill' : ' ' }}"></i>
                                                    <i class="bi bi-star{{ in_array($averageRating, [4, 5]) ? '-fill' : ' ' }}"></i>
                                                    <i class="bi bi-star{{ in_array($averageRating, [5]) ? '-fill' : ' ' }}"></i>
                                                </span>
                                                @else
                                                <span>No reviews available.</span>
                                                @endif
                                                <div class="product-title"><a href="{{ route('product.details.show',$item->id) }}">{{ $item->product_name }}</a></div>
                                                <p class="product-rate">₹{{ $item->offer_price }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                
                
                
                <!-- Modal -->
                <div class="modal fade" id="productDetailsModal" tabindex="-1" role="dialog" aria-labelledby="productDetailsModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                        <h5 class="modal-title" id="productDetailsModalLabel">Product Details</h5>
                        <button type="button" class="close btn-close"  data-bs-dismiss="modal" aria-label="Close">
                        </button>
                      </div>
                      <div class="modal-body" id="productDetailsBody">
                        <!-- Product details will be populated here -->
                      </div>
                    </div>
                  </div>
                </div>

                
                
              </div>
           
        </div>
    </section>




@endsection

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>


<script type="text/javascript">
    function filter(){
        $('#search-form').submit();
    }
</script>
    
    

<script>
$(document).ready(function() {
    // Event listener for Add to Cart button
    $('.add-to-cart-button').on('click', function() {
        var productId = $(this).data('product-id');

        // Fetch product details using AJAX
        $.ajax({
            url: '{{ url("get-product-details") }}',
            method: 'GET',
            data: {
                id: productId
            },
            success: function(response) {
                // Populate modal with product details
                $('#productDetailsBody').html(response);
                // Open the modal
                $('#productDetailsModal').modal('show');
            }
        });
    });
});
</script>



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




