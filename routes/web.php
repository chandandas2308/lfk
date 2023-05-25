<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\DeliveryController;
use App\Http\Controllers\ECreditController;
use App\Http\Controllers\LoyaltyPointController;
use App\Http\Controllers\OfferPackages;
use App\Http\Controllers\OfferPackagesController;
use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\SuperAdmin\SuperAdminController;
use App\Http\Controllers\SuperAdmin\UserController;
use App\Http\Controllers\SuperAdmin\InventoryController;
use App\Http\Controllers\SuperAdmin\PurchaseController;
use App\Http\Controllers\SuperAdmin\SalesController;
use App\Http\Controllers\User\FrontendController;
use App\Http\Controllers\SuperAdmin\FixedAssetContoller;
use App\Http\Controllers\SuperAdmin\ReportController;
use App\Http\Controllers\Route\RoutePlaningController;
use App\Http\Controllers\Backend\CustomerOrderController;
use App\Http\Middleware\CheckInventory;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Middleware\CheckCustomerLogin;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Refferal;
use App\Http\Controllers\SMS\OneWaySMSController;
use Illuminate\Http\Response;
use App\Http\Controllers\SuperAdmin\BulkProductUpload;
use App\Http\Controllers\SuperAdmin\BulkStock;
use App\Http\Controllers\SuperAdmin\ConfigurationController;
use App\Http\Controllers\SuperAdmin\ConsolidateOrderController;
// use App\Http\Controllers\Pos\PosController;
use App\Http\Controllers\SuperAdmin\PosManagementController;

# Import Controller Class
use App\Http\Controllers\SuperAdmin\PDFController;
use App\Http\Controllers\SuperAdmin\RetailCustomerController;
use App\Http\Controllers\User\CartController;
use App\Http\Controllers\User\CheckoutController;
use App\Http\Controllers\User\CheckoutSessionController;
use App\Http\Controllers\User\ThanksController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Models\PurchaseOrder;
use App\Http\Controllers\SuperAdmin\ContactController;
use App\Http\Controllers\SuperAdmin\NewsLetterController;
use App\Http\Controllers\SuperAdmin\BlogController;
use App\Http\Controllers\SuperAdmin\LiveDateConfigController;
use App\Http\Controllers\User\PaymentController;
use App\Http\Controllers\User\WishlistController;
use App\Http\Controllers\User\OrderController;
use App\Http\Controllers\User\NotificationController;
use App\Http\Controllers\User\UserLoginController;
use App\Http\Controllers\Pos\PosCustomer;
use App\Http\Controllers\Pos\StockController;
use App\Models\UserOrderPayment;
use Illuminate\Http\Request;
use App\Http\Controllers\Redemption_Shop\RedemptionShopController;
use App\Http\Controllers\Redemption_Shop\ProductShopController;
use App\Http\Controllers\SocialController;
use App\Http\Controllers\SuperAdmin\SignInSettingController;
use App\Http\Controllers\SuperAdmin\CheckInSettingController;
use Illuminate\Support\Facades\App;

//  ===============================================================================================
//              Frontend Website Routes START
//  ===============================================================================================

Route::get('/d',function(){
    // return view('demo');
    return view('superadmin.Delivery.show_route');
});



Route::get('payment_success', function (Request $request) {
    return $request->all();
})->name('payment_success');

Route::post('webhook', function (Request $request) {
    UserOrderPayment::create([
        'payment_id'            => $request->payment_id,
        'payment_request_id'    => $request->payment_request_id,
        'phone'                 => $request->phone,
        'amount'                => $request->amount,
        'currency'              => $request->currency,
        'status'                => $request->status,
        'reference_number'      => $request->reference_number,
        'hmac'                  => $request->hmac,
        'all_data'              => $request->all()
    ]);
})->name('webhook');

// HOME
Route::get('/', [FrontendController::class, 'index'])->name('Home');

// phone email login
// Route::get('/EmailPhoneLogin', [FrontendController::class, 'pelogin'])->name('phone-email-login');

// REGISTER PAGE
Route::get('/register-with-us', [FrontendController::class, 'register'])->name('register-with-us');
// REGISTER  POST
// Route::post('/register-us', [FrontendController::class, 'registerUs'])->name('Register-With-Us-Post');
// LOGIN
Route::get('/login-with-us/lfk', [FrontendController::class, 'login'])->name('login-with-us1');
// POST LOGIN   
Route::post('/login-with-us', [UserLoginController::class, 'login'])->name('login-with-us');
// Logout normal user
Route::post('/logout-with-normal-user', [UserLoginController::class, 'logout'])->name('logout-with-normal-user');

// FORGOT-PASSWORD
Route::get('/forgot-password', [FrontendController::class, 'forgot_password'])->name('forgot-password');
// LOGIN ROUTE
// Route::post('/register-us',[FrontendController::class,'register'])->name('Register-With-Us');
// All - Product
Route::get('/LFK/products', [FrontendController::class, 'allProducts'])->name('AllProducts');
// fetch all paginate data to show in cards
Route::get('/products/paginate-data', [FrontendController::class, 'allBuyNowPageProducts'])->name('AllBuyNowPageProducts');
// search
Route::post('/search/product', [FrontendController::class, 'searchProducts'])->name('product.search');
// Search Page
Route::get('/search/product/{search}', [FrontendController::class, 'searchProductsPage'])->name('product.searchProductsPage');

// ==============================================================================================================================

//
Route::get('/configuration/fetch-update-dat-time', [LiveDateConfigController::class, 'fetch'])->name('SA-FetchUpdatedLiveDateTimeConfiguration');
//

// languages
Route::get('lang/change', [FrontendController::class, 'change'])->name('changeLang');
Route::get('check_all_product_details',[FrontendController::class,'check_all_product_details'])->name('check_all_product_details');

// Route::middleware(['auth', 'checkCustomerLogin'])->group(function () {
Route::group(['prefix' => '',  'middleware' => 'checkCustomerLogin'], function () {

    Route::get('user/generate-online-sale-invoice-pdf/{id}', [SalesController::class, 'generateOnlineSaleInvoicePDF'])->name('SA-GenerateOnlineSaleInvoicePDFUser');

    
    Route::get('/all_order_list', [OrderController::class, 'all_order_list'])->name('all_order_list');
    
    // ==============================================================================================================================
    //                                         REWARDS COINS
    // ==============================================================================================================================
    // Rewards coins
    Route::get('/rewards/check-in-coins', [FrontendController::class, 'checkInRewards'])->name('checkIn.rewards');
    // get coins
    Route::get('/rewards/check-in', [FrontendController::class, 'checkInNow'])->name('checkIn.now');

    // Add to Wish list
    Route::post('/wishlist/add-to-wishlist', [WishlistController::class, 'store'])->name('SA-StoreWishlist');
    // add to wishlist page load
    Route::get('/wishlist/store-wishlist/{id}', [WishlistController::class, 'storeWishlist'])->name('SA-storeWishlist');
    // remove to wishlist page load
    Route::get('/wishlist/remove-wishlist/{id}', [WishlistController::class, 'removeWishlist'])->name('SA-removeWishlist');

    // Remove from wishlist
    Route::get('/wishlist/remove-from-wishlist', [WishlistController::class, 'remove'])->name('SA-RemoveWishlist');

    // fetch all wishlists details
    Route::get('/wishlist/fetch-wishlist', [WishlistController::class, 'fetchAllWishlits'])->name('user.wishlists');

    // fetch all order details
    Route::get('/order/fetch-order', [OrderController::class, 'fetchAllListOrder'])->name('user.listorder');

    // My voucher table
    Route::get('/user/my_vouchers/details', [OrderController::class, 'myVouchersDetails'])->name('user.my_vouchers.details');

    // fetch order details via consolidate order number
    Route::get('/order/fetch-order-details', [OrderController::class, 'consolidateOrdersDetails'])->name('user.consolidateOrdersDetails');

    // fetch all  deliverd order details
    Route::get('/complet/fetch-order', [OrderController::class, 'fetchAllcompletOrder'])->name('user.completorder');

    // loyalty points
    Route::get('/order/fetch-loyalty-points', [OrderController::class, 'loyaltyPoints'])->name('user.loyaltyPoints');

    // fetch all Notification details
    Route::get('/notification/details', [NotificationController::class, 'fetchAllNotification'])->name('user.Notification');

    // fetch user notification
    Route::get('/user-notification', [NotificationController::class, 'userAlert'])->name('notificationList');

    // Add to cart path
    Route::post('/add-to-cart', [CartController::class, 'Addtocart'])->name('SA-Addtocart');


    // update cart quantity
    Route::get('/update-quantity-to-cart', [CartController::class, 'updateQuantityToCart'])->name('SA-UpdateQuantityToCart');

    //
    Route::get('/create-cart', [CartController::class, 'create'])->name('SA-CreateCart');
    Route::get('/order_summary', [CartController::class, 'order_summary'])->name('order_summary');
    // cart page
    Route::get('/cart', [CartController::class, 'index'])->name('SA-IndexCart');
    //
    Route::delete('/destroy-cart/{id}', [CartController::class, 'destroy'])->name('SA-DestroyCart');
    // 

    // 
    Route::post('/check_coupon_code', [CheckoutController::class, 'check_coupon_code'])->name('check_coupon_code');
    Route::post('select_payment_option',[CheckoutController::class,'select_payment_option'])->name('select_payment_option');
    Route::resource('checkout', CheckoutController::class)->names([
        'index' => 'checkout',
        'store' => 'checkout.store',
    ]);

    Route::get('make_payment_with_hit_pay', [PaymentController::class, 'make_payment_with_hit_pay'])->name('payment.make_payment_with_hit_pay');
    Route::get('thanks', [PaymentController::class, 'thanks'])->name('payment.thanks');
    Route::get('thanks/order-delivery-date', [PaymentController::class, 'selectOrderDelivery'])->name('payment.selectOrderDelivery');
    Route::resource('order_payment', PaymentController::class)->names([
        'create' => 'create.order_payment',
        'store' => 'store.order_payment',
        'index' => 'index.order_payment',
    ]);

    Route::post('/session/update-address', [CheckoutSessionController::class, 'updateAddress'])->name('session-updateAddress');
    Route::post('/session/update-mode', [CheckoutSessionController::class, 'updatePaymentMode'])->name('session-updatePaymentMode');
    Route::post('/session/update-coupon', [CheckoutSessionController::class, 'removeCoupon'])->name('session-removeCoupon');

    Route::get('/delivery-date/lfk-panel', [PaymentController::class, 'updateSection'])->name('order.select-delivery-date');

    // ==================================================================================================================
    //                          STEP 1 (ORDER SUMMARY)
    // ==================================================================================================================
    Route::get('/order-summary', [CheckoutController::class, 'orderSummary'])->name('checkout.orderSummary');
    // 
    Route::get('/address-summary', [CheckoutController::class, 'addressSummary'])->name('checkout.addressSummary');
    // add delivery date and remark
    // Route::get('/delivery-date/checkout', [CheckoutController::class, 'deliveryDate'])->name('checkout.deliveryDate');
    Route::post('/delivery-date/checkout', [CheckoutController::class, 'deliveryDate'])->name('checkout.deliveryDate');
    // store delivery date and remark
    Route::post('/delivery-date/store/checkout', [CheckoutController::class, 'storeDeliveryDate'])->name('checkout.storeDeliveryDate');
    // Redemption Product Buy
    Route::get('/order-summary/{id}', [CheckoutController::class, 'redemptionOrderSummary'])->name('checkout.redemptionOrderSummary');
    // address summary
    Route::get('/address-summary/{product_id}', [CheckoutController::class, 'redemptionAddressSummary'])->name('checkout.redemptionAddressSummary');
    // 
    Route::post('/product/checkout/delivery_date/{product_id}', [CheckoutController::class, 'redemptionDeliveryDateSummary'])->name('checkout.redemptionDeliveryDateSummary');
    // 
    Route::post('/product/checkout/{product_id}', [CheckoutController::class, 'redemptionCheckoutSummary'])->name('checkout.redemptionCheckoutSummary');
    // store & checkout redemption shop
    Route::post('/redemption-shop/checkout', [CheckoutController::class, 'checkout'])->name('checkout.redemptionShop');

    // generate voucher and store it for user
    Route::get('/redemption-shop/voucher/{id}', [CheckoutController::class, 'voucherGenerator'])->name('checkout.voucherGenerator');

    // update consolidate order address page
    Route::get('/my-order/update/{id}', [CheckoutController::class, 'updateAddressPage'])->name('checkout.updateAddressPage');
    // update address in order
    Route::post('/my-order/update', [CheckoutController::class, 'updateAddress'])->name('checkout.updateAddress');

});

// Contact Page
Route::post('/contact/store', [ContactController::class, 'store'])->name('SA-storeContact');
// Newsletter
Route::post('/newsletter/store', [NewsLetterController::class, 'store'])->name('SA-storeNewsLetter');

Route::group(['prefix' => '',  'middleware' => 'checkCustomerLogin'], function () {


    // Route::middleware(['auth', 'checkCustomerLogin'])->group(function () {
    // Profile Section
    Route::get('/user/profile', [UserUserController::class, 'profile'])->name('user.profile');
    // 
    // edit Profile
    Route::post('/edit-profile', [UserUserController::class, 'editProfile'])->name('Edit-Profile');
    // 
    Route::get('/user/wishlist', [UserUserController::class, 'addWishlist'])->name('user.wishlist');
    // 
    Route::get('/user/loyality-point', [UserUserController::class, 'showloyality'])->name('user.loyality-points');
    // 
    Route::get('/user/my-voucher', [UserUserController::class, 'myVoucher'])->name('user.my_voucher');
    // 
    Route::get('/user/address', [UserUserController::class, 'addressAdd'])->name('user.Address');
    // 
    Route::get('/user/historyorder', [UserUserController::class, 'orderhistory'])->name('user.order-history');
    // my orders
    Route::get('/user/my-orders', [UserUserController::class, 'myOrders'])->name('user.my-orders');
    // Add Address
    Route::post('/add-address', [UserUserController::class, 'addAddress'])->name('Add-Address');
    // Add Delivery Date
    Route::post('/add-delivery', [UserUserController::class, 'addDelivery'])->name('Add-Delivery');
    
    // thanksFun
    Route::get('/thanks-for-order/{id}', [UserUserController::class, 'thanksFun'])->name('order.thanks.details');

    // 
    // fetch all addresses
    Route::get('/addresses/fetch-all-addresses', [UserUserController::class, 'fetchAllAddresses'])->name('user.addresses');
    // fetch single address
    Route::get('/fetch-single-address', [UserUserController::class, 'fetchSingleAddress'])->name('Fetch-Single-Address');
    // update Address
    Route::post('/update-address', [UserUserController::class, 'updateAddress'])->name('Update-Address');
    // remove address
    Route::get('/remove-address/{id}', [UserUserController::class, 'removeAddress'])->name('Remove-Address');
    Route::get('/default-address/{id}', [UserUserController::class, 'defaultAddress'])->name('Default-Address');
    // fetch all address for cards
    Route::get('/address-cards/checkout', [UserUserController::class, 'addressesCards'])->name('user.addressesCards');
    Route::get('/address/postal', [UserUserController::class, 'APIaddres'])->name('user.postaladdresses');
});
Route::get('/regAddress/postal', [UserUserController::class, 'APIRegAddress'])->name('user.postalRegAddresses');

//
Route::get('/contact-us', [FrontendController::class, 'contact'])->name('contact-us');
// 
Route::get('/wishlist-section', [FrontendController::class, 'addWishlist'])->name('wishlist');
// 
Route::get('/loyality-point', [FrontendController::class, 'loyality'])->name('loyality-points');
// 
Route::get('/address', [FrontendController::class, 'addAddress'])->name('Address');
// 
Route::get('/historyorder', [FrontendController::class, 'orderhistory'])->name('order-history');
//
Route::get('/about-us', [FrontendController::class, 'about'])->name('about-us');

// privacy-policy
Route::get('/privacy-policy', [FrontendController::class, 'privacyPolicy'])->name('privacy-policy');

// privacy-policy
Route::get('/terms-conditions', [FrontendController::class, 'termsConditions'])->name('terms-conditions');

// return-refund
Route::get('/return-refund', [FrontendController::class, 'returnRefund'])->name('return-refund');

//faq
Route::get('/faq', [FrontendController::class, 'faq'])->name('faq');
// data protection polilcy
Route::get('/data-protection-policy', [FrontendController::class, 'dataProtectionPolicy'])->name('data-protection-policy');


Route::get('/blog/{slug?}', [FrontendController::class, 'single_blog'])->name('single_blog');
Route::get('/blog-video/{slug?}', [FrontendController::class, 'single_blogVideo'])->name('single_blogVideo');

Route::get('/blogs-list', [FrontendController::class, 'blog'])->name('blog');


// all products
Route::get('/product/{id}', [FrontendController::class, 'singleProductViaId'])->name('SingleProductViaId');
// category wise products
Route::get('/category-wise-products', [FrontendController::class, 'categoryWiseProduct'])->name('CategoryWiseProduct');
// get data using range filter
Route::get('/products-by-range', [FrontendController::class, 'productsViaPriceRange'])->name('ProductsViaPriceRange');

//  ===============================================================================================
//              Frontend Website Routes END
//  ===============================================================================================

// ##############################################################################################################################
// ##############################################################################################################################

//  ===============================================================================================
//              POS Routes START
//  ===============================================================================================
Route::get('/pos/login', [PosController::class, 'index2'])->name('C-login');
Route::post('/pos/pos-login', [PosController::class, 'onlyPosLogin'])->name('login.pos-login');
Route::post('/pos/pos-logout', [PosController::class, 'onlyPosLogout'])->name('login.pos-logout');

// Route::prefix('pos')->middleware(['auth', 'pos'])->group(function () {
Route::group(['prefix' => 'pos',  'middleware' => 'pos'], function () {

    // POS Home Route

    // Route::get('/custom-login', [PosController::class, 'customLogin'])->name('login.custom');
    Route::get('/pos-successlogin', 'MainController@successlogin');


    Route::get('/pos-dashboard', [PosController::class, 'index'])->name('Pos-Dashbaord');
    Route::get('//customer', [PosController::class, 'customer'])->name('Pos-Customer');
    Route::Post('//store-customer', [PosController::class, 'storecust'])->name('Pos-CustomerStore');
    // Route::post('/pos/store-outlet', [PosManagementController::class, 'store'])->name('SA-PosStoreOutlet');
    Route::post('//addcustomer', [PosController::class, 'addcustomer'])->name('Pos-PostCustomer');

    Route::get('//show-customer/{id}', [PosController::class, 'viewcustomer'])->name('Pos-ShowCustomerId');

    // Route::get('//updatecustomer/{id}', [PosController::class, 'update'])->name('Pos-UpdateCustomer');

    // Route::post('//editcustomer/{id}', [PosController::class,'editcustomer'])->name('Pos-EditCustomer');
    // Route::get('//editstock/{id}', [PosController::class,'editstock'])->name('Pos-EditStock');

    Route::post('//stock-update/{id}', [PosController::class, 'stockupdate'])->name('Pos-UpdateStock');
    Route::get('//delete/{id}', [PosController::class, 'destroy'])->name('Pos-DeleteCustomer');
    Route::get('//delete-stock/{id}', [PosController::class, 'destock'])->name('Pos-DeleteStock');
    // Route::get('//sales', [PosController::class, 'create'])->name('Pos-Sales');
    Route::post('//sales', [PosController::class, 'store'])->name('Pos-StoreSales');
    Route::get('//sales-delete/{id}', [PosController::class, 'deleteCustomer'])->name('Pos-CustomerDelete');
    Route::get('/sales/customer-details', [PosController::class, 'getCustomerInfo'])->name('Pos-GetCustomerDetails');
    Route::get('/sales/customer-payment', [PosController::class, 'getCustomerpayment'])->name('Pos-GetCustomerPayment');
    Route::get('/sales/customer-varients', [PosController::class, 'getProduct'])->name('Pos-GetCustomerVarients');

    // Route::post('//sales-payment', [PosController::class, 'salespayment'])->name('Pos-Sales-payment');
    Route::get('//product', [PosController::class, 'product'])->name('Pos-Product');

    // ==========================================================================================================================================
    //                                  PRODUCTS PAGE ROUTES
    // ==========================================================================================================================================
    // Sales order dashboard
    Route::get('sales/orders-dashboard', [PosController::class, 'viewOrdersDashboard'])->name('pos.viewOrdersDashboard');
    // end here
    // Sales order dashboard data
    Route::get('sales-dashboard/orders-details', [PosController::class, 'viewOrdersDetails'])->name('pos.viewOrdersDetails');
    // end here
    // Sales orders list to dashboard data
    Route::get('/sales-dashboard/all-orders-details', [PosController::class, 'viewAllSalesOrdersDetails'])->name('pos.viewAllSalesOrdersDetails');
    // end here
    // Sales single orders list to modal data
    Route::get('/single-sales/all-orders-details', [PosController::class, 'viewSingleSalesOrdersDetails'])->name('pos.viewSingleSalesOrdersDetails');
    // end here
    // Sales session dashboard
    Route::get('//sales', [PosController::class, 'create'])->name('Pos-Sales');
    // end here
    // select customer for order
    Route::get('//showcustomer', [PosController::class, 'showcustomer'])->name('Pos-ShowCustomer');
    // end here
    // select customer for order
    Route::get('//customers/{order_number}', [PosController::class, 'selectCustomer'])->name('pos.selectCustomer');
    // end here
    // Continue Sales session dashboard
    Route::get('//sales-session/{order_number}', [PosController::class, 'continueSalesSession'])->name('Pos-ContinueSalesSession');
    // end here
    // for fetch pos products via search from stock
    Route::get('//product/search-pos', [PosController::class, 'searchproduct'])->name('Pos-ProductSearch');
    // end here 
    // for fetch pos products from stock
    Route::get('/product/get-product', [PosController::class, 'getProduct'])->name('Pos-GetProduct');
    // end here 
    // for fetch pos products via category from stock
    Route::get('/product/get-perticular-product', [PosController::class, 'getPerProduct'])->name('Pos-GetProductCategory');
    // end here
    // add pos order to cart
    Route::get('add-to-pos-order', [PosController::class, 'addToPosOrder'])->name('pos.add-to-pos-order');
    // end here
    // fetch all pos order details
    Route::get('fetch-order-details', [PosController::class, 'fetchOrderDetails'])->name('pos.fetch-order-details');
    // end here
    // update quantity
    Route::get('update-quantity/qty', [PosController::class, 'updateQuantity'])->name('pos.update-quantity');
    // end here
    // update price
    Route::get('update-price/price', [PosController::class, 'updateProductPrice'])->name('pos.update-product-price');
    // end here
    // add discount
    Route::get('add-discount-price/discount', [PosController::class, 'updateProductDiscount'])->name('pos.add-product-price-discount');
    // end here
    // order payment section
    Route::get('//payments/sales/{order_number}', [PosController::class, 'paymentSection'])->name('pos.sales-payment');
    // end here
    // remove order via order number
    Route::get('//sales-order/remove-order', [PosController::class, 'removeSingleOrder'])->name('pos.remove-single-sales-order');
    // end here
    Route::get('//pay-payment/sales-order/', [PosController::class, 'getFinalPayments'])->name('pos.payment-sales-payment');
    // get payment and print slip
    Route::get('//payment/sales-order/{order_number}', [PosController::class, 'viewPaymentPage'])->name('pos.view-payment-sales-page');
    // end here
    // show pos sales
    Route::get('//pos-sales/', [PosController::class, 'show'])->name('Pos-SalesShow');
    // end here
    // show single pos sales order details
    Route::get('//pos-sales/single-order-details/', [PosController::class, 'orderDetails'])->name('Pos.singleOrderDetails');
    // end here

    // Pos Customer
    // show all customer
    Route::get('//pos/customer-list/', [PosCustomer::class, 'allCustomers'])->name('pos.allCustomersList');
    // end here
    // update customer
    Route::get('//editcustomer/{id}', [PosCustomer::class, 'editcustomer'])->name('Pos-EditCustomer');
    Route::get('//viewcustomer/{id}', [PosCustomer::class, 'viewcustomer'])->name('Pos-ViewCustomer');
    // 
    Route::post('//update-customer', [PosCustomer::class, 'update'])->name('pos.UpdateCustomer');
    // 
    // customer removed
    Route::get('//delete-customer/{id}', [PosCustomer::class, 'delete'])->name('pos.DeleteCustomer');
    //
    // end here

    // Pos Stock
    // start pos stock
        Route::get('//pos/pos-stock-list/', [StockController::class, 'viewPosStockDetails'])->name('pos.viewPosStockDetails');
    // end here

    // ==========================================================================================================================================
    //                                      END HERE
    // ==========================================================================================================================================

    Route::get('/pos/sales/all-products-detials-filtered', [PosController::class, 'getPerProduct'])->name('SA-FetchProductsDetialsInfo1');
    Route::get('/product/get-varient-list', [PosController::class, 'getVarient'])->name('Pos-GetVarient');
    Route::get('/product/get-all-data', [PosController::class, 'getAllData'])->name('Pos-GetAllData');
    Route::get('/product/calculate', [PosController::class, 'getCal'])->name('Pos-GetCal');
    Route::get('/pos/sales/all-batch-code', [PosController::class, 'salesAllBatchCode'])->name('SA-SalesAllBatchCode1');
    // Route::get('/sales/viewstock', [PosController::class, 'viewstock'])->name('SA-SalesViewStock');
    // stocks
    Route::get('//stock', [PosController::class, 'stock'])->name('Pos-Stock');
    Route::get('//add-stock', [PosController::class, 'addstock'])->name('Pos-AddStock');
    Route::get('//add-stock2', [PosController::class, 'addstock2'])->name('Pos-AddStock2');

    Route::get('//show-stock', [PosController::class, 'showstock'])->name('Pos-ShowStock');
    
    // Route::post('//add-stock2/post', [PosController::class, 'addstock2'])->name('Pos-AddStock2Post');

    Route::get('//view-stock', [PosController::class, 'viewstock'])->name('Pos-ViewStock');
    // Route::post('//view-stock', [PosController::class, 'viewstock'])->name('Pos-ViewStock');
    Route::get('//show-stock2/{id}', [PosController::class, 'showstock2'])->name('Pos-StockShow');
    // Route::get('//notification', [PosController::class, 'notification']);  

    Route::get('//sales-order/{id}', [PosController::class, 'SalesOrder'])->name('Pos-Sales-Order');

    Route::get('//sales-order-delete/{id}', [PosController::class, 'destroy2'])->name('Pos-DeleteSales-Order');
    Route::get('//show-sales-order/{id}', [PosController::class, 'viewsales'])->name('Pos-ShowSales');
    Route::get('//enterdata', [PosController::class, 'EnterData'])->name('Pos-EnterData');

    Route::get('//profile', [PosController::class, 'profile'])->name('POS-Profile');
    Route::get('/logout', [PosController::class, 'logout'])->name('SA-Logout');
});


//  ===============================================================================================
//              POS Routes END
//  ===============================================================================================

// ##############################################################################################################################
// ##############################################################################################################################

// Send SMS
Route::get('/sms/send-sms', [OneWaySMSController::class, 'sendSMS'])->name('SA-SendSMS');
// 

//  ===============================================================================================
//              Admin Routes START
//  ===============================================================================================

Route::prefix('admin')->middleware(['auth', 'admin'])->group(function () {

    Route::get('list_of_postal_districts',[ConsolidateOrderController::class,'list_of_postal_districts'])->name('list_of_postal_districts');
    Route::get('/get_order_by_post_code',[ConsolidateOrderController::class,'get_order_by_post_code'])->name('get_order_by_post_code');
    Route::get('list_order_by_post_code',[ConsolidateOrderController::class,'list_order_by_post_code'])->name('list_order_by_post_code');
    Route::get('get_all_driver',[ConsolidateOrderController::class,'get_all_driver'])->name('get_all_driver');

    Route::get('user_order_item_details', [RetailCustomerController::class, 'user_order_item_details'])->name('user_order_item_details');
    Route::post('update_user_order_product_quantity', [RetailCustomerController::class, 'update_user_order_product_quantity'])->name('update_user_order_product_quantity');
    Route::post('update_address_in_order', [RetailCustomerController::class, 'update_address_in_order'])->name('update_address_in_order');
    Route::post('change_order_delivery_date', [RetailCustomerController::class, 'change_order_delivery_date'])->name('change_order_delivery_date');




    // Route::get('/', [AdminController::class, 'dashboard'])->name('Admin-Dashboard');

    # Add Route for PDF
    //Route::get('generate-pdf', [PDFController::class, 'generatePDF']);

    //  ===============================================================================================
    // Website Dashboard
    //  ===============================================================================================
    Route::get('/Website-Dashboard', [BlogController::class, 'website'])->name('SA-WebsiteDashboard');

    //  ===============================================================================================
    // Dashboard Section
    //  ===============================================================================================
    Route::get('/', [SuperAdminController::class, 'dashboard'])->name('SA-Dashboard');
    // Total No of Products
    Route::get('/no-of-products', [SuperAdminController::class, 'getNoOfProducts'])->name('SA-GetNoOfProducts');
    // Total Sale
    Route::get('/total-sale', [SuperAdminController::class, 'totalSale'])->name('SA-TotalSale');
    // Total Purchase
    Route::get('/total-purchase', [SuperAdminController::class, 'totalPurchase'])->name('SA-TotalPurchase');
    // Total Orders
    Route::get('/total-orders', [SuperAdminController::class, 'totalOrders'])->name('SA-TotalOrders');
    // fetchChartMonthWiseSale
    Route::get('/charts/month-wise-sale', [SuperAdminController::class, 'fetchChartMonthWiseSale'])->name('SA-FetchChartMonthWiseSale');

    //===============================================================================================
    // Update Profile Section
    //===============================================================================================    
    // view profile info
    Route::get('/profile', [SuperAdminController::class, 'profile'])->name('SA-Profile');
    // file for update profile info
    Route::get('/profile-path', [SuperAdminController::class, 'updateProfileFile'])->name('SA-UpdateProfilePath');
    // update profile
    Route::post('/update-profile', [SuperAdminController::class, 'updateProfile'])->name('SA-UpdateProfile');
    // Fetch updated data
    Route::get('/fetch-profile-detials', [SuperAdminController::class, 'getProfile'])->name('SA-GetProfile');
    // update password
    Route::post('/update-password/profile', [SuperAdminController::class, 'updatePassword'])->name('SA-UpdatePassword');

    //===============================================================================================
    // User Management Section
    //===============================================================================================
    // user management tab
    Route::get('/user-management', [UserController::class, 'index'])->name('SA-ListUser');
    // show all detials in table format
    Route::get('/fetch-users-details', [UserController::class, 'getUserDetails'])->name('SA-FetchUsersDetials');
    // insert user detials in db
    Route::post('/add-user/user', [UserController::class, 'store'])->name('SA-AddNewUser');
    // fetch data from edit data
    Route::get('/edit-user', [UserController::class, 'edit'])->name('SA-EditUser');
    // update the existing data in db
    Route::post('/update-user', [UserController::class, 'update'])->name('SA-UpdateUser');
    // remvoe user
    Route::get('/delete-user', [UserController::class, 'destroy'])->name('SA-DeleteUser');
    // view the indiviusal details in modal
    Route::get('/view-user', [UserController::class, 'show'])->name('SA-ViewUser');
    // list supplier
    Route::get('/supplier-name', [UserController::class, 'supplier'])->name('SA-ListSupplier');
    Route::get('/user/filter', [UserController::class, 'userfffFilter'])->name('SA-userfffFilter');

    // Inventory
    Route::get('/inventory', [InventoryController::class, 'inventory'])->name('SA-Inventory')->middleware('checkinventory');

    Route::get('/backend/address/postal', [UserUserController::class, 'APIaddres'])->name('user.postal.addresses.backend');

    //===============================================================================================
    // Product Section
    //===============================================================================================

    // add product
    Route::post('/product', [InventoryController::class, 'addProduct'])->name('SA-AddProduct');
    // fetch all products
    Route::get('/get-products', [InventoryController::class, 'getProducts'])->name('SA-GetProducts');
    // fetch a single product
    Route::get('/get-product', [InventoryController::class, 'getProductSection'])->name('SA-GetProductSection');
    // Edit Product
    Route::post('/edit-product', [InventoryController::class, 'editProduct'])->name('SA-EditProduct');
    // Delete Product
    Route::get('/remove-product', [InventoryController::class, 'removeProduct'])->name('SA-RemoveProduct');
    // View Product
    Route::get('/view-product', [InventoryController::class, 'viewProduct'])->name('SA-ViewProduct');
    // fetch all cateogory
    Route::get('/list-categories', [InventoryController::class, 'listCategories'])->name('SA-ListCategories');
    // fetch all cateogory and product
    Route::get('/list-categories-product', [InventoryController::class, 'listCategoriesProduct'])->name('SA-ListCategoriesProduct');
    // fetch varients to select category
    Route::get('/list-varients', [InventoryController::class, 'listVarients'])->name('SA-ListVarients');
    // fetch all varients
    Route::get('/list-varients/unique', [InventoryController::class, 'listUniqueVarients'])->name('SA-ListUniqueVarients');
    // filter product by seletcing category & varients
    Route::get('/list-filter/products', [InventoryController::class, 'listProductsFilter'])->name('SA-ListProductsFilter');
    // filter products by typing products name
    Route::get('/list-filter-name/products', [InventoryController::class, 'listProNameFilter'])->name('SA-ListProNameFilter');
    // list all products detials for form
    Route::get('/get-all-products', [InventoryController::class, 'getAllProducts'])->name('SA-GetAllProducts');
    // list all products detials for form
    Route::get('/get-all-productsaw', [InventoryController::class, 'GetAllProductsaw'])->name('SA-GetAllProductsaw');
    // 
    Route::get('/get-name-products', [InventoryController::class, 'getNameProducts'])->name('SA-GetNameProducts');
    // Bulk Upload Product
    Route::post('/bulk-uploads/product', [BulkProductUpload::class, 'bulkProductUpload'])->name('SA-GetBulkProductUpload');
    // download product excel file
    Route::get('/products-excel', [BulkProductUpload::class, 'productsExcel'])->name('SA-ProductsExcelFile');
    // store bluck stock
    Route::post('/bulk-uploads/stock', [BulkStock::class, 'bulkStockUpload'])->name('SA-GetBulkStockUpload');
    // download stock excel file
    Route::get('/stock-excel', [BulkStock::class, 'stocksExcel'])->name('SA-StocksExcelFile');
    // all dropdown batch code zero invoice
    Route::get('/return-exchange/fetch-all-batch-code/zero-invoice1', [InventoryController::class, 'getAllBatchCode1'])->name('SA-GetAllBatchCode1');

    //===============================================================================================
    // Category Section
    //===============================================================================================

    // Add Category
    Route::post('/add-category', [InventoryController::class, 'addCategory'])->name('SA-AddCategory');
    // fetch all cateogory
    Route::get('/get-categories', [InventoryController::class, 'getCategories'])->name('SA-GetCategories');
    // fetch a single category
    Route::get('/get-category', [InventoryController::class, 'getCategory'])->name('SA-GetCategory');
    // Edit Category
    Route::post('/edit-category', [InventoryController::class, 'editCategory'])->name('SA-EditCategory');
    // Delete Category
    Route::get('/remove-category', [InventoryController::class, 'removeCategory'])->name('SA-RemoveCategory');
    // View Category
    Route::get('/view-category', [InventoryController::class, 'viewCategory'])->name('SA-ViewCategory');
    // add stock
    Route::post('/add-stock', [InventoryController::class, 'addStock'])->name('SA-AddStock');
    // category filter
    Route::get('/category/filter', [InventoryController::class, 'searchCategory'])->name('SA-SearchCategory');


    //===============================================================================================
    // Return and Exchange Section
    //===============================================================================================

    // Add Product
    Route::post('/add-product', [InventoryController::class, 'addREProduct'])->name('SA-AddREProduct');
    // fetch all Products
    Route::get('/fetch-products', [InventoryController::class, 'getREProducts'])->name('SA-GetREProducts');
    // fetch single Product
    Route::get('/return-exchange/fetch-product', [InventoryController::class, 'fetchREProducts'])->name('SA-FetchREProducts');
    // edit Product
    Route::post('/return-exchange/edit-product', [InventoryController::class, 'editREProducts'])->name('SA-EditREProducts');
    // remove Product
    Route::get('/return-exchange/remove-product', [InventoryController::class, 'removeREProducts'])->name('SA-RemoveREProducts');
    // view Product
    Route::get('/return-exchange/view-product', [InventoryController::class, 'viewREProducts'])->name('SA-ViewREProducts');
    // filter status return & exchange
    Route::get('/return-exchange/filter', [InventoryController::class, 'viewREFilter'])->name('SA-ViewREFilter');
    // filter by adding product value
    Route::get('/return-exchange/filter-value', [InventoryController::class, 'inputREFilter'])->name('SA-InputREFilter');
    //  Zero Invoice
    Route::post('/return-exchange/update-zero-invoice', [InventoryController::class, 'updateZeroInvoice'])->name('SA-UpdateZeroInvoice');

    //===============================================================================================
    // Stock Tracking Section
    //===============================================================================================
    // fetch all products detials in stock tracking tab
    Route::get('/stock-tracking-details', [InventoryController::class, 'fetchStockTrackingDetails'])->name('SA-FetchStockTrackingDetails');
    // 
    Route::get('/stock-tracking-products', [InventoryController::class, 'fetchStockProductsDetails'])->name('SA-FetchStockProductsDetails');
    // Stock Tracking Filter Data Search by verdor / customer name
    Route::get('/stock-tracking-products/filter', [InventoryController::class, 'fetchStockProductsDetailsFilter'])->name('SA-FetchStockProductsDetailsFilter');


    //===============================================================================================
    // Stock Againg Section
    //===============================================================================================
    // get stock aging details
    Route::get('/stok-aging-details/get-details', [InventoryController::class, 'getStockDetails'])->name('SA-StockDetails');
    // View single stock product detials
    Route::get('/stok-aging-details/get-single-details', [InventoryController::class, 'getSingleStockDetails'])->name('SA-GetStockDetails');
    // Update Stock detials
    Route::post('/stok-aging-details/update-single-details', [InventoryController::class, 'updateSingleStockDetails'])->name('SA-UpdateStockDetails');
    // remove single stock detials
    Route::get('/stok-aging-details/remove-single-details', [InventoryController::class, 'removeSingleStockDetails'])->name('SA-RemoveStockDetails');
    // filter
    Route::get('/stok-aging-details/filter-single-details', [InventoryController::class, 'filterSingleStockDetails'])->name('SA-FilterStockDetails');



    //===============================================================================================
    // Warehouse Section
    //===============================================================================================
    // Add Warehouse
    Route::post('/add-warehouse', [InventoryController::class, 'addWarehouse'])->name('SA-AddWarehouse');
    // Fetch all warehouse detials
    Route::get('/add-warehouse/list-detials', [InventoryController::class, 'getWarehouseDetails'])->name('SA-GetWarehouseDetails');
    // Fetch single warehouse detials
    Route::get('/add-warehouse/warehouse-detial', [InventoryController::class, 'singleWarehouseDetails'])->name('SA-singleWarehouseDetails');
    // Update warehoue detials
    Route::post('/add-warehouse/update-warehouse-detial', [InventoryController::class, 'updateWarehouseDetails'])->name('SA-UpdateWarehouseDetails');
    // Delete single warehouse detials
    Route::get('/add-warehouse/remove-warehouse-detial', [InventoryController::class, 'removeWarehouseDetails'])->name('SA-RemoveWarehouseDetails');
    // fetch warehouse detials for forms
    Route::get('/add-warehouse/all-list-detials', [InventoryController::class, 'getAllWarehouseDetails'])->name('SA-GetAllWarehouseDetails');
    // get warehouse list name using id
    Route::get('/warehouse/name-list-detials', [InventoryController::class, 'getlistWarehouseNameDetails'])->name('SA-GetListWarehouseNameDetails');
    // get product list name using id
    Route::get('/product/image-list-detials', [InventoryController::class, 'getlistMultiImagesDetails'])->name('SA-GetListMultiImagesDetails');
    // get product  id
    Route::get('/product/image-list-id', [InventoryController::class, 'getlistMultiImagesId'])->name('SA-GetListMultiImagesId');

    //   Add Multi Image
    Route::post('/add-multiImage', [InventoryController::class, 'addMultiImage'])->name('SA-AddMultiImage');
    // fetch all multi Images
    Route::get('/get-Multi', [InventoryController::class, 'getProductsImages'])->name('SA-GetProductsImages');
    // fetch a single Image
    Route::get('/get-Image', [InventoryController::class, 'getImageSection'])->name('SA-GetImageSection');


    // fetch all rack detials
    Route::get('/warehouse/rack-info', [InventoryController::class, 'rackInfo'])->name('SA-RackWarehouseInfo');
    // warehouse filter
    Route::get('/warehouse/filter', [InventoryController::class, 'warehouseFilter'])->name('SA-WarehouseFilter');
    // return goods warehouse
    Route::get('/return-goods-warehouse/list-detials', [InventoryController::class, 'getReturnGoodsWarehouseDetails'])->name('SA-GetReturnGoodsWarehouseDetails');

    //===============================================================================================
    // Sales Section
    //===============================================================================================

    // Sales Tab
    Route::get('/sales', [SalesController::class, 'index'])->name('SA-SalesTab')->middleware('checksales');

    //===============================================================================================
    // Rooute Planing Section
    //===============================================================================================    
    Route::resource('orders_route_planing', RoutePlaningController::class);

    //===============================================================================================
    // Retail Sales Section
    //===============================================================================================
// demo route
Route::get('deliver/export/', [ReportController::class, 'export']);
    // Get all Retail Custmoer details
    Route::get('/sales/retail-customer-orders', [RetailCustomerController::class, 'retailCustomerOrders'])->name('SA-RetailCustomerOrders');

    Route::get('get_online_Sale_data', [RetailCustomerController::class, 'get_online_Sale_data'])->name('get_online_Sale_data');
    Route::get('get_all_address', [RetailCustomerController::class, 'get_all_address'])->name('get_all_address');

    // Retail customer orders packing list
    Route::get('/sales/retail-customer-orders/packing-list', [RetailCustomerController::class, 'pacingList'])->name('SA-RetailCustomerOrdersPackingList');
    // table
    Route::get('/sales/retail-customer-orders/packing-list1', [RetailCustomerController::class, 'pacingList1'])->name('SA-RetailCustomerOrdersPackingList1');
    // excel
    Route::post('/delivery/export', [RetailCustomerController::class, 'export'])->name('deliver.report');
    // table 2
    Route::get('/sales/retail-customer-orders/packing-list2', [RetailCustomerController::class, 'pacingList2'])->name('SA-RetailCustomerOrdersPackingList2');

    // View Products
    Route::get('/sales/ordered-products', [RetailCustomerController::class, 'viewOrderedProducts'])->name('SA-viewOrderedProducts');

    // get and view retail customer details with order
    Route::get('/sales/view/retail-customer-orders-details', [RetailCustomerController::class, 'viewRetailCustomerOrders'])->name('SA-ViewRetailCustomerOrders');

    //===============================================================================================
    // Quotation Tab
    //===============================================================================================
    // create quotation
    Route::post('/sales/add-quotation', [SalesController::class, 'addQuotation'])->name('SA-AddQuotation');
    // fetch all quotation
    Route::get('/sales/list-quotations', [SalesController::class, 'getQuotations'])->name('SA-GetQuotations');
    // fetch a single quotation
    Route::get('/sales/list-quotation', [SalesController::class, 'getQuotation'])->name('SA-GetQuotation');
    // 
    Route::get('/sales/list-quotation1', [SalesController::class, 'getQuotation1'])->name('SA-GetQuotation1');
    // remove a single quotation
    Route::get('/sales/remove-quotation', [SalesController::class, 'removeQuotation'])->name('SA-RemoveQuotation');
    // update quotation
    Route::post('/sales/update-quotation', [SalesController::class, 'updateQuotation'])->name('SA-UpdateQuotation');
    // list all quotations number for forms
    Route::get('/sales/all-list-quotations', [SalesController::class, 'getAllQuotations'])->name('SA-GetAllQuotations');
    // list all quotations number for invoice
    Route::get('/sales/all-list-quotationsinvoice', [SalesController::class, 'getAllinvoiceQuotations'])->name('SA-GetAllinvoiceQuotations');
    // list filter to special price products details & fetch filtered data
    Route::get('/sales/list-filterd-products', [SalesController::class, 'getFilterProducts'])->name('SA-GetFilteredProductsDetials');
    // get products price/special price and other detials by selecting product name
    // Route::get('/sales/list-filterd-products', [SalesController::class, 'getFilterProducts'])->name('SA-GetFilteredProductsDetials');
    // filter quotaion
    Route::get('/sales/quotation/filter', [SalesController::class, 'salesQuotationFilter'])->name('SA-SalesQuotationFilter');
    // get all product detials by matching product and varient detials
    Route::get('/sales/all-products-detials-filtered', [SalesController::class, 'fetchProductsDetialsInfo'])->name('SA-FetchProductsDetialsInfo');
    // All Batch Code
    Route::get('/sales/all-batch-code', [SalesController::class, 'salesAllBatchCode'])->name('SA-SalesAllBatchCode');


    //===============================================================================================
    // Invoice Tab
    //===============================================================================================
    //     // Get Customer List
    Route::get('/sales/customer-list', [SalesController::class, 'getCustomer'])->name('SA-CustomerList');
    // Get Products details List
    Route::get('/sales/products-list', [SalesController::class, 'getProducts'])->name('SA-GetProductsSales');
    // fetch product
    Route::get('/sales/product', [SalesController::class, 'getProduct'])->name('SA-GetProduct');
    // fetch product info by name
    Route::get('/sales/product', [SalesController::class, 'getProductInfo'])->name('SA-GetProductInfo');
    // store invoice
    Route::post('/sales/invoice', [SalesController::class, 'storeInvoice'])->name('SA-StoreInvoice');
    // get invoice detials
    Route::get('/sales/invoice-list', [SalesController::class, 'getInvoice'])->name('SA-InvoiceList');
    // fetch single invoice
    Route::get('/sales/single-invoice', [SalesController::class, 'getSingleInvoice'])->name('SA-SingleInvoice');
    // Edit Invoice
    Route::post('/sales/update-invoice', [SalesController::class, 'updateInvoice'])->name('SA-UpdateInvoice');
    // remove invoice
    Route::get('/sales/remove-invoice', [SalesController::class, 'removeInvoice'])->name('SA-RemoveInvoice');
    // sales invoice filter
    Route::get('/sales/filter-invoice', [SalesController::class, 'filterInvoice'])->name('SA-FilterInvoice');
    // fetch all invoice detials to view in payment section
    Route::get('/sales/all-invoice-list', [SalesController::class, 'getAllInvoice'])->name('SA-AllInvoiceList');
    // 
    Route::get('/sales/all-invoice-list-Payment', [SalesController::class, 'getAllInvoiceForPayment'])->name('SA-GetAllInvoiceForPayment');
    // fetch all invoices detials
    Route::get('/sales/all-invoices-for-payments', [SalesController::class, 'getAllInvoicesforPayment'])->name('SA-FetchAllInvoiceForPayments');
    // 
    Route::get('/sales/all-invoices-for-payments1', [SalesController::class, 'getAllInvoicesforPayment1'])->name('SA-FetchAllInvoiceForPayments1');
    // list purchase invoice
    Route::get('/purchase/all-invoice-list-return-exchage', [PurchaseController::class, 'getAllInvoiceForReturnExchange'])->name('SA-GetAllInvoiceForReturnExchange');
    // fetch all purchase invoice of unique vendors
    Route::get('/purchase/all-invoices-no-for-return-exchage', [PurchaseController::class, 'fetchAllInvoicesNoforPayment'])->name('SA-FetchAllInvoiceNoForPayments');
    // fetch all products detials by choosing invoice number from dropdown
    Route::get('/purchase/purchase-order-details', [PurchaseController::class, 'fetchAllProductsDetails'])->name('SA-FetchAllProductsDetials');
    // filter invoice by customer name
    Route::get('/invoice/filter', [SalesController::class, 'filterInvoiceName'])->name('SA-FilterInvoiceName');



    // ************************************-------------------------------*****************************
    // fetch all quotation coifrm order
    Route::get('/sales/list-quotations-order', [SalesController::class, 'getQuotationsorder'])->name('SA-getQuotationsorder');

    Route::get('/sales/status-quotation', [SalesController::class, 'statusQuotation'])->name('SA-statusQuotation');
    Route::get('/sales/status-quotation-order', [SalesController::class, 'statusorderQuotation'])->name('SA-statusorderQuotation');
    //===============================================================================================
    // Generate PDF Tab
    //===============================================================================================    

    // Sales Tab - generate pdf
    Route::get('generate-pdf/{id}', [SalesController::class, 'generatePDF'])->name('SA-generate');
    Route::get('print-pdf/{id}', [SalesController::class, 'printSalesInvoicePDF'])->name('SA-generatePdf');
    // Sales Tab - Quotation
    Route::get('generate-q-pdf/{id}', [SalesController::class, 'generateQuotationPDF'])->name('SA-GenerateQuotation');

    // ************************************-------------------------------*****************************
    // Invoice for online sale
    Route::get('generate-online-sale-invoice-pdf/{id}', [SalesController::class, 'generateOnlineSaleInvoicePDF'])->name('SA-GenerateOnlineSaleInvoicePDF');
    // ************************************-------------------------------*****************************

    // Purchase Tab - generate pdf
    Route::get('purchase-q-generate-pdf/{id}', [PurchaseController::class, 'purchaseQGeneratePDF'])->name('SA-PurchaseQGenerate');
    // Purchase Tab - Invoice
    Route::get('purchase-invoice-generate-pdf/{id}', [PurchaseController::class, 'purchaseInvoiceGeneratePDF'])->name('SA-PurchaseInvoiceGenerate');

    //===============================================================================================
    // Payment Tab
    //===============================================================================================
    // fetch all invoice number
    Route::get('/sales/invoice-details', [SalesController::class, 'getInvoiceDetails'])->name('SA-InvoiceDetails');
    // store data in database
    Route::post('/sales/add-payment', [SalesController::class, 'addPayment'])->name('SA-AddPayment');
    // fetch payment all details
    Route::get('/sales/payment-list', [SalesController::class, 'getPayments'])->name('SA-GetPaymentList');
    // fech single column payment detials
    Route::get('/sales/payment', [SalesController::class, 'getPaymentDetials'])->name('SA-GetPaymentDetails');
    // edit payment detials
    Route::post('/sales/edit-payment', [SalesController::class, 'editPaymentDetails'])->name('SA-editPaymentDetails');
    // delete payment row
    Route::get('/sales/remove-payment', [SalesController::class, 'removePaymentDetials'])->name('SA-RemovePaymentDetails');
    // payment filter
    Route::get('/sales/filter-payment', [SalesController::class, 'filterPaymentDetials'])->name('SA-FilterPaymentDetails');
    // fetch all invoice number for dropdown
    Route::get('/sales/invoice-No-details', [SalesController::class, 'getInvoiceNoDetails'])->name('SA-FetchInvoiceNoDetails');
    // filter by customer name
    Route::get('/sales/payment/filter', [SalesController::class, 'getPaymentsFilter'])->name('SA-GetPaymentFilter');

    //===============================================================================================
    // Customer Tab
    //===============================================================================================
    // Customer Management System
    Route::get('/customer-management', [SalesController::class, 'customerManagement'])->name('SA-CustomerManagement')->middleware('checkcustomer');
    // add customer
    // Route::get('/sales/add-customer', [SalesController::class, 'addCustomer'])->name('SA-AddCustomer');
    Route::post('/sales/add-customer', [SalesController::class, 'addCustomer'])->name('SA-AddCustomer');

    //add retail customer
    Route::post('/sales/add-retail-customer', [SalesController::class, 'addRetailCustomer'])->name('SA-AddRetailCustomer');

    // fetch all customer details
    Route::get('/sales/customer/customers-list', [SalesController::class, 'customersList'])->name('SA-CustomersList');
    // all customers for pagination
    Route::get('/sales/customer/customers-list/Paginate', [SalesController::class, 'customersListPaginate'])->name('SA-CustomersListPaginate');
    // get single customer details
    Route::get('/sales/customer', [SalesController::class, 'getCustomerDetails'])->name('SA-GetCustomerDetails');
    Route::get('/sales/customer-details', [SalesController::class, 'getCustomerDetails1'])->name('SA-GetCustomerDetails1');
    // get single customer sales invoice details
    Route::get('/sales/customer/sales-invoice', [SalesController::class, 'getCustomerSalesInvoiceDetails'])->name('SA-getCustomerSalesInvoiceDetails');
    // update customer details
    Route::post('/sales/edit-customer', [SalesController::class, 'editCustomerDetails'])->name('SA-EditCustomerDetails');
    // remove customer details
    Route::get('/sales/remove-customer', [SalesController::class, 'removeCustomer'])->name('SA-RemoveCustomer');
    // add customer special price
    Route::post('/sales/update-customer', [SalesController::class, 'updateCustomerDetails'])->name('SA-UpdateCustomerDetails');
    // customer filter
    Route::get('/customer/filter', [SalesController::class, 'customerFilter'])->name('SA-CustomerFilter');
    // retail customer filter
    Route::get('/retail-customer/filter', [SalesController::class, 'retailCustomerFilter'])->name('SA-RetailCustomerFilter');


    //===============================================================================================
    // Retail Customer Tab
    //===============================================================================================

    // view all retails customer
    Route::get('/customer-management/retail-customer', [RetailCustomerController::class, 'retailCustomer'])->name('SA-RetailCustomer');

    // redirect to order page
    Route::resource('retail_customer_order', CustomerOrderController::class);
    Route::get('/retail_customer_order/delete/{id}', [CustomerOrderController::class, 'destroy']);

    Route::get('get_customer_details',[CustomerOrderController::class, 'get_customer_details'])->name('get_customer_details');
    Route::get('get_product_details',[CustomerOrderController::class, 'get_product_details'])->name('get_product_details');
    Route::post('add_new_address',[CustomerOrderController::class, 'add_new_address'])->name('add_new_address');
    Route::get('get_all_product_list',[CustomerOrderController::class, 'get_all_product_list'])->name('get_all_product_list');
    Route::get('get_previous_order_details',[CustomerOrderController::class, 'get_previous_order_details'])->name('get_previous_order_details');
    Route::post('add_new_order',[CustomerOrderController::class, 'add_new_order'])->name('add_new_order');

    // updateOrder1
    Route::post('/customer-update_order_table/retail-customer', [CustomerOrderController::class, 'updateOrder1'])->name('SA-backend.updateOrder1');
    // updateOrder2
    Route::post('/customer-update_order_table/retail-customer1', [CustomerOrderController::class, 'updateOrder2'])->name('SA-backend.updateOrder12');

    // fetch single retail customer details
    Route::get('/customer-management/single-retail-customer-details', [RetailCustomerController::class, 'singleRetailCustomer'])->name('SA-SingleRetailCustomer');
    // retail customer wise products
    Route::get('/customer-management/retail-customer-wise-products', [RetailCustomerController::class, 'fetchRetailCustomerWiseProduct'])->name('SA-FetchRetailCustomerWiseProduct');
    // 
    Route::get('/customer-management/retail-customer-wise-products/products-details', [RetailCustomerController::class, 'fetchRetailCustomerWiseProductDetails'])->name('SA-FetchRetailCustomerWiseProductDetails');
    // update retail customer status
    Route::post('/customer-management/update-retail-customer-status', [RetailCustomerController::class, 'updateRetailCustomerStatus'])->name('SA-UpdateRetailCustomerStatus');

    // add order for retail customer
    Route::get('/customer-management/retail-customer-order', [RetailCustomerController::class, 'retailCustomerOrder'])->name('SA-RetailCustomerOrder');


    //===============================================================================================
    // Purchase Tab
    //===============================================================================================
    // Puechase tab
    Route::get('/purchase', [PurchaseController::class, 'index'])->name('SA-Purchase')->middleware('checkpurchase');

    //===============================================================================================
    // Vendor Tab
    //===============================================================================================
    // Add Vendor
    Route::post('/purchase/add-vendor', [PurchaseController::class, 'addVendor'])->name('SA-AddVendor');
    // Fetch all vendors details
    Route::get('/purchase/fetch-vendors', [PurchaseController::class, 'getVendors'])->name('SA-GetVendors');
    // Fetch single vendor
    Route::get('/purchase/fetch-vendor', [PurchaseController::class, 'getVendor'])->name('SA-GetVendor');
    // Update single vendor
    Route::post('/purchase/update-vendor', [PurchaseController::class, 'updateVendor'])->name('SA-UpdateVendor');
    // Remove single vendor
    Route::get('/purchase/remove-vendor', [PurchaseController::class, 'removeVendor'])->name('SA-RemoveVendor');
    // fetch all vendors detials
    Route::get('/purchase/fetch-all-vendor', [PurchaseController::class, 'getAllVendors'])->name('SA-FetchAllVendor');
    // filter via vendor name
    Route::get('/purchase/vendor/filter', [PurchaseController::class, 'filterPurchaseVendor'])->name('SA-FilterPurchaseVendor');

    //===============================================================================================
    // Purchase Requisition Tab
    //===============================================================================================    
    // Get GST treatments by choosing vendor names
    Route::get('/purchase/gst-treatment', [PurchaseController::class, 'getGSTTreatment'])->name('SA-GSTTreatment');
    // Add Quotation for purchase section
    Route::post('/purchase/add-request', [PurchaseController::class, 'addRequest'])->name('SA-AddRequest');
    // Fetch all Requesting Quotations
    Route::get('/purchase/all-quotation', [PurchaseController::class, 'requestQuotations'])->name('SA-RequestQuotation');
    // Fetch Single Requesting Quotation
    Route::get('/purchase/single-quotation', [PurchaseController::class, 'getRequestQuotation'])->name('SA-GetSingleQuotation');
    // Update Quotation
    Route::post('/purchase/update-quotation', [PurchaseController::class, 'updateRequestQuotation'])->name('SA-UpdateSingleQuotation');
    // Remove Requesting Quotataion
    Route::get('/purchase/remove-quotation', [PurchaseController::class, 'removeRequestQuotation'])->name('SA-RemoveSingleQuotation');
    // fetch all products detials to show quotation id 
    Route::get('/purchase/all-quotation-detials', [PurchaseController::class, 'requestAllQuotations'])->name('SA-RequestAllQuotation');
    // purchase request filter by vendor name
    Route::get('/purchase-req/filter', [PurchaseController::class, 'requestAllQuotationsFilter'])->name('SA-RequestAllQuotationsFilter');
    // fetch all products detials
    Route::get('/sales/all-products-purchase', [PurchaseController::class, 'fetchProductsAllInfo'])->name('SA-FetchProductsAllDetialsInfo');

    //===============================================================================================
    // Purchase Order Tab
    //===============================================================================================    

    // Add Purchase Order data
    Route::post('/purchase-order/add-order', [PurchaseController::class, 'addPurchaseOrder'])->name('SA-AddPurchaseOrder');
    // Fetch all orders detials
    Route::get('/purchase-order/orders-details', [PurchaseController::class, 'getOrdersDetails'])->name('SA-GetOrdersDetails');
    // Fetch single order detials
    Route::get('/purchase-order/order-details', [PurchaseController::class, 'getOrderDetails'])->name('SA-GetOrderDetails');
    // Update purchase order detials
    Route::post('/purchase-order/update-details', [PurchaseController::class, 'updateOrderDetails'])->name('SA-UpdateOrderDetails');
    // Remove order detials
    Route::get('/purchase-order/remove-details', [PurchaseController::class, 'removeOrderDetails'])->name('SA-RemoveOrderDetails');
    // Purchase filter by vendor name
    Route::get('/purchase/filter', [PurchaseController::class, 'purchaseOrderFilter'])->name('SA-PurchaseOrderFilter');

    //===============================================================================================
    // Fixed Asset Management Tab
    //===============================================================================================    

    // Asset
    // fixed asset management route
    Route::get('/fixed-asset-management', [FixedAssetContoller::class, 'index'])->name('SA-FixedAssetManagement');
    // Add Asset
    Route::post('/fixed-asset-management/add-asset', [FixedAssetContoller::class, 'addAsset'])->name('SA-AddAsset');
    // Fatch all Asset Detials
    Route::get('/fixed-asset-management/list-asset', [FixedAssetContoller::class, 'getAsset'])->name('SA-GetAsset');
    // 
    Route::get('/fixed-asset-management/list-asset-all', [FixedAssetContoller::class, 'getAssetList'])->name('SA-getAssetList');
    // get single asset detials
    Route::get('/fixed-asset-management/single-asset', [FixedAssetContoller::class, 'fetchAsset'])->name('SA-FetchAsset');
    // Update asset detials
    Route::post('/fixed-asset-management/update-asset', [FixedAssetContoller::class, 'updateAsset'])->name('SA-UpdateAsset');
    // Remove asset detials
    Route::get('/fixed-asset-management/remove-asset', [FixedAssetContoller::class, 'removeAsset'])->name('SA-RemoveAsset');

    //===============================================================================================
    // Asset Tracking Tab
    //===============================================================================================   

    // get quantity
    Route::get('/fixed-asset-management/single-asset-quantity', [FixedAssetContoller::class, 'fetchAssetQuantity'])->name('SA-FetchAssetQuantity');
    // Add asset tracking data
    Route::post('/fixed-asset-tracking/add-asset-tracking', [FixedAssetContoller::class, 'addAssetTrakingData'])->name('SA-AddAssetTrackingData');
    // fetch all asset tracking detials
    Route::get('/fixed-asset-tracking/asset-tracking-details', [FixedAssetContoller::class, 'assetTrakingDetails'])->name('SA-AssetTrackingDetails');
    // fetch single asset tracking detials
    Route::get('/fixed-asset-tracking/single-asset-tracking-details', [FixedAssetContoller::class, 'fetchAssetTrakingDetails'])->name('SA-FetchAssetTrackingDetails');
    // update asset tracking detials
    Route::post('/fixed-asset-tracking/update-asset-tracking-details', [FixedAssetContoller::class, 'updateAssetTrakingDetails'])->name('SA-UpdateAssetTrackingDetails');
    // remove single asst traking detials
    Route::get('/fixed-asset-tracking/remove-asset-tracking-details', [FixedAssetContoller::class, 'removeAssetTrakingDetails'])->name('SA-RemoveAssetTrackingDetails');

    //===============================================================================================
    // Reports Tab
    //===============================================================================================       

    // reports tab
    Route::get('/reports', [ReportController::class, 'index'])->name('SA-Reports')->middleware('checkreports');
    // get total products (sum of price)
    Route::get('/reports/all-products', [ReportController::class, 'getTotalProductsValues'])->name('SA-TotalProductsValues');
    // fetch detials of product in report tab
    Route::get('/reports/product-detials', [ReportController::class, 'getTotalProductsDetials'])->name('SA-TotalProductsDetails');

    //===============================================================================================
    // refferal Tab
    //===============================================================================================      

    Route::get('/refferal', [Refferal::class, 'index'])->name('SA-Refferal');
    Route::get('/get-refferals', [Refferal::class, 'GetRefferals'])->name('SA-GetRefferals');
    Route::get('/remove-refferals', [Refferal::class, 'removeRefferals'])->name('SA-RemoveRefferals');
    Route::get('/get-refferals-Id', [Refferal::class, 'RefergetId'])->name('SA-RefergetId');
    Route::post('/edit-refferals-settings', [Refferal::class, 'EditRewardcreate'])->name('SA-EditRewardcreate');

    //===============================================================================================
    // loyalty point
    //===============================================================================================   
    // fetch all loyalty points
    Route::get('/LoyaltyPoint/fetch-all-points', [LoyaltyPointController::class, 'fetchAllPoints'])->name('SA-loyaltyPoints');
    // 
    Route::get('/LoyaltyPoint', [LoyaltyPointController::class, 'index'])->name('SA-LoyaltyPoint');
    Route::post('/add-LoyaltyPoint', [LoyaltyPointController::class, 'AddLoyaltyPoints'])->name('SA-AddLoyaltyPoints');
    Route::get('/get-LoyaltyPoint', [LoyaltyPointController::class, 'RefergetIdss'])->name('SA-RefergetIdss');
    Route::get('/get-GetAssetloyal', [LoyaltyPointController::class, 'GetAssetloyal'])->name('SA-GetAssetloyal');
    Route::get('/get-FetchAssetloyality', [LoyaltyPointController::class, 'FetchAssetloyality'])->name('SA-FetchAssetloyality');
    Route::get('/remove-loyality', [LoyaltyPointController::class, 'removeLoyality'])->name('SA-removeLoyality');

    Route::get('/get-GetAssetloyalshop', [LoyaltyPointController::class, 'GetAssetloyalshop'])->name('SA-GetAssetloyalshop');
    Route::post('/add-loyalshopData', [LoyaltyPointController::class, 'AddloyalshopData'])->name('SA-AddloyalshopData');
    Route::get('/get-GetNameProductsa', [LoyaltyPointController::class, 'GetNameProductsa'])->name('SA-GetNameProductsa');
    Route::get('/remove-loyality-shop', [LoyaltyPointController::class, 'removeLoyalityShop'])->name('SA-removeLoyalityShop');
    Route::get('/single-loyalityShop', [LoyaltyPointController::class, 'FetchAssetshop'])->name('SA-FetchAssetshop');
    Route::post('/edit-loyalityShop', [LoyaltyPointController::class, 'editoyalshopData'])->name('SA-editoyalshopData');

    // e - creadit
    Route::get('/ECredit', [ECreditController::class, 'index'])->name('SA-ECredit');
    // Store ECredit
    Route::post('/ECredit/store', [ECreditController::class, 'store'])->name('SA-StoreECredit');
    // fetch all E-Credit Details
    Route::get('/ECredit/fetch-all', [ECreditController::class, 'fetchAllECredit'])->name('SA-FetchAllECredit');
    // fetch single e-credit details
    Route::get('/ECredit/fetch-single', [ECreditController::class, 'fetchSingleECredit'])->name('SA-FetchSingleECredit');
    // update e-credit details
    Route::post('/ECredit/update-single', [ECreditController::class, 'updateSingleECredit'])->name('SA-UpdateSingleECredit');
    // remove single e-credit details
    Route::get('/ECredit/remove-single', [ECreditController::class, 'removeSingleECredit'])->name('SA-RemoeSingleECredit');
    // 
    Route::get('/OfferPackages', [OfferPackagesController::class, 'index'])->name('SA-OfferPackages');

    //============================================================================================================== 
    // Offer & coupon routes
    //============================================================================================================== 
    // fetch all products details for list
    Route::get('/fetch-products/products-list-dropdown', [OfferPackagesController::class, 'getProductsDetailsList'])->name('SA-GetProductsDetailsList');
    // fetch all category details for list
    Route::get('/fetch-category/category-list-dropdown', [OfferPackagesController::class, 'getCategoryDetailsList'])->name('SA-GetCategoryDetailsList');
    // 
    // 
    // 

    // offers
    Route::get('/OfferPackages', [OfferPackagesController::class, 'index'])->name('SA-OfferPackages');
    // add Offer
    Route::post('/offer', [OfferPackagesController::class, 'addOffer'])->name('SA-AddOffer');
    // fetch all Offer
    Route::get('/get-offers', [OfferPackagesController::class, 'getOffers'])->name('SA-GetOffers');
    // fetch a single Offer
    Route::get('/get-offer', [OfferPackagesController::class, 'getOffer'])->name('SA-GetOffer');
    // Edit Offer
    Route::post('/edit-offer', [OfferPackagesController::class, 'editOffer'])->name('SA-EditOffer');
    // Delete Offer
    Route::get('/remove-offer', [OfferPackagesController::class, 'removeOffer'])->name('SA-RemoveOffer');
    // View Offer
    Route::get('/view-offer', [OfferPackagesController::class, 'viewOffer'])->name('SA-ViewOffer');

    // 
    // 
    // 
    // Delete Offer
    // Route::get('/remove-offer', [OfferPackagesController::class, 'removeOffer'])->name('SA-RemoveOffer');
    // add Coupon
    Route::post('/coupon', [OfferPackagesController::class, 'addCoupon'])->name('SA-AddCoupon');
    // Edit Coupon
    Route::post('/edit-coupon', [OfferPackagesController::class, 'editCoupon'])->name('SA-EditCoupon');
    // Delete Coupon
    Route::get('/remove-coupon', [OfferPackagesController::class, 'removeCoupon'])->name('SA-RemoveCoupon');
    // View Coupon
    Route::get('/view-coupon', [OfferPackagesController::class, 'viewCoupon'])->name('SA-ViewCoupon');
    // fetch a single Coupon
    Route::get('/get-coupon', [OfferPackagesController::class, 'getCoupon'])->name('SA-GetCoupon');
    // fetch all Coupon
    Route::get('/get-coupons', [OfferPackagesController::class, 'getCoupons'])->name('SA-GetCoupons');


    // Banner
    // add Banners
    Route::post('/banner', [OfferPackagesController::class, 'addBanner'])->name('SA-AddBanner');
    // fetch all Banners
    Route::get('/get-banners', [OfferPackagesController::class, 'getBanners'])->name('SA-GetBanners');
    // fetch a single Banners
    Route::get('/get-banner', [OfferPackagesController::class, 'getBanner'])->name('SA-GetBanner');
    // Edit Banners
    Route::post('/edit-banner', [OfferPackagesController::class, 'editBanner'])->name('SA-EditBanner');
    // Delete Banners
    Route::get('/remove-banner', [OfferPackagesController::class, 'removeBanner'])->name('SA-RemoveBanner');
    // View Banners
    Route::get('/view-banner', [OfferPackagesController::class, 'viewBanner'])->name('SA-ViewBanner');
    //        // 
    Route::get('/banner/status-selection/filter', [OfferPackagesController::class, 'filterStatusOfBanner'])->name('SA-FilterStatusOfBanner');

    //===============================================================================================
    // Deliverey
    //===============================================================================================
    Route::get('/Delivery', [DeliveryController::class, 'index'])->name('SA-Delivery');
    // 
    Route::get('/Delivery/drivers', [DeliveryController::class, 'driversList'])->name('SA-DriversList');
    // 
    Route::get('/Delivery/drivers/count/orders', [DeliveryController::class, 'countOrders'])->name('SA-DriversCountOrders');
    // 
    Route::get('/Delivery/driver/deliveries', [DeliveryController::class, 'driverDeliveries'])->name('SA-DriversDeliveries');
    // 
    Route::get('/Delivery/getorder', [DeliveryController::class, 'GetOrder'])->name('SA-GetOrder');
    Route::get('/Delivery/remove-delivery-order', [DeliveryController::class, 'removeOrder'])->name('SA-removeOrder');
    Route::get('/cancel-order', [DeliveryController::class, 'cancelOrder'])->name('SA-cancelOrder');
    Route::get('/list-order', [DeliveryController::class, 'getOrderview'])->name('SA-getOrderview');
    Route::get('/Delivery/order/filter', [DeliveryController::class, 'OrderFilter'])->name('SA-OrderFilter');
    Route::post('/Delivery/Date', [DeliveryController::class, 'storeDeliverydate'])->name('SA-storedeliveryDate');
    Route::get('/get-Delivery/Date', [DeliveryController::class, 'getDeliverydate'])->name('SA-getDeliverDate');
    Route::get('/delete-date', [DeliveryController::class, 'destroyDate'])->name('SA-DeleteDate');

    // Store Delivery Route
    Route::post('/store/delvery/route', [DeliveryController::class, 'storeDeliveryRoute'])->name('SA-StoreDeliveryRoute');

    //===============================================================================================
    // Delivery Management Section
    //===============================================================================================
    // Order No. & details or form
    Route::get('/sales-order/orders', [DeliveryController::class, 'fetchOrderDetails'])->name('SA-FetchOrderDetails');
    // Delivery Tab
    // Route::get('/deliveries', [DeliveryController::class, 'index'])->name('SA-DeliveryTab');
    // add Delivery
    Route::post('/delivery', [DeliveryController::class, 'addDelivery'])->name('SA-AddDelivery');
    // fetch all Delivery
    Route::get('/get-deliveries', [DeliveryController::class, 'getDeliveries'])->name('SA-GetDeliveries');
    // fetch a single Delivery
    Route::get('/get-delivery', [DeliveryController::class, 'getDelivery'])->name('SA-GetDelivery');
    // Edit Delivery
    Route::post('/edit-delivery', [DeliveryController::class, 'editDelivery'])->name('SA-EditDelivery');
    // Delete Delivery
    Route::get('/remove-delivery', [DeliveryController::class, 'removeDelivery'])->name('SA-RemoveDelivery');
    // View Delivery
    Route::get('/view-delivery', [DeliveryController::class, 'viewDelivery'])->name('SA-ViewDelivery');
    //Fatch deliveryman name
    Route::get('/get-deliveryman-name', [DeliveryController::class, 'viewDeliverymanName'])->name('SA-deliverymanList');


    //===============================================================================================
    // Consolidate Order Section
    //===============================================================================================    

    // Fetch all notification
    Route::get('/sales-order/consolidate-orders', [ConsolidateOrderController::class, 'index'])->name('SA-ConsolidateOrderIndex');
    // 
    Route::get('/sales-order/fetch-all-consolidate-orders', [ConsolidateOrderController::class, 'fetchAllConsolidateOrder'])->name('SA-FetchAllConsolidateOrder');
    // 
    Route::get('/sales-order/view-consolidate-orders', [ConsolidateOrderController::class, 'view'])->name('SA-ViewConsolidateOrderIndex');

    Route::get('consolidate_Order_list_with_postal_code', [ConsolidateOrderController::class, 'consolidate_Order_list_with_postal_code'])->name('consolidate_Order_list_with_postal_code');
    // update order status
    Route::get('/order/cancel_orders_open', [ConsolidateOrderController::class, 'viewCancelOrderForm'])->name('SA-CancelOrderIndexForm');
    // Cancel Order
    Route::post('/order/cancel_orders', [ConsolidateOrderController::class, 'CancelOrder'])->name('SA-CancelOrder');

    // Cancel order lsit
    Route::get('/order/cancel_orders/list', [ConsolidateOrderController::class, 'CancelOrderList'])->name('SA-CancelOrderList');

    // RetailCustomerOrders
    
    // 
    Route::get('/sales-order/view-all-consolidate-orders', [ConsolidateOrderController::class, 'fetchAllOrders'])->name('SA-ViewListConsolidateOrderIndex');
    // Add Online Sale Delivery
    Route::post('/online-sales/add-consolidate-orders-delivery', [ConsolidateOrderController::class, 'addOnlineSaleDelivery'])->name('SA-AddOnlineSaleDelivery');
    // update driver get method
    Route::get('/online-sales/add-consolidate-orders-delivery1', [ConsolidateOrderController::class, 'addOnlineSaleDelivery1'])->name('SA-AddOnlineSaleDelivery1');



    //===============================================================================================
    // END HERE
    //===============================================================================================    

    //===============================================================================================
    // Configuration Section
    //===============================================================================================    

    // Consolidate section config
    Route::get('/configuration', [ConfigurationController::class, 'index'])->name('SA-Configuration');
    // Store
    Route::post('/configuration/update-store', [ConfigurationController::class, 'store'])->name('SA-UpdateConfiguration');
    // Fetch
    Route::get('/configuration/fetch', [ConfigurationController::class, 'fetch'])->name('SA-FetchConsolidateConfiguration');


    //===============================================================================================
    // Live Date Configuration
    //===============================================================================================    

    // Store Live Date to DB
    Route::post('/live-date-configuration/store', [LiveDateConfigController::class, 'store'])->name('SA-UpdateLiveDateConfiguration');
    // fetch
    Route::get('/live-date-configuration/fetch', [LiveDateConfigController::class, 'fetch'])->name('SA-FetchLiveDateConfiguration');

    //===============================================================================================
    // END HERE
    //===============================================================================================    


    // cancel order
    Route::get('/cancel-orders', [DeliveryController::class, 'CancleOrder'])->name('SA-CancleOrder');
    Route::get('/Delivery/GetOrdercancel', [DeliveryController::class, 'GetOrdercancel'])->name('SA-GetOrdercancel');

    // drivr
    Route::get('/Delivery/getdriver', [DeliveryController::class, 'GetdriverList'])->name('SA-GetdriverList');
    Route::post('/add-driver', [DeliveryController::class, 'AddDriver'])->name('SA-AddDriver');
    Route::get('/remove-driver', [DeliveryController::class, 'RemoveDriver'])->name('SA-RemoveDriver');
    Route::post('/edit-driver', [DeliveryController::class, 'EditDriver'])->name('SA-EditDriver');
    Route::get('/get-driver-single', [DeliveryController::class, 'FetchDriver'])->name('SA-FetchDriver');

    //===============================================================================================
    // Loyalty System Tab
    //===============================================================================================   

    // store loyalty points
    Route::post('/loyalty-system/store', [LoyaltyPointController::class, 'storeLoyaltyPoints'])->name('SA-StoreLoyaltyPoints');
    // fetchLoyaltyPoints
    Route::get('/loyalty-system/points', [LoyaltyPointController::class, 'fetchLoyaltyPoints'])->name('SA-FetchLoyaltyPoints');

    // 
    // 
    // Blogs
    // 
    // 
    Route::get('/blog/section', [BlogController::class, 'index'])->name('SA-Blog');
    // store
    Route::post('/blog/store', [BlogController::class, 'store'])->name('SA-storeBlog');
    // edit
    Route::post('/blog/edit', [BlogController::class, 'update'])->name('SA-updateBlog');
    // view
    Route::get('/blog/view', [BlogController::class, 'view'])->name('SA-viewBlog');
    // delete
    Route::get('/blog/delete', [BlogController::class, 'destroy'])->name('SA-destroyBlog');
    // view all
    Route::get('/blog/all', [BlogController::class, 'allView'])->name('SA-allBlog');
    // 
    // 
    // 
    //  Video
    // 
    // 
    // 
    // store
    Route::post('/blog/section/video', [BlogController::class, 'videostore'])->name('SA-storevideo');
    // edit
    Route::post('/blog/edit/video', [BlogController::class, 'videoupdate'])->name('SA-updateVideoBlog');

    // view
    Route::get('/blog/view/video', [BlogController::class, 'Videoview'])->name('SA-viewVideoBlog');

 // delete
    Route::get('/blog/delete/video', [BlogController::class, 'videodestroy'])->name('SA-destroyVideoBlog');
    // view all
    Route::get('/blog/all/video', [BlogController::class, 'videoallView'])->name('SA-allVideoBlog');
    // 
    // Contacts queries
    // 
    // 
    Route::get('/contacts', [ContactController::class, 'index'])->name('SA-Contact');
    // store
    // delete
    Route::get('/contact/delete', [ContactController::class, 'destroy'])->name('SA-destroyContact');
    // view all
    Route::get('/contact/all', [ContactController::class, 'allView'])->name('SA-allContact');

    // 
    // 
    // News Letter
    // 
    // 
    Route::get('/newsletter', [NewsLetterController::class, 'index'])->name('SA-Newsletter');
    // store
    // delete
    Route::get('/newsletter/delete', [NewsLetterController::class, 'destroy'])->name('SA-destroyNewsletter');
    // view all
    Route::get('/newsletter/all', [NewsLetterController::class, 'allView'])->name('SA-allNewsletter');


    //===============================================================================================
    // POS System Tab
    //===============================================================================================   

    // dashboard
    Route::get('/pos', [PosManagementController::class, 'index'])->name('SA-POSDASHBOARD');
    // store outlet
    Route::post('/pos/store-outlet', [PosManagementController::class, 'store'])->name('SA-PosStoreOutlet');
    // fetch all outlet
    Route::get('/pos/fetch-all-outlet', [PosManagementController::class, 'fetchAllOutLet'])->name('SA-FetchAllOutLet');
    // fetch single outlet details
    Route::get('/pos/fetch-single-outlet-details', [PosManagementController::class, 'fetchSingleOutletDetails'])->name('SA-FetchSingleOutletDetails');
    // update single outlet details
    Route::post('/pos/update-outlet', [PosManagementController::class, 'update'])->name('SA-PosUpdateOutlet');
    // remove single outlet details
    Route::get('/pos/remove', [PosManagementController::class, 'remove'])->name('SA-PosRemoveOutletDetails');

    // Add Stock OUTLET Management
    // store stock
    Route::post('/pos/store-outlet-stock', [PosManagementController::class, 'outletStoreStock'])->name('SA-OutletStoreStock');
    // Route::get('/pos/store-outlet-stock', [PosManagementController::class, 'outletStoreStock'])->name('SA-OutletStoreStock');
    // fetch all products
    Route::get('/pos/fetch-all-products/outlet-stock', [PosManagementController::class, 'fetchAllProductsList'])->name('SA-FetchAllProductsList');
    // fetch all product details via variant
    Route::get('/pos/fetch-all-variants/outlet-stock', [PosManagementController::class, 'fetchAllVariantList'])->name('SA-FetchAllVariantList');
    // fetch all details of product for stock
    Route::get('/pos/fetch-all-product-details/outlet-stock', [PosManagementController::class, 'fetchAllProductsDetailsStock'])->name('SA-FetchAllProductsDetailsStock');
    // Fetch all outlet stock details for table
    Route::get('/pos/fetch-all-stock/outlet-stock', [PosManagementController::class, 'fetchAllOutletStockDetails'])->name('SA-FetchAllOutletStockDetails');
    // fetch single outlet stock details
    Route::get('/pos/fetch-single-stock/outlet-stock', [PosManagementController::class, 'fetchSingleOutletStockDetails'])->name('SA-FetchSingleOutletStockDetails');
    // update single outlet stock details
    Route::post('/pos/update-outlet-stock', [PosManagementController::class, 'outletUpdateStock'])->name('SA-OutletUpdateStock');
    // remove single outlet stock details
    Route::get('/pos/remove-outlet-stock', [PosManagementController::class, 'outletRemoveStock'])->name('SA-OutletRemoveStock');

    // outlet management
    Route::get('/pos/outlet-management/{i}', [PosManagementController::class, 'outletManagement'])->name('SA-OutletManagement');

    //===============================================================================================
    // Redemption Shop Tab
    //===============================================================================================   
    Route::get('redemption_shop/dashboard', function(){
        return view('superadmin.redemption_shop');
    })->name('redemption_shop.dashboard');
    
    Route::resource('redemption_shop', RedemptionShopController::class)->names([
        'index' => 'redemption_shop.index',
        'create' => 'redemption_shop.create',
        'store' => 'redemption_shop.store',
        'update' => 'redemption_shop.update',
    ]);

    Route::resource('redemption_product_shop', ProductShopController::class)->names([
        'index' => 'redemption_product_shop.index',
        'create' => 'redemption_product_shop.create',
        'store' => 'redemption_product_shop.store',
    ]);
    Route::post('/redemption_product_shop/update1', [ProductShopController::class, 'update1'])->name('redemption_product_shop.update1');

    Route::resource('sign_in', SignInSettingController::class)->names([
        'index' => 'sign_in.index',
        'create' => 'sign_in.create',
        'store' => 'sign_in.store',
    ]);

    Route::resource('check_in', CheckInSettingController::class)->names([
        'index' => 'check_in.index',
        'create' => 'check_in.create',
        'store' => 'check_in.store',
    ]);

});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('auth/facebook', 'App\Http\Controllers\SocialController@facebookRedirect');
Route::get('auth/facebook/callback', 'App\Http\Controllers\SocialController@loginWithFacebook');
Route::get('index_redirect', 'App\Http\Controllers\SocialController@index_redirect');