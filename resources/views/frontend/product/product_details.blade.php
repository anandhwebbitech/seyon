{{-- <style>
.modal-content{
        border-radius: 8px;
}
.product-detailss .product-detail-content {
padding: 0px 20px;
}
 .product-detailss{
    padding: 20px 0px;
}
.product-detailss .product-detail-content .card-btns {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
}
 .product-detailss .product-detail-content .author-name a {
    color: #1A1A1A;
}
.product-detailss .product-detail-content p{
    /*color: #666;
    font-size: 15px;*/
        position: relative;
    margin-bottom: 5px;
    font-size: 16px;
    font-weight: 400;
    color: #1A1A1A;
    text-transform: capitalize;
}
.product-amount {
    color: #30844A !important;
    font-size: 20px !important;
    margin-bottom: 10px !important;
    font-weight: 700 !important;
    font-family: "Roboto", sans-serif;
}
.product-detail-content .product-title{
    font-size: 20px;
    color: #000;
    font-weight: 700;
    margin-bottom: 15px;
    padding-bottom: 0px;
    border-bottom: 0px dashed #c1c1c1;
    font-family: 'Lato', sans-serif;
}
.amount-strike {
    color: #B3B3B3;
    font-weight: 400;
    font-size: 18px;
    margin-left: 15px;
    text-decoration: line-through;
    font-family: "Roboto", sans-serif;
}
.product-detailss .product-detail-content .categorey-subtitle {
    position: relative;
    margin-bottom: 15px;
    font-size: 16px;
    font-weight: 600;
    color: #1A1A1A;
    text-transform: capitalize;
    padding-bottom: 15px;
    border-bottom: 1px solid #E6E6E6;
}

.product-detailss .product-detail-content .categorey-subtitle span {
    color: #A0A0A0;
    font-weight: 400 !important;
}

.common-btn {
    border: 1px solid #241D60 !important;
    background: #241D60;
    font-size: 15px;
    font-weight: 600;
    color: #fff;
    border-radius: 30px;
    padding: 12px 25px;
}
.product-detailss .product-detail-content .cart-btn {
    border: 1px solid #FFD731 !important;
    background: #FFD731;
    font-size: 15px;
    font-weight: 600;
    color: #30844A;
    border-radius: 30px;
    padding: 12px 120px;
}
.product-detailss .product-img {
    width: 100%;
}
.product-detailss .product-img img {
    width: 100%;
}
.cart-btn-css
{
    color:#fff;
    background:#e9530d;
}
.buy-btn-css
{
    background:#000;
    color:#fff;
}
.cart-btn-css:hover
{ 
    background:#000;
    color:#fff;
}
.buy-btn-css:hover
{
  color:#fff;
  background:#e9530d;
}
</style> --}}
<section class="product-detailss">
    <div class="container">
        <div class="row gy-4">
            <div class="col-lg-5 col-md-4">
                <div class="product-img">
                    <img src="{{ url('public/product_images/' . $product->product_img) }}" alt="">
                </div>
            </div>

            <div class="col-lg-7 col-md-8">
                <div class="product-detail-content">
                    <h1 class="product-title" style="font-size: 18px;"><span
                            class="tt">{{ $product->product_name }}</span></h1>
                    <!--<p class="author-name"><a href="https://webbitech.co.in/PHP-CREATIVE/author/ranjithkumar">By ranjithkumar</a></p>-->
                    <p class="product-amount mt-2"><i class="bi bi-currency-rupee"></i>₹ {{ $product->offer_price }}
                        <span class="amount-strike">₹ {{ $product->orginal_rate }}</span> </p>
                    <div class="card-btns">
                        <div>
                            <a href="javascript:void(0);" data-product-id="{{ $product->id }}"
                                id="add-cart-btn-buy-product-{{ $product->id }}"
                                class="btn buy-btn-css btn-block text-center add-cart-btn add-to-cart-button-buy-product"
                                style="padding: 12px 30px;">Buy Now</i></a>
                        </div>
                        <div class="btn-2">
                            <a href="javascript:void(0);" data-product-id="{{ $product->id }}"
                                id="add-cart-btnn-{{ $product->id }}"
                                class="btn cart-btn-css btn-block text-center add-cart-btn add-to-cart-buttonn"
                                style="padding: 12px 30px;">Add to Cart</i></a>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
    </div>
</section>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

{{-- <script>
   $(document).ready(function () {
        $('.add-to-cart-buttonn').on('click', function () {
            var productId = $(this).data('product-id');
    
            $.ajax({
                type: 'GET',
                url: '{{ url("add-to-cart") }}/' + productId,
                success: function (data) {
                    $("#adding-cart-" + productId).show();
                    $("#add-cart-btnn-" + productId).hide();
                    window.location.reload();
                },
                error: function (error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
    });
    
    $(document).ready(function () { 
        $('.add-to-cart-button-buy-product').on('click', function () {
            var productId = $(this).data('product-id');
            $.ajax({
                type: 'GET',
                url: '{{ url("add-to-cart-buy-product") }}/' + productId,
                success: function (data) {
                    $("#adding-cart-" + productId).show();
                    $("#add-cart-btn-buy-product-" + productId).hide();
                    window.location.href = '{{ url("/cart") }}';
                },
                error: function (error) {
                    console.error('Error adding to cart:', error);
                }
            });
        });
    });
    
    
</script> --}}