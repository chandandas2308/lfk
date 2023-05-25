<?php

use App\Http\Controllers\CustomerAPI\CartApiController;
use App\Http\Controllers\CustomerAPI\CheckInCoinsController;
use App\Http\Controllers\CustomerAPI\CheckoutApiController;
use App\Http\Controllers\CustomerAPI\CODController;
use App\Http\Controllers\CustomerAPI\CoinsController;
use App\Http\Controllers\CustomerAPI\CustomerAPIController;
use App\Http\Controllers\DeliveryAPI\DeliveryAuthController;
use App\Http\Controllers\Pos\PosAPIController;
use App\Http\Controllers\CustomerAPI\CustomerAuthController;
use App\Http\Controllers\CustomerAPI\CouponController;
use App\Http\Controllers\DeliveryAPI\DeliveryTaskController;
use App\Http\Controllers\DeliveryAPI\JobHistoryController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('test', [CustomerAuthController::class, 'test']);

// Customer Authentication Routes without login
Route::post('register', [CustomerAuthController::class, 'register']);
Route::post('login', [CustomerAuthController::class, 'login']);
Route::post('facebook', [CustomerAuthController::class, 'facebook']);

Route::post('forgot-password', [CustomerAuthController::class, 'forgot']);

// Deliveryman Login
Route::post('deliverylogin', [DeliveryAuthController::class, 'Deliverylogin']);
Route::post('forgot-password-deliveryman', [DeliveryAuthController::class, 'forgot']);

Route::middleware('auth:sanctum')->group(function () {
    // Customer Authentication Routes with login
    Route::post('reset-password', [CustomerAuthController::class, 'reset']);
    Route::post('change-password', [CustomerAuthController::class, 'changepswd']);

    // Delivery Authentication Routes with login
    Route::post('reset-password-deliveryman', [DeliveryAuthController::class, 'reset']);
    Route::post('change-password-deliveryman', [DeliveryAuthController::class, 'changepswd']);

    // check product is available in cart and wishlists
    Route::get('check/{product_id}/{user_id}', [CustomerAPIController::class, 'check']);

    // ============================================================================================
    //                                     WISH LIST
    // ============================================================================================

    // All items in wishlists
    Route::get('wishlists/{user_id}', [CustomerAPIController::class, 'WishLists']);
    // add wishlist
    Route::post('add-wishlist/{product_id}/{user_id}', [CustomerAPIController::class, 'addWishList']);
    // remove from wishlist
    Route::post('remove-wishlist/{user_id}/{product_id}', [CustomerAPIController::class, 'removeWishList']);


    // ============================================================================================
    //                                     ADDRESS
    // ============================================================================================

    // fetch all address
    Route::get('all-address/{id}', [CustomerAPIController::class, 'allAddress']);
    // fetch address details
    Route::get('address-detail/{id}/{user_id}', [CustomerAPIController::class, 'Address']);
    // add address
    Route::post('add-address', [CustomerAPIController::class, 'addAddress']);
    // update address
    Route::post('update-address', [CustomerAPIController::class, 'updateAddress']);
    // remove address
    Route::get('remove-address/{id}/{user_id}', [CustomerAPIController::class, 'removeAddress']);

    // ============================================================================================
    //                                     CART
    // ============================================================================================

    Route::get('carts/{user_id}', [CartApiController::class, 'carts']);
    Route::post('add-to-cart/{user_id}/{product_id}', [CartApiController::class, 'addtocart']);
    Route::post('update-qty/{product_id}/{user_id}', [CartApiController::class, 'updateqty']);
    Route::get('remove-product/{product_id}/{user_id}', [CartApiController::class, 'removeproduct']);

    // ============================================================================================
    //                                     PROFILE
    // ============================================================================================

    // fetch profile details
    Route::get('profile/{id}', [CustomerAuthController::class, 'profile']);

    // update profile
    Route::post('update-profile/{id}', [CustomerAuthController::class, 'updateprofile']);
    
    // ============================================================================================
    //                                     CHECKOUT
    // ============================================================================================
    Route::get('checkout/{user_id}', [CheckoutApiController::class, 'index']);
    Route::post('store-checkout/{user_id}', [CheckoutApiController::class, 'store']);
    // Store order details
    Route::post('/place-order/hitpay/create', [CheckoutApiController::class, 'create']);
    // Buy products using cart
    Route::post('/place-order/hitpay/cart-buy', [CheckoutApiController::class, 'cartBuy']);

    // 
    Route::get('get-payment-details/{reference_id}', [CheckoutApiController::class, 'getPaymentDetails']);


    // ============================================================================================
    //                                     Payment COD
    // ============================================================================================

    // Delivery Date
    Route::post('/delivery-date/checkout1', [CODController::class, 'deliveryDate']);

    // check payment & delivery charge
    Route::post('/checkout/check-payment', [CODController::class, 'checkPayment']);

    // direct single product buy
    Route::post('/place-order/store', [CODController::class, 'directBuy']);

    // cart product buy
    Route::post('/place-order/cart/store', [CODController::class, 'cartBuy']);

    // deliveries status apis
    Route::get('/orders/deliveries-status/{user_id}', [DeliveryAuthController::class, 'orderDeliveries']);


    // Previous Order Details
    Route::post('/previous_order', [CoinsController::class, 'prevOrder']);

    // ============================================================================================
    //                                     ORDERS
    // ============================================================================================

    // fetch all Orders
    Route::get('all-orders/{user_id}', [CustomerAPIController::class, 'totalorders']);
    // all order via consolidate order no.
    Route::get('orders/consolidate-order/{order_no}', [CustomerAPIController::class, 'fetchAllOrders']);

    // fetch single Order
    Route::get('order/{user_id}/{id}', [CustomerAPIController::class, 'singleorder']);
    // Order details
    // Route::get('orders/{user_id}', [CustomerAPIController::class, 'userOrders']);
    // single order detail

    // fetch cart Order
    Route::get('cartOrder/{use_id}', [CartApiController::class, 'cartOrder']);

    // ============================================================================================
    //                                     ACCOUNT DEACTIVATION
    // ============================================================================================
    Route::post('deactivate-account/{user_id}', [CustomerAuthController::class, 'deactivateaccount']);

    // ==========================================================================================
    // ==============================     Delivery Man API     ==================================
    // ==========================================================================================
    Route::post('update-single-delivery-status/{user_id}/{order_no}', [JobHistoryController::class, 'UpdateSingleDeliveryStatus']);
    Route::post('update-delivery-status/{user_id}', [JobHistoryController::class, 'UpdateDeliveryStatus']);


    // ============================================================================================
    //                                   DELIVERY  PROFILE
    // ============================================================================================
    // fetch Delivery profile details
    Route::get('deliveryprofile/{id}', [DeliveryAuthController::class, 'deliveryprofile']);

    // update  Delivery profile
    

    // fetch all tasks for delivery

    Route::get('all-delivery-tasks/{user_id}', [DeliveryTaskController::class, 'index']);

    // fetch single pending task for delivery

    Route::get('task-detail/{user_id}/{id}', [DeliveryTaskController::class, 'singleDeliveryTasks']);

    // one day route

    Route::post('one-delivery_date/{driver_id}', [DeliveryTaskController::class, 'singleDeliveryRoute']);


    // fetch all pending tasks for delivery

    Route::get('all-pending-delivery-tasks/{user_id}', [DeliveryTaskController::class, 'AllPendingTasks']);

    // fetch single pending task for delivery

    Route::get('pending-task-detail/{user_id}/{id}', [DeliveryTaskController::class, 'singlePendingDeliveryTasks']);


    // fetch all completed tasks for delivery

    Route::get('all-completed-delivery-tasks/{user_id}', [DeliveryTaskController::class, 'allCompletedTasks']);

    // fetch single completed task for delivery

    Route::get('completed-task-detail/{user_id}/{id}', [DeliveryTaskController::class, 'singleCompletedTasks']);

    // fetch today's tasks for delivery

    Route::get('today-delivery-tasks/{user_id}', [DeliveryTaskController::class, 'todayTasks']);

    // job history

    // Route::get('job-history/{user_id}', [JobHistoryController::class, 'jobHistory']);

    // Proudct List 

    Route::get('inventory-list/{user_id}', [JobHistoryController::class, 'inventorylist']);


    Route::get('get_consolidate_order_no/{driver_id}', [JobHistoryController::class, 'get_consolidate_order_no']);
    Route::get('get_consolidate_order_details/{driver_id}/{consolidate_order_no}', [JobHistoryController::class, 'get_consolidate_order_details']);
    Route::get('packed_consolidate_order/{driver_id}/{consolidate_order_no}', [JobHistoryController::class, 'packed_consolidate_order']);
    Route::get('start_delivery/{driver_id}', [JobHistoryController::class, 'start_delivery']);
    Route::post('complete_delivery', [JobHistoryController::class, 'complete_delivery']);



    // Update delivery status 

    // Update customer signature for delivery

    Route::post('update-customer-signature/{order_no}/{driver_id}', [DeliveryTaskController::class, 'customerSignature']);
    
    //Image and remarks Add

    Route::post('add-image-remarks', [DeliveryTaskController::class, 'addRemark']);

    // Total Jobs completed
    Route::get('total-jobs-completed/{user_id}', [JobHistoryController::class, 'TotalJobsCompleted']);

    //  Total Earning
    Route::get('total-earning/{user_id}', [JobHistoryController::class, 'TotalEarning']);

    // Total Working Days
    Route::get('total-working-days/{user_id}', [JobHistoryController::class, 'TotalWorkingDays']);

    // Earnning month wise
    Route::get('/monthly-earning/{user_id}', [JobHistoryController::class, 'monthly_earning']);

    // Inventory List by Order Number
    Route::get('inventory-list-by-order/{user_id}/{order_no}', [JobHistoryController::class, 'InventoryListByOrder']);

    // Update SIngle Delivery Status by Order Number
    

    // Check Coupon Code
    Route::post('/coupon/check-coupon-code', [CouponController::class, 'check_coupon_code']);

    // Check Coupon Code on Single Product Buy
    Route::post('/coupon/check-coupon-code-on-single', [CouponController::class, 'check_coupon_code_single']);

    // Store Delivery Date API After Payment
    Route::post('/order-succeded/delivery-date', [CODController::class, 'updateDeliveryDate']);

    // ============================================================================================
    //                                     CHECK IN COINS API
    // ============================================================================================
    Route::resource('check_in_coins', CheckInCoinsController::class,[
        'store' => 'check_in_coins.store'
    ]);
    
    // 
    Route::get('/day-coins/{user_id}', [CoinsController::class, 'dayCoins']);
    
    // ============================================================================================
    //                                     REDEMPTION API
    // ============================================================================================
    // 
    Route::get('/redemption-shop/product', [CoinsController::class, 'redemptionShopProduct']);

    // 
    Route::get('/redemption-shop/voucher', [CoinsController::class, 'redemptionShopVoucher']);

    // generate code on voucher
    Route::post('/redemption-shop/generate-code', [CoinsController::class, 'redemptionShopGenerateCode']);

    // Checkout Redemption Shop Product
    Route::post('/redemption-shop/checkout', [CoinsController::class, 'redemptionShopCheckout']);

});


Route::middleware('auth:sanctum')->group(function () {

    Route::get('inventory_list/{driver_id}/{date}',[DeliveryTaskController::class,'inventory_list']);
    Route::get('consolidate_order_list/{driver_id}/{date}',[DeliveryTaskController::class,'consolidate_order_list']);
    Route::get('get_consolidate_order_item_details/{consolidate_order_no}',[DeliveryTaskController::class,'get_consolidate_order_item_details']);
    Route::post('change_consolidate_order_item_status_to_packed',[DeliveryTaskController::class,'change_consolidate_order_item_status_to_packed']);
    Route::get('all_consolidate_order_list/{driver_id}/{date}/{option}',[DeliveryTaskController::class,'all_consolidate_order_list']);
    Route::post('change_all_consolidate_order_to_yet_to_deliver',[DeliveryTaskController::class,'change_all_consolidate_order_to_yet_to_deliver']);
    Route::get('get_consolidate_order_details/{consolidate_order_no}',[DeliveryTaskController::class,'get_consolidate_order_details']);

    Route::post('save_signature',[DeliveryTaskController::class,'save_signature']);
    Route::get('check_signature/{consolidate_order_no}',[DeliveryTaskController::class,'check_signature']);
    Route::post('complete_order_delivery',[DeliveryTaskController::class,'complete_order_delivery']);
    Route::get('check_order_complete/{consolidate_order_no}',[DeliveryTaskController::class,'check_order_complete']);

    Route::post('cancel_order',[DeliveryTaskController::class,'cancel_order']);
    Route::get('show_routes/{driver_id}/{date}',[DeliveryTaskController::class,'show_routes']);

    Route::get('get_earning_details/{driver_id}/{date}', [DeliveryTaskController::class, 'get_earning_details']);
    Route::post('download_excel_file', [DeliveryTaskController::class, 'download_excel_file']);


    Route::get('job-history/{user_id}', [JobHistoryController::class, 'jobHistory']);
    Route::post('deliveryupdate-profile/{id}', [DeliveryAuthController::class, 'deliveryupdateprofile']);

   

    

});




// get current user voucher list
Route::post('/redemption/v_list', [CoinsController::class, 'redemptionShopVoucherList']);

// ============================================================================================
//                                      PRODUCT
// ============================================================================================


// list all products
Route::get('products', [CustomerAPIController::class, 'index']);

// get recommended products
Route::get('/recommended/products/{id}', [CustomerAPIController::class, 'recommendedProducts']);

// fetch single product via id
Route::get('product/{id}', [CustomerAPIController::class, 'singleProduct']);

// fetch single product via id
Route::get('single-product/{id}', [CustomerAPIController::class, 'singleProductViaId']);

// category wise product
Route::get('products-list/category/{id}', [CustomerAPIController::class, 'categoryWiseProduct']);
// Remaining product
Route::get('left/products-list/{id}', [CustomerAPIController::class, 'leftProduct']);


// ============================================================================================
//                                      CATEGORY
// ============================================================================================

// list all categories
Route::get('category-list', [CustomerAPIController::class, 'categories']);

// fetch single category via id
Route::get('category/{id}', [CustomerAPIController::class, 'singleCategory']);

// ============================================================================================
//                                      Best, New and Trending Product
// ============================================================================================

Route::get('trending-product', [CustomerAPIController::class, 'trendingproduct']);
Route::get('best-product', [CustomerAPIController::class, 'bestproduct']);
Route::get('new-product', [CustomerAPIController::class, 'newproduct']);


// ============================================================================================
//                                     BANNER
// ============================================================================================

// list banners
Route::get('banners-list', [CustomerAPIController::class, 'banners']);

// fetch single banner via id
Route::get('banner/{id}', [CustomerAPIController::class, 'singleBanner']);

// ============================================================================================
//                                     REFFERAL AWARD
// ============================================================================================

// refferal awards points
Route::get('refferal-points', [CustomerAPIController::class, 'refferalPoints']);


// ============================================================================================
//                                     LOYALTY POINTS
// ============================================================================================

// loyalty points
Route::get('loyalty-points', [CustomerAPIController::class, 'loyaltyPoints']);

// Earn Loyality points 
Route::get('loyality/{user_id}', [CustomerAPIController::class, 'loyalityId']);

// Loyalty points history
Route::get('loyalty/history/{user_id}', [CustomerAPIController::class, 'loyaltyPointsHistory']);


// ============================================================================================
//                                     COUPON
// ============================================================================================
// Coupon
Route::get('coupon', [CustomerAPIController::class, 'couponList']);


// ============================================================================================
//                                     OFFER
// ============================================================================================
// OFFER
Route::get('offerpackage', [CustomerAPIController::class, 'offerdetails']);


// ============================================================================================
//                                     CHECK IN COINS API
// ============================================================================================
Route::get('check_in_coins', [CoinsController::class, 'dailyCheckInCoins']);


// PosAPi

Route::get('me', [PosAPIController::class, 'index']);

// my lst
Route::get('/my_list', [CustomerAPIController::class, 'myList']);

// my voucher
Route::post('vouchers', [CoinsController::class, 'myVoucher']);