<?php

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

// Route::get('/', function () {
//     return view('welcome');
// });

    Auth::routes();

  Route::get('/home', 'HomeController@index')->name('home');

// Auth::routes();
Route::get('/', 'IndexController@index')->name('index');
//tour filter
Route::match(['get','post'],'/tours-filter','TourpackagesController@filter');


//category listing page
Route::get('/tour/{CategoryName}','TourpackagesController@tour');

//tour detail page
Route::get('/tours/{id}','TourpackagesController@tours');

//cart page
Route::match(['get','post'],'/cart', 'TourpackagesController@cart');

//add to cart
Route::match(['get','post'],'/add-cart', 'TourpackagesController@addtocart')->name('add-cart');

//delete tour from wishlist
Route::get('/cart/delete-tourpackage/{id}', 'TourpackagesController@deleteCartPackage');

//TourType Price
Route::get('/get-tourpackage-Price','TourpackagesController@getTourpackagePrice');

 //wishlist page
 Route::match(['get','post'],'/wishlist', 'TourpackagesController@wishlist');

//Apply Coupon
Route::post('/cart/apply-coupon', 'TourpackagesController@applyCoupon');

//feedback
Route::get('/feedback','TourpackagesController@getfeedback');


//delete tour from cart
Route::get('/wishlist/delete-tourpackage/{id}', 'TourpackagesController@deletewishlistPackage');


Route::get('/get-transport-Cost','TourpackagesController@getTransportCost');






Route::get('/login', 'UsersController@ShowLoginForm');
Route::post('/login', 'UsersController@login')->name('login');
Route::get('/logout', 'UsersController@logout');
Route::match(['get','post'],'forgot-password','UsersController@forgotPassword');


Route::get('/register', 'UsersController@showRegistrationForm')->name('register');
Route::post('/register', 'UsersController@register');

//Cornfirm Email account
Route::get('/confirm/{code}', 'UsersController@confirmAccount');
//Search Tour
Route::post('/search-tour', 'TourpackagesController@searchTour');
//check-subscriber-email
Route::post('/check-subscriber-email','NewsletterController@checkSubscriber');
//add-subscriber-email
Route::post('/add-subscriber-email','NewsletterController@addSubscriber');





Route::get('admin/login', 'AdminLoginController@ShowLoginForm');
Route::post('admin/login', 'AdminLoginController@login');
Route::get('admin/logout', 'AdminController@logout');
Route::match(['get','post'],'admin-forgot-password','AdminController@forgotPassword');


Route::group(['prefix' => 'admin', 'middleware' => ['adminlogin']], function() {

    Route::get('/dashboard', 'AdminController@dashboard');
    Route::get('/settings', 'AdminController@settings')->name('admin.settings');
    Route::get('/check-pwd', 'AdminController@chkPassword');
    Route::match(['get','post'],'/update-pwd', 'AdminController@updatePassword');

    Route::get('/view-users-chart', 'UsersController@viewUsersChart');
    //category route
    Route::match(['get','post'],'/add-category', 'TourpackagecategoryController@addCategory')->name('admin.add-category');
    Route::get('/view-categories', 'TourpackagecategoryController@viewCategories');
    Route::match(['get','post'],'/edit-category/{id}', 'TourpackagecategoryController@editCategory')->name('admin.edit-category');
    Route::match(['get','post'],'/delete-category/{id}', 'TourpackagecategoryController@deleteCategory');
    Route::get('/delete-category-image/{id}', 'TourpackagecategoryController@deleteCategoryImage');

    //tour route
    Route::match(['get','post'],'/add-tour', 'TourpackagesController@addtour')->name('admin.add-tour');
    Route::get('/view_tourpackages', 'TourpackagesController@viewTour');
    Route::match(['get','post'],'/edit-tour/{id}', 'TourpackagesController@editTour')->name('admin.edit-tour');
    Route::get('/delete-tour/{id}', 'TourpackagesController@deleteTourpackage');
    Route::get('/delete-tour-image/{id}', 'TourpackagesController@deleteTourImage');

    Route::match(['get','post'],'/add-location/{id}', 'TourpackagesController@location')->name('admin.add-location');

    //tourtype
    Route::match(['get','post'],'/add-tourtype/{id}', 'TourpackagesController@tourtype')->name('admin.add-tourtype');
    Route::match(['get','post'],'/edit-tourtype/{id}', 'TourpackagesController@edittourtype')->name('admin.edit-tourtype');
    Route::get('/delete-tourtype/{id}', 'TourpackagesController@deleteTourtype');
    // Alternative Image
    Route::match(['get','post'],'/add-image/{id}', 'TourpackagesController@image')->name('admin.add-image');
    Route::get('/delete-alt-image/{id}', 'TourpackagesController@deleteAltimage');

    //tour-include
    Route::match(['get','post'],'/add-include/{id}', 'TourpackagesController@tourinclude')->name('admin.add-include');
    Route::get('/delete-tourinclude/{id}', 'TourpackagesController@deleteTourinclude');

    //tour transport
    Route::match(['get','post'],'/add-tourtransportation/{id}', 'TourpackagesController@transport')->name('admin.add-tourtransportation');
    Route::match(['get','post'],'/edit-tourtransportation/{id}', 'TourpackagesController@edittransport')->name('admin.edit-tourtransportation');
    Route::get('/delete-transport/{id}', 'TourpackagesController@deleteTransport');

    //tour accommodation
    Route::match(['get','post'],'/add-accommodation/{id}', 'TourpackagesController@accommodation')->name('admin.add-accommodation');
    Route::get('/delete-accommodation/{id}', 'TourpackagesController@deleteAccommodation');

    //coupon forms
    Route::match(['get','post'],'/add-coupon', 'CouponsController@addCoupon')->name('admin.add-coupon');
    Route::match(['get','post'],'/edit-coupon/{id}', 'CouponsController@editCoupon')->name('admin.edit-coupon');
    Route::get('/view-coupons','CouponsController@viewCoupons');
    Route::get('/delete-coupon/{id}', 'CouponsController@deleteCoupon');

    //banner route
    Route::match(['get','post'],'/add-banner', 'BannerController@addbanner')->name('admin.add-banner');
    Route::match(['get','post'],'/edit-banner/{id}', 'BannerController@editbanner')->name('admin.edit-banner');
    Route::get('/view-banners','BannerController@viewbanners');
    Route::get('/delete-banner/{id}', 'BannerController@deletebanner');

    //Admin Bookings Route
    Route::get('/view-bookings', 'TourpackagesController@viewBookings');
    //Admin Order Booking Detail Route
    Route::get('/view-bookings/{id}', 'TourpackagesController@viewBookingDetails');

    //Booking Invoice
    Route::get('/view-invoice/{id}', 'TourpackagesController@viewBookingInvoice');
    //Booking Invoice
    Route::get('/view-pdf/{id}', 'TourpackagesController@viewPDFInvoice');
    //Update Booking Status
    Route::post('/update-booking-status','TourpackagesController@updateBookingStatus');

    //Admin Users Route
    Route::get('/view-users', 'UsersController@viewUsers');
    //Users chart
    Route::get('/view-users-chart', 'UsersController@viewUsersChart');
    //Booking chart
    Route::get('/view-bookings-chart', 'TourpackagesController@viewBookingsChart');
    //Booking chart
    Route::get('/view-users-countries-chart', 'UsersController@viewUsersCountriesChart');
    //Admin/Sub-Admins Route
    Route::get('/view-admins', 'AdminController@viewAdmins');
    //add Admin/Sub-Admins Route
    Route::match(['get','post'], '/add-admin', 'AdminController@addAdmin')->name('admin.add-admin');
    //edit Admin/Sub-Admins Route
    Route::match(['get','post'], '/edit-admin/{id}', 'AdminController@editAdmin');
    //Add CMS Pages
    Route::match(['get','post'], '/add-cms-page', 'CmsController@addCsmPage')->name('admin.add-cms-page');
    //View CSM Pages
    Route::get('/view-cms-pages','CmsController@viewCsmPages');

    //Details
    Route::match(['get','post'],'/detail-cms/{id}', 'CmsController@detailsCsmPages')->name('admin.detail-cmspage');
    //Edit CMS Page
    Route::match(['get','post'],'/edit-cms/{id}', 'CmsController@EditCsmPages')->name('admin.edit-cms');
    //Delete Csm Pages
    Route::get('/delete-cms-page/{id}', 'CmsController@deleteCmsPage');
    // Get Enquiries
    Route::get('/get-enquiries','CmsController@getEnquiries');
    // Get contact
    Route::get('/get-contact','CmsController@getContact');
    Route::get('/delete-contact/{id}', 'CmsController@deleteContact');

	// View Enquiries
	Route::get('/view-enquiries','CmsController@viewEnquiries');

    //currency route
    //add currency
    Route::match(['get','post'],'add-currency', 'CurrencyController@addCurrency')->name('admin.add-currency');
    //Edit currency
    Route::match(['get','post'],'edit-currency/{id}', 'CurrencyController@editCurrency')->name('admin.edit-currency');
    //view currency
    Route::get('view-currencies','CurrencyController@viewCurrency');

    //Delete Route

    Route::get('/delete-currency/{id}', 'CurrencyController@deleteCurrency');

    //view NewsletterSubscriber
    Route::get('/view-newsletter-subscribers','NewsletterController@viewSubscriber');
    //Update Newsletter StatusSubscriber
    Route::get('/update-newsletter-status/{id}/{Status}','NewsletterController@updateNewsletterStatus');
    //Delete Newsletter Email
    Route::get('/delete-newsletter-email/{id}', 'NewsletterController@deleteNewsletterEmail');


    //Export Newsletter Emails
    Route::get('/export-newsletter-email','NewsletterController@exportNewsletterEmails');
    //Export Users
    Route::get('/export-users','UsersController@exportUsers');
    Route::get('/export-tourpackages','TourpackagesController@exportTourpackages');

    //view feedbacks
    Route::get('/view-feedbacks', 'FeedbackController@viewFeedback');
    //Update Feedback Status
    Route::get('/update-feedback/{id}/{Status}','FeedbackController@updateFeedbackStatus');
    //Delete Feedback
    Route::get('/delete-feedback/{id}', 'FeedbackController@deleteFeedback');
});




//Route::get('/register', 'UserController@createrUser');

Route::group(['middleware' => ['frontlogin']], function() {
    Route::match(['get','post'],'/account', 'UsersController@account');
    Route::post('/check-user-pwd', 'UsersController@chkUserPassword');
    Route::post('/update-user-pwd', 'UsersController@updatePassword');
    //checkout page
    Route::match(['get','post'],'/billing', 'TourpackagesController@billing');
    //tour Review Page
    Route::match(['get','post'],'/tour-review','TourpackagesController@tourReview');
    //Place Package
    Route::match(['get','post'],'/place-package','TourpackagesController@placePackage');
    //Thanks Page
    Route::get('/thanks', 'TourpackagesController@thanks');
    //ipay routes
    Route::get('/ipay','TourpackagesController@ipay');
    //flutter routes
    Route::get('/flutterwave','TourpackagesController@flutterwave');
    //ipay return thanks page
    Route::get('/ipay/thanks','TourpackagesController@ipaythanks');
    //ipay cancel page
    Route::get('/ipay/cancel','TourpackagesController@ipayCancel');
    //flutterwave return thanks page
    Route::get('/flutterwave/thanks','TourpackagesController@flutterwavethanks');
    //User Bookings Page
    Route::get('/Bookings', 'TourpackagesController@userBookings');
    //User Booked Package Page
    Route::get('/Bookings/{id}', 'TourpackagesController@userBookingDetails');
    //Feedback Route
    Route::match(['get','post'], '/feedback', 'FeedbackController@feedback');

});
//Auth::routes();

//display Contact Page
Route::match(['get','post'],'/page/contact', 'CmsController@contact');

// Display Post Page (for Vue.js)
Route::match(['get','post'],'/page/post','CmsController@addPost');

//Display Cms Pages
Route::match(['get','post'],'/page/{URL}','CmsController@cmsPage');




//Auth::routes();

//Route::get('/home', 'HomeController@index')->name('home');
