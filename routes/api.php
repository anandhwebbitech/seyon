<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CommanApiController;
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\Auth\LoginRegisterController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Public routes of authtication
Route::controller(LoginRegisterController::class)->group(function() {
    Route::post('/register', 'register');
    Route::post('/login', 'login');
    Route::post('/register-send-otp', 'register_send_otp');
    Route::post('/forget-password','forget_password');
    Route::post('/verification-code','verification_code');
    Route::post('/reset-password','reset_password');
});



// Public routes of product
Route::controller(ProductController::class)->group(function() {
    Route::get('/get-catagories','getAllCatagories');    
    Route::get('/featured-product','featuredProduct');    
    Route::get('/best-seller-product','bestSellerProduct'); 
    
    Route::post('/add-to-cart','addToCart');    
    Route::get('/get-cart-products','getCart');    
    Route::post('/romove-from-cart','removeFromCart');    
    Route::get('/cart-count','getCartCount');    
    
    Route::post('/add-to-wishlist','addToWishlist');    
    Route::get('/get-wishlist-products','getWishlist'); 
    Route::post('/romove-from-wishlist','removeFromWishlist'); 
    Route::get('/wishlist-count','getWishlistCount'); 
    
    Route::post('/product-details','productdetails'); 
    
    Route::post('/appy-coupon','applyCoupon'); 
    Route::post('/remove-coupon','removeCoupon'); 
    
    
    Route::get('/get-banner','getBanner'); 
    
    Route::post('/product-text-search','searchList'); 
    
    Route::post('/product-filter','applyFilter'); 

});




Route::middleware('auth:sanctum')->group( function () {
    
    
    Route::post('/logout', [LoginRegisterController::class, 'logout']);
    
    Route::controller(LoginRegisterController::class)->group(function() {
        Route::post('/edit-profile','edit_profile');
        Route::post('/get-profile','getProfile');
    });
    
    Route::controller(CommanApiController::class)->group(function() {
        
        
    });

    Route::controller(ProductController::class)->group(function() {
        
        
        
        Route::post('/add-new-address','addNewAddress'); 
        Route::post('/update-address','updateAddress'); 
        Route::post('/delete-address','deleteAddress');
        Route::post('/get-all-address','getAllAddress'); 
        Route::post('/set-default-address','setDefaultAddress'); 
        Route::get('/get-default-address','getDefaultAddress'); 
        
        
        Route::get('/get-countries','getCountry'); 
        Route::post('/get-state','getStates'); 
        Route::post('/get-city','getCities');
        
        
        Route::post('/payment-process','paymentProcess'); 
        Route::post('/send-invoice','invoice'); 
        
        Route::post('/get-order-history-details','getOrderHistory');  
        
        Route::post('/add-review','addReview');  
        
        Route::post('/change-password','updatePassword');  
        
    });
    
    
});














