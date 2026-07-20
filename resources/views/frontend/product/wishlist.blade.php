@extends('frontend.layouts.app')
@section('content')
    <!-- Breadcrumb Section -->
    <section class="breadcrumb-section">
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a class="text-decoration-none text-dark" href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page">Wishlist</li>
            </ol>
        </nav>
        <h4 class="page-title">Wishlist</h4>
    </section>


    <section class="py-5">
        <div class="container">
            <div class="row">
                @if($wishlists->isNotEmpty())
                @foreach ($wishlists as $wishlist)
                    <div class="col-lg-3 col-md-6 col-6 my-3 product-card">
                        <div class="card product-card1">
                            <!-- <span class="badge text-dark discount-badge">25% OFF</span> -->
                            <div class="ratio ratio-4x3 position-relative">
                                <img src="{{ asset($wishlist->product->product_img) }}" class="card-img-top object-fit-cover"
                                    alt="Small Parking Lot Wooden Magnetic Alphabet Maze Puzzle for Kid">
                                <div class="product-actions">
                                    {{-- <a href="#" class="card-btun btn-sm action" title="Wishlist"
                                        aria-label="Add to wishlist">
                                        <i class="bi bi-heart"></i>
                                    </a> --}}
                                    <a href="{{ route('product.details.show', $wishlist->product->id) }}" class="card-btun btn-sm action" title="Quick view"
                                        aria-label="Quick view">
                                        <i class="bi bi-eye"></i>
                                    </a>
                                    <a href="{{ route('addto.cart', $wishlist->product->id) }}" class="card-btun btn-sm action" title="Add to cart"
                                        aria-label="Add to cart">
                                        <i class="bi bi-cart"></i>
                                    </a>
                                </div>
                            </div>
                            <div class="card-body p-2">
                                <p class="card-title small text-truncate-2 my-2">
                                    {{ $wishlist->product->product_name ?? ''}}
                                </p>
                                <div class="price small">
                                    <span class="text-danger fw-semibold">₹ {{ $wishlist->product->offer_price ?? ''}}</span>
                                    <span class="text-muted text-decoration-line-through">₹ {{ $wishlist->product->orginal_rate ?? ''}}</span>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end mb-3 me-2 me-2">
                                {{-- <a class="wish-but" href="#"><i class="bi bi-cart"></i>Add To Cart</a> --}}
                                <a class="wish-but wishlist-remove" data-product-id="{{ $wishlist->product->id }}" 
                                    data-url="{{ route('remove.wishlist', $wishlist->product->id ) }}" 
                                    data-login="{{ route('user.login') }}" href="javascript:void(0);"><i class="bi bi-trash"></i>Remove
                                </a>
                                                                
                            </div>

                        </div>
                    </div>
                @endforeach
                @endif
            </div>
        </div>
    </section>
@endsection
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
