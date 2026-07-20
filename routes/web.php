<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\ChangePasswordController;
use App\Http\Controllers\Admin\BlogController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CountryController;
use App\Http\Controllers\Admin\StateController;
use App\Http\Controllers\Admin\CityController;
use App\Http\Controllers\Admin\GiftWrapController;
use App\Http\Controllers\Admin\MileStoneController;
use App\Http\Controllers\Admin\orderController;
use App\Http\Controllers\Admin\ShippingPriceController;
use App\Http\Controllers\Admin\ShopByAgeController;
use App\Http\Controllers\Admin\ShopByPriceController;
use App\Http\Controllers\Admin\ShopByReelController;
use App\Http\Controllers\Frontend\AuthController;
use App\Http\Controllers\Frontend\MemberController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\AddressController;
use App\Http\Controllers\Frontend\GoogleAuthController;
use App\Http\Controllers\Frontend\PaymentController;
use App\Http\Controllers\TpcApiController;
use App\Models\Setting;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::get('/clear-everything', function() {
    \Artisan::call('view:clear');
    \Artisan::call('cache:clear');
    return "All caches cleared successfully!";
});
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('login-with-otp', function () {
    session()->put('auth_type', 'login-with-otp');
    return view('frontend.auth.login_otp');
})->name('login.otp');

Route::get('forgot-password-step1', function () {
    session()->forget('auth_type');
    return view('frontend.auth.forgot_password_step1');
})->name('forgot_password_step1');

// Route::get('login-with-otp', function () {
//     return view('frontend.auth.login_with_otp');
// })->name('login.otp');

Route::get('contact', function () {
    return view('frontend.contact');
})->name('contact');

Route::get('terms-condition', function () {
    $termsCondition = Setting::where('key', 'terms')->first();
    return view('frontend.terms_condition', compact('termsCondition'));
})->name('terms_condition');

Route::get('privacy-policy', function () {
    $privacyPolicy = Setting::where('key', 'privacy_policy')->first();
    return view('frontend.privacy', compact('privacyPolicy'));
})->name('privacy_policy');

Route::get('all-category', function () {
    return view('frontend.all_category');
})->name('all.category');

Route::controller(HomeController::class)->group(function () {
    Route::post('send-message', 'send')->name('contact.send');
    Route::get('product/search', 'searchList')->name('search.product');
});

Route::controller(AuthController::class)->group(function () {

    Route::get('user/login', 'login')->name('user.login');
    Route::post('user/signin', 'signin')->name('signin');
    Route::post('user/signup', 'signup')->name('signup');
    Route::post('user-verification', 'otpvarification')->name('otpvarification');
    Route::get('register', 'register')->name('register');
    Route::get('user/logout', 'logout')->name('user.logout');
    Route::get('user-resend-otp/{user_id}', 'userresendOtp')->name('userresendOtp');
    Route::post('verify-user', 'verify_user')->name('verify.user.otp');
    Route::post('user-verify-otp', 'user_verify_otp')->name('user.otp.verify');
    Route::post('forgot-password-step2', 'forgot_password_step2')->name('forgot_password_step2');
    Route::post('verification_code', 'verification_code')->name('verification_code');
    Route::post('reset-password', 'reset_password')->name('reset_password');
});

Route::controller(HomeController::class)->group(function () {
    Route::get('/products', 'search')->name('category.list');
    Route::get('product/category-list', 'prodCategoryList')->name('prod.category.list');

    Route::get('product/subcategory/{id}', 'subCategoryList')->name('subcategory.list');

    Route::get('get-product-details', 'getProductDetails')->name('get-product-details');

    Route::get('product-details/{id}', 'productDetails')->name('product.details.show');
});

Route::get('/auth/google/redirect', [GoogleAuthController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleAuthController::class, 'callback'])->name('auth.google.callback');

Route::middleware(['user.auth'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('cart', 'showCartTable')->name('show.cart.table');
        Route::get('/cart-list', 'getCart')->name('cart.list');
        Route::get('add-to-cart/{id}', 'addToCart')->name('addto.cart');
        // buy now
        Route::post('buy-now', 'buyNow')->name('buy.now');
        //cart page
        Route::post('/incress-qty/{id}', 'increaseQty')->name('increase.qty');
        Route::post('/decrease-qty/{id}', 'decreaseQty')->name('decrease.qty');
        // cart modal
        Route::post('/incress-cart-qty/{id}', 'increaseCartQty')->name('increase.cart.qty');
        Route::post('/decrease-cart-qty/{id}', 'decreaseCartQty')->name('decrease.cart.qty');
        Route::post('/cart/increase/{id}', [HomeController::class, 'increaseCartQty']);
        Route::post('/cart/decrease/{id}', [HomeController::class, 'decreaseCartQty']);
        Route::post('/cart/remove', 'removeCart')->name('cart.remove');
        // Wrap
        Route::post('/gift-wrap/update', 'wrapUpdate')->name('wrap.update');
        Route::post('/gift-message/update', 'wrapMessageUpdate')->name('wrap.message.update');
        Route::post('/gift-message/remove', 'removeMessageUpdate')->name('wrap.message.remove');
        Route::post('apply-coupon', 'applyCoupon')->name('apply.coupon');
        Route::post('remove-coupon', 'removeCoupon')->name('remove.coupon');

        Route::get('clear-cart', 'clearCart')->name('clear.cart');
        Route::get('add-to-cart-buy-product/{id}', 'addToCartBuy')->name('addto.cart.buy');

        Route::get('proceed-to-checkout', 'proceed_to_checkout')->name('product.proceed_to_checkout');

        Route::post('remove-wishlist/{id}', 'removeWishlist')->name('remove.wishlist');
        Route::get('/wishlist', 'wishlistList')->name('show.wishlist.list');
        Route::post('add-to-wishlist/{id}', 'addToWishlist')->name('addto.wishlist');
    });

    Route::controller(MemberController::class)->group(function () {
        Route::get('user/dashboard', 'dashboard')->name('user.dashboard');
        Route::get('user/edit-profile', 'editProfile')->name('user.profile.edit');
        Route::post('user/update-profile', 'updateProfile')->name('user.profile.update');

        Route::post('update-profile-image', 'updateProfileImg')->name('update.profile.image');

        Route::post('user/upload-image', 'upload')->name('image.upload');

        Route::get('user/change-password', 'changePassword')->name('change.password');
        Route::post('user/update-password', 'updatePassword')->name('user.update.password');
        Route::get('user/my-address', 'userAddress')->name('user.address');
        Route::get('user/delete-address/{id}', 'deleteAddress')->name('user.address.delete');

        Route::get('user/order-history', 'orderHistory')->name('user.order.history');
        Route::get('user/fetch-products', 'fetchProducts')->name('fetch.products');

        Route::post('user/add-review', 'addReview')->name('add.review');

        Route::get('user/order-details/{id}', 'userOrderDetails')->name('user.order.details');
        
        Route::post('/apply-exit-offer', 'applyExitOffer')->name('apply.exit.offer');
    });

    Route::controller(AddressController::class)->group(function () {
        Route::post('user/add-address', 'addNewAddress')->name('user.addNewAddress');
        Route::post('get-states', 'getStates')->name('getStates');
        Route::post('get-cities', 'getCities')->name('getCities');

        Route::post('get-updateAddress', 'updateAddress')->name('user.updateAddress');
        Route::post('order-confirm', 'orderConfirm')->name('order.confirm');

        Route::post('/user/address/{id}', 'getAddress')->name('user.getAddress');
        Route::post('/set/primary', 'setPrimary')->name('set.primary');
    });

    Route::controller(PaymentController::class)->group(function () {
        Route::post('payment-process', 'paymentProcess')->name('payment.process');
        Route::get('payment-invoice', 'invoice')->name('invoice');
        Route::post('payment-success', 'paymentSuccess')->name('payment.success');
        Route::get('/send-order-sms', 'sendOrderSms')->name('send.order.sms');
    });
});

Route::get('/admin', function () {
    return view('admin.login');
})->name('admin');


Route::controller(AdminController::class)->group(function () {
    Route::post('admin/login', 'admin_login')->name('admin.login');
    Route::get('admin/logout', 'admin_logout')->name('admin.logout');
});

Route::get('/tpc/pincode/{pin}', [TpcApiController::class, 'checkPincode']);
Route::get('/tpc/track/{pod}', [TpcApiController::class, 'trackEnhanced']);
Route::post('/tpc/webhook', [TpcApiController::class, 'webhook']);

Route::middleware(['admin.auth'])->group(function () {
    Route::controller(AdminController::class)->group(function () {
        Route::get('admin/dashboard', 'index')->name('admin.dashboard');
        Route::get('admin/courier-summary', 'courierSummary')->name('courier.summary');
        Route::get('/export/orders', 'export')->name('orders.export');

        Route::any('admin/profile', 'adminProfile')->name('admin.profile');
        Route::put('admin/profile-update', 'adminProfileUpdate')->name('admin.profile.update');

        Route::get('admin/users', 'regUsers')->name('admin.users');
        Route::get('admin/user-show/{id}', 'regUserPreview')->name('admin.user.preview');
        Route::get('admin/users-delete/{id}', 'regUserDelete')->name('admin.user.delete');


        Route::get('admin/banner-image', 'bannerImage')->name('admin.banner.show');
        Route::get('admin/banner-image-add', [AdminController::class, 'bannerImageAddPage'])
            ->name('admin.banner.add');

        Route::post('admin/banner-image-add', [AdminController::class, 'bannerImageAdd'])
            ->name('admin.banner.store');

        Route::get('admin/banner-image-delete/{id}', [AdminController::class, 'bannerImageDelete'])
            ->name('banner_images.delete');
        Route::get('admin/privacy-policy', 'privacyPolicy')->name('privacy.policy');
        Route::get('admin/terms-and-conditions', 'terms')->name('terms');
        Route::post('admin/policy-store', 'policyStore')->name('policy.store');

        // SMS API
        Route::get('/get/balance', 'getBalance')->name('get.balance');
        // Route::delete('/admin/user/delete/{id}', [AdminController::class, 'regUserDelete'])
        // ->name('admin.user.delete');
    });


    Route::controller(CountryController::class)->group(function () {
        Route::get('admin/country/index', 'index')->name('admin.country.index');
    });

    Route::controller(StateController::class)->group(function () {
        Route::get('admin/state/index', 'index')->name('admin.state.index');
    });

    Route::controller(CityController::class)->group(function () {
        Route::get('admin/city/index', 'index')->name('admin.city.index');
    });

    Route::controller(ShopByAgeController::class)->prefix('shop-by')->name('shop.by.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
        Route::get('/call-to-action', 'callToAction')->name('call.to.action');
        Route::post('/call-to-action-store', 'callToActionStore')->name('call.to.action.store');
    });
    Route::controller(ShopByPriceController::class)->prefix('by-price')->name('by.price.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'delete')->name('delete');
    });
    Route::controller(GiftWrapController::class)->prefix('gift-wrap')->name('gift-wrap.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });
    Route::controller(ShippingPriceController::class)->prefix('shipping-price')->name('shipping-price.')->group(function () {
        Route::get('/index', 'index')->name('index');
        Route::get('/create', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/edit/{id}', 'edit')->name('edit');
        Route::post('/update/{id}', 'update')->name('update');
        Route::get('/delete/{id}', 'destroy')->name('delete');
    });

    Route::controller(ProductController::class)->group(function () {
        // category
        Route::get('/product-category', 'productCategory')->name('admin.product.category');
        Route::get('/product-category-add', 'productCategoryAdd')->name('admin.product.category.add');
        Route::post('/product-category-store', 'productCategoryStore')->name('admin.product.category.store');
        Route::get('/product-category-delete/{id}', 'productCategoryDelete')->name('product.category.delete');
        Route::get('/product-category-edit/{id}', 'productCategoryEdit')->name('admin.product.category.edit');
        Route::post('/product-category-update', 'productCategoryUpdate')->name('admin.product.category.update');
        Route::get('/product-category-img-delete/{id}/{name}', 'productCategoryImgDelete')->name('product.category.imagedelete');
        Route::post('crop-image-upload-ajax', 'AjaxCrop')->name('crop-image-upload-ajax');

        // subcategory
        Route::get('/product-subcategory', 'productSubCategory')->name('admin.product.subcategory');
        Route::get('/product-subcategory-add', 'productSubCategoryAdd')->name('admin.product.subcategory.add');
        Route::post('/product-subcategory-store', 'productSubCategoryStore')->name('admin.product.subcategory.store');
        Route::get('/product-subcategory-delete/{id}', 'productSubCategoryDelete')->name('product.subcategory.delete');
        Route::get('/product-subcategory-edit/{id}', 'productSubCategoryEdit')->name('admin.product.subcategory.edit');
        Route::post('/product-subcategory-update', 'productSubCategoryUpdate')->name('admin.product.subcategory.update');
        Route::get('/product-subcategory-img-delete/{id}/{name}', 'productSubCategoryImgDelete')->name('product.subcategory.imagedelete');
        Route::post('crop-image-upload-ajax-subcat', 'AjaxCropSubcat')->name('crop-image-upload-ajax-subcat');

        // sub menus
        Route::get('/product-submenu', 'productSubmenu')->name('admin.product.submenu');
        Route::get('/product-submenu-add', 'productSubmenuAdd')->name('admin.product.submenu.add');
        Route::post('/product-submenu-store', 'productSubmenuStore')->name('admin.product.submenu.store');
        Route::get('/product-submenu-delete/{id}', 'productSubmenuDelete')->name('product.submenu.delete');
        Route::get('/product-submenu-edit/{id}', 'productSubmenuEdit')->name('admin.product.submenu.edit');
        Route::post('/product-submenu-update/{id}', 'productSubmenuUpdate')->name('admin.product.submenu.update');

        //product
        Route::get('/product', 'product')->name('admin.product');
        Route::get('/product-add', 'productAdd')->name('admin.product.add');
        Route::get('/get-subcategories/{id}', 'getSubcategories')->name('get-subcategories');
        Route::get('/get-menus/{id}', 'getMenus')->name('get-submenu');
        Route::post('/product-store', 'productStore')->name('admin.product.store');
        Route::get('/product-view/{id}', 'productView')->name('product.preview');
        Route::get('/product-edit/{id}', 'productEdit')->name('product.edit');
        Route::post('/product-update', 'productUpdate')->name('product.update');
        Route::get('/product-delete/{id}', 'productDelete')->name('product.delete');

        //coupon code
        Route::get('/coupon-code', 'coupon_code')->name('admin.coupon_code');
        Route::get('/product-coupon_code-add', 'coupon_code_add')->name('admin.product.coupon_code.add');
        Route::post('/product-coupon_code-store', 'coupon_code_store')->name('admin.product.coupon_code.store');
        Route::get('/product-coupon_code-delete/{id}', 'coupon_code_delete')->name('product.coupon_code.delete');
        Route::get('/product-coupon_code-edit/{id}', 'coupon_code_edit')->name('admin.product.coupon_code.edit');
        Route::post('/product-coupon_code-update', 'coupon_code_update')->name('admin.product.coupon_code.update');

        //color code
        Route::get('/color','color')->name('admin.color');
        Route::get('/product-color-add','color_add')->name('admin.product.color.add');
        Route::post('/product-color-store','color_store')->name('admin.product.color.store');
        Route::get('/product-color-delete/{id}','color_delete')->name('product.color.delete');
        Route::get('/product-color-edit/{id}','color_edit')->name('admin.product.color.edit');
        Route::post('/product-color-update','color_update')->name('admin.product.color.update');
        
        Route::post('/admin-product-image-delete', 'deleteImage')->name('admin.product.image.delete');
        Route::post('/admin-product-update', 'adminProductUpdate')->name('admin.product.update');
    });

    Route::controller(BlogController::class)->group(function () {
        // category
        Route::get('/blog-category', 'blogCategory')->name('admin.blog.category');
        Route::post('/blog-category-add', 'blogCategoryAdd')->name('admin.blog.category.add');
        Route::get('/blog-category-delete/{id}', 'blogCategoryDelete')->name('blog.category.delete');
        Route::get('/blog-category-edit/{id}', 'blogCategoryEdit')->name('admin.blog.category.edit');
        Route::post('/blog-category-update', 'blogCategoryUpdate')->name('admin.blog.category.update');

        // sub category
        Route::get('/blog-subcategory', 'blogSubCategory')->name('admin.blog.subcategory');
        Route::post('/blog-subcategory-add', 'blogSubCategoryAdd')->name('admin.blog.subcategory.add');
        Route::get('/blog-subcategory-delete/{id}', 'blogSubCategoryDelete')->name('blog.subcategory.delete');
        Route::get('/blog-subcategory-edit/{id}', 'blogSubCategoryEdit')->name('admin.blog.subcategory.edit');
        Route::post('/blog-subcategory-update', 'blogSubCategoryUpdate')->name('admin.blog.subcategory.update');

        //blog
        Route::get('/blog', 'blog')->name('admin.blog');
        Route::get('/blog-add', 'blogAdd')->name('admin.blog.add');
        Route::post('/blog-store', 'blogStore')->name('admin.blog.store');
        Route::get('/blog-view/{id}', 'blogView')->name('blog.preview');
        Route::get('/blog-edit/{id}', 'blogEdit')->name('blog.edit');
        Route::post('/blog-update', 'blogUpdate')->name('blog.update');
        Route::get('/blog-delete/{id}', 'blogDelete')->name('blog.delete');
    });

    Route::controller(ChangePasswordController::class)->group(function () {
        Route::get('/admin-change-password', 'showChangePasswordForm')->name('password.change');
        Route::post('/change-password', 'changePassword')->name('password.update');
    });


    Route::controller(orderController::class)->group(function () {

        Route::get('/admin-all-orders', 'orderList')->name('admin.order.list');
        Route::get('/admin-order-details/{id}', 'adminOrderDetails')->name('admin.order.detail');

        Route::post('/update-order-status', 'updateStatus')->name('update.order.status');
        Route::post('/update-shipping-status', 'updateShippingStatus')->name('update.shipping.status');

        Route::get('/admin-download-invoice/{id}', 'adminDownlaodInvoice')->name('admin.download.invoice');
        Route::get('/admin/order-revenue', 'orderRevenue')->name('order.revenue');
        Route::get('/export/full-product-report',  'exportFullProductReport')->name('export.product.report');
    });
    Route::resource('shop-by-reels', ShopByReelController::class);
    Route::post('shop-by-reels/status/{id}', [ShopByReelController::class, 'toggleStatus']);
    Route::controller(MileStoneController::class)->group(function () {
        Route::get('/admin/milestone-settings', 'index')->name('milestone.index');
        Route::post('/admin/milestone-settings/update', 'update')->name('milestone.update');
    });
});