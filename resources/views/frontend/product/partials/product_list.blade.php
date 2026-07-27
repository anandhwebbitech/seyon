<div class="row">
    @forelse ($products as $data)
        <div class="col-lg-4 col-md-6 col-6 my-3">
            <div class="card product-card1">
                <div class="ratio ratio-4x3 position-relative">
                    <a href="{{ route('product.details.show', $data->id) }}" class="image-box">
                        <!-- Main Image -->
                        <img src="{{ asset($data->product_img) }}" class="main-img" alt="{{ $data->product_name }}" loading="lazy">

                        <!-- Hover Image -->
                        <img src="{{ asset($data->proImages->last()->path ?? $data->product_img) }}" class="hover-img" alt="Product">
                    </a>

                    <div class="product-actions">
                        @if ($data->isWishlist)
                            <a href="{{ route('show.wishlist.list') }}" class="card-btun btn-sm action text-danger" title="Remove from wishlist">
                                <i class="bi bi-heart-fill"></i>
                            </a>
                        @else
                            <a href="javascript:void(0)" class="card-btun btn-sm action wishlist-btn"
                                data-id="{{ $data->id }}"
                                data-url="{{ route('addto.wishlist', $data->id) }}"
                                data-login="{{ route('user.login') }}" title="Wishlist">
                                <i class="bi bi-heart"></i>
                            </a>
                        @endif
                        <a href="{{ route('product.details.show', $data->id) }}" class="card-btun btn-sm action" title="Quick view">
                            <i class="bi bi-eye"></i>
                        </a>
                        <a href="{{ route('addto.cart', $data->id) }}" class="card-btun btn-sm action" title="Add to cart">
                            <i class="bi bi-cart"></i>
                        </a>
                    </div>
                </div>

                <div class="card-body p-2">
                    <p class="card-title small text-truncate-2 mb-1">
                        {{ \Illuminate\Support\Str::limit($data->product_name, 15) }}
                    </p>
                    <div class="price small d-flex align-items-center gap-2 flex-wrap">
                        @if (!empty($data->orginal_rate) && $data->orginal_rate != $data->offer_price)
                            <span class="text-danger text-decoration-line-through">
                                ₹ {{ $data->orginal_rate }}
                            </span>
                        @endif

                        <span class="text-danger fw-semibold">
                            ₹ {{ $data->offer_price ?? '-' }}
                        </span>

                        @php $colors = $data->colors; @endphp
                        <div class="color_picker d-flex align-items-center gap-1 ms-2">
                            @foreach ($colors as $color)
                                <label title="{{ $color->color }}" class="color-dot" style="background-color: {{ $color->color_code }}"></label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @empty
        <div class="col-12 text-center py-5">
            <h5 class="text-muted">No Products Found!</h5>
        </div>
    @endforelse
</div>

<!-- Pagination -->
<div class="d-flex justify-content-center mt-4">
    {{ $products->links('pagination::bootstrap-5') }}
</div>