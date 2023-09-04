<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\paymentController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\OrderController;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use App\Http\Controllers\AmazonController;
use App\Http\Controllers\TravellerOfferController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::post('/fetch-amazon-data', [AmazonController::class, 'fetchAmazonData'])->name("fatch_data.amazon");
// Route::get('/fetch-amazon-data/{url}', [AmazonController::class ,'fetchAmazonData']);
// HomeController==================
Route::get('/',[HomeController::class,"home"])->name('home');
Route::get('/nav',[HomeController::class,"nav"])->name('home.nav');
        
// AuthController
Route::get('/registrion',[AuthController::class,"Registrion"])->name('registrion');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/user_login', [AuthController::class, 'User_Login'])->name('login.user'); 
Route::post('/user-registration', [AuthController::class, 'userRegistration'])->name('register.user');
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');

// OrderController
Route::get('create_order',[OrderController::class,'create_order'])->name('user.create_order');
Route::get('product_details',[OrderController::class,'product_details'])->name('user.product_details');

// TripController
Route::get('make_offer_html/{id}', [TripController::class, 'make_offer_html'])->name('make_offer_html');
Route::get('traveller',[TripController::class,'treveller_store'])->name('user.treveller');

// UserProfileController
// Auth::routes([
//     'verify'=>true
// ]);
Route::group(['middleware' => ['auth']], function() {
    Route::get('profile',[UserProfileController::class,'profile'])->name('user.profile');
    Route::post('edit_profile_data',[UserProfileController::class,'edit_profile_data'])->name('user.edit_profile_data');
    Route::get('setting',[UserProfileController::class,'setting'])->name('user.setting');
    Route::get('help_desk',[UserProfileController::class,'help_desk'])->name('user.help_desk');

    // ProductController
    Route::get('fatch/product_detail', [ProductController::class, 'fatch_product_detail'])->name('product.fatch_product_detail');

    // paymentController
    Route::get('stripe', [paymentController::class, 'stripe'])->name('stripe.index');
    Route::post('stripePost', [paymentController::class, 'stripePost'])->name('stripe.post');

    // VerificationController
    Route::get('email_verification', [VerificationController::class, 'email_verification'])->name('email_verification.index');
    Route::get('email_verified/{id}', [VerificationController::class, 'email_verified'])->name('email_verified.index');
    Route::get('mobile_verification', [VerificationController::class, 'mobile_verification'])->name('mobile_verification.index');
    Route::post('processMobileVerification', [VerificationController::class, 'processMobileVerification'])->name('processMobileVerification.index');
    Route::get('stripeIdentity', [VerificationController::class, 'stripeIdentity'])->name('stripeIdentity.index');
    Route::get('create_verification_session', [VerificationController::class, 'create_verification_session'])->name('create_verification_session.index');
    Route::get('submitted', [VerificationController::class, 'submitted'])->name('submitted.index');
    Route::post('create_concted_account', [VerificationController::class, 'create_concted_account'])->name('create_concted_account.index');
    Route::get('checkout', [VerificationController::class, 'checkout'])->name('checkout.index');
   Route::get('/stripe_connect_payout', function () {
        return view('frontend.stripe_connect_payout.index');
    })->name("stripe_connect_payout");
    // Route::post('/return_stripe', [VerificationController::class, 'confirm_verify_email'])->name('confirm_verify_email.index');
    Route::get('/return_stripe', function () {
        return view('frontend.stripe_connect_payout.return');
    });
    Route::get('/reauth_stripe', function () {
        return view('frontend.stripe_connect_payout.reauth');
    });

    // TripController
    Route::get('travel-create_offer/{id}', [TripController::class, 'create_offer'])->name('travel.create_offer');
    Route::post('travel-make_deliveryOffer', [TripController::class, 'make_deliveryOffer'])->name('travel.make_deliveryOffer');
    Route::get('trip',[TripController::class,'trip'])->name('user.trip');
    Route::post('create_trip',[TripController::class,'create_trip'])->name('user.create_trip');
    Route::get('matched_trip/{id}', [TripController::class, 'matched_trip'])->name('user.matched_trip');
    Route::get('send_tripRequest/{id}', [TripController::class, 'send_tripRequest'])->name('user.send_tripRequest');
    Route::get('check_trOffer/{id}', [TripController::class, 'check_trOffer'])->name('user.check_trOffer');
    Route::get('travel_offer_reChange/{id}', [TripController::class, 'travel_offer_reChange'])->name('user.travel_offer_reChange');

    // OrderController
    Route::get('matched_order/{id}', [OrderController::class, 'matched_order'])->name('user.matched_order');
    Route::get('create_order2/{id}',[OrderController::class,'create_order2'])->name('user.create_order2');
    Route::post('order_product', [OrderController::class, 'order_product'])->name('user.order_product');
    Route::get('orders',[OrderController::class,'orders'])->name('user.orders');
    Route::get('order_details/{id}',[OrderController::class,'order_details'])->name('user.order_details');
    Route::get('order_cancle/{id}',[OrderController::class,'order_cancle'])->name('user.order_cancle');
    Route::get('edit_order/{id}',[OrderController::class,'edit_order'])->name('user.edit_order');
    Route::post('update_order',[OrderController::class,'update_order'])->name('user.update_order');

    // TravellerOfferController
    Route::post('traveller-offcer/{id}',[TravellerOfferController::class,'create_offer'])->name('traveller.create_offer');
    
   

});
// VerificationController
Route::get('/verify/stripe/{accountId}', [VerificationController::class,'verify'])->name('verify.stripe');
Route::get('/verify/check_mail', [VerificationController::class,'check_mail'])->name('check_mail');
Route::get('/verify/email_verify', [VerificationController::class,'email_verify'])->name('email_verify.auth');
Route::get('/verify/email-auth/{email}', [VerificationController::class,'sendVerificationEmail'])->name('verify_email.auth');







// $url = 'https://www.amazon.in/TIMEWEAR-Functioning-White-Chain-Watch/dp/B07MDGSP8F/ref=sr_1_1?crid=4A346JJVKQAA&keywords=Ingersoll+London+Watches&pf_rd_i=2563504031&pf_rd_m=A1VBAL9TL5WCBF&pf_rd_p=fbf133a3-c4be-4982-a06c-d8aade55b4c6&pf_rd_r=260PZAP5S90NXPKN4ZX7&pf_rd_s=merchandised-search-9&qid=1687753314&s=watches&sprefix=ingersoll+london+watche%2Cwatches%2C200&sr=1-1';
// $data = Http::get(url('/scrape-amazon/' . urlencode($url)))->json();
