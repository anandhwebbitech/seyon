/* =======================
   DOCUMENT READY
======================= */
$(document).ready(function () {
    bindWishlist();
    bindRemoveWishlist();
    bindQtyButtons();
    bindCartButtons();
    cartList();
});


/* =======================
   WISHLIST ADD
======================= */
function bindWishlist(selector = '.wishlist-btn') {

    $(document)
        .off('click', selector)
        .on('click', selector, function () {

            const button = $(this);
            const productId = button.data('id');
            const productUrl = button.data('url');
            const userLogin = button.data('login');
            const icon = button.find('i');

            $.post(productUrl, {
                product_id: productId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function (response) {

                if (response.status === 'login_required') {
                    window.location.href = userLogin;
                }

                if (response.status === 'added') {
                    icon.removeClass('bi-heart').addClass('bi-heart-fill');
                    button
                        .attr('data-bs-original-title', 'Added to Wishlist')
                        .tooltip('dispose')
                        .tooltip();
                    $('.wishlist_count').text('(' + response.wishlist_count + ')');
                }

                if (response.status === 'exists') {
                    icon.removeClass('bi-heart').addClass('bi-heart-fill');
                    button.css('color', '#dc3545');
                }

            });
        });
}


/* =======================
   WISHLIST REMOVE
======================= */
function bindRemoveWishlist(selector = '.wishlist-remove') {

    $(document)
        .off('click', selector)
        .on('click', selector, function () {

            const button = $(this);
            const prodId = button.data('product-id');
            const prodUrl = button.data('url');
            const userLogin = button.data('login');

            $.post(prodUrl, {
                product_id: prodId,
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function (response) {

                if (response.status === 'login_required') {
                    window.location.href = userLogin;
                }

                if (response.status === 'removed') {
                    button.closest('.product-card').fadeOut();
                    $('.wishlist_count').text('(' + response.wishlist_count + ')');
                }

                if (response.status === 'not_found') {
                    alert('Wishlist item not found!');
                }

            });
        });
}


/* =======================
   PRODUCT QTY (+ -) PAGE
======================= */
function bindQtyButtons() {

    $(document)
        .off('click', '.increase_qty, .decrease_qty')
        .on('click', '.increase_qty, .decrease_qty', function () {

            const button = $(this);
            const url = button.data('url');
            const msgDiv = $('#sessionMessage');

            $.post(url, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function (response) {

                if (response.status === 'success') {
                    button.siblings('.item-qty').text(response.new_qty);
                } else {
                    msgDiv
                        .removeClass('d-none alert-success')
                        .addClass('alert-danger')
                        .text(response.message);
                }

                setTimeout(() => msgDiv.addClass('d-none'), 3000);
                location.reload();
            });
        });
}


/* =======================
   CART + / -
======================= */
function bindCartButtons() {

    $(document)
        .off('click', '.increase, .decrease')
        .on('click', '.increase, .decrease', function () {

            const button = $(this);
            const id = button.data('id');

            const url = button.hasClass('increase')
                ? increaseCartRoute + '/' + id
                : decreaseCartRoute + '/' + id;

            $.post(url, {
                _token: $('meta[name="csrf-token"]').attr('content')
            }, function (res) {
                if (res.status === 'success') {
                    cartList();
                }
            });
        });
}


/* =======================
   LOAD CART
======================= */
function cartList() {

    $.get(cartListUrl, function (items) {

        let html = '';
        let subtotal = 0;

        if (!items.length) {
            html = `<p class="text-center">Your cart is empty</p>`;
        } else {

            $.each(items, function (i, item) {

                let total = item.quantity * item.product.offer_price;
                subtotal += total;

                // ---- COLOR HTML (FIXED) ----
                let colorHtml = '';

                if (item.colorData) {
                    colorHtml = `
                        <label
                            title="${item.colorData.color}"
                            class="color-dot"
                            style="background-color:${item.colorData.color_code}">
                        </label>
                    `;
                }

                html += `
                <div class="cart-item p-2">
                    <div class="item-image">
                        <img src="${assetBase}${item.product.product_img}" width="60">
                    </div>

                    <div class="item-details">
                        <div class="item-title">${item.product.product_name}</div>

                        <div class="quantity-controls">
                            <button class="qty-btn decrease" data-id="${item.id}">-</button>
                            <input class="qty-input" value="${item.quantity}" readonly>
                            <button class="qty-btn increase" data-id="${item.id}">+</button>
                        </div>

                        <div class="d-flex align-items-center gap-2 mt-1">
                            <div class="item-price">₹ ${total}</div>

                            <div class="color_picker d-flex align-items-center gap-1">
                                ${colorHtml}
                            </div>
                        </div>
                    </div>

                    <button class="remove-btn" onclick="removeCart(${item.id})">
                        <i class="fas fa-trash"></i>
                    </button>
                </div>`;
            });
        }

        $('#cartModal .cart-body').html(html);
        $('#subtotalAmount').text('₹ ' + subtotal);
        $('#cart-count').text(items.length);
    });
}


/* =======================
   REMOVE CART ITEM
======================= */
function removeCart(id) {

    if (!confirm('Remove this item?')) return;

    $.post(removeCartRoute, {
        cart_id: id,
        _token: $('meta[name="csrf-token"]').attr('content')
    }, function (response) {

        if (response.status === 'success') {
            location.reload();
        }
    });
}