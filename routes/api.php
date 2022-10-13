<?php

use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });
Route::get('/get_version', function () {
    // return env('App_version', 'Please define App Version');
   return  config('services.App_version');
});

Route::get('get_invoice_details/{id}', 'App\Http\Controllers\PlansController@get_invoice_details');
//Route::post('/blog-create-post', 'App\Http\Controllers\PostController@store');
//Route::resource('/blog', PostsController::class);
Route::resource('amenities', 'App\Http\Controllers\Api\AmenitieController');
Route::get('getheading_data', 'App\Http\Controllers\Api\ListingPageContentController@getheading_data');
Route::get('getoffer_banner_web', 'App\Http\Controllers\Api\OfferBannerController@getoffer_banner_web');
Route::get('getarea_unit', 'App\Http\Controllers\Api\AreaUnitController@index');
Route::get('get_dropdown_data', 'App\Http\Controllers\Api\Authicationcheck@get_dropdown_data');
Route::post('user_feedback_store', 'App\Http\Controllers\Api\UserVisitFeedbackController@store');
Route::post('user_feedback_details', 'App\Http\Controllers\Api\UserVisitFeedbackController@user_feedback_details');
Route::resource('property_type', 'App\Http\Controllers\Api\PropertyTypeController');
Route::post('contact-form', 'App\Http\Controllers\ContactController@store');
Route::get('/user_fetch_details', 'App\Http\Controllers\Api\AuthController@user_fetch_details');

Route::get('/get_proeprty_id', 'App\Http\Controllers\Api\ProductController@get_proeprty_id');

Route::get('/get_porperty_byid', 'App\Http\Controllers\Api\ProductController@get_property_byid');
Route::get('/get_crm_property', 'App\Http\Controllers\Api\ProductController@get_crm_property');

Route::get('/crm_search_locality', 'App\Http\Controllers\Api\AreaLocalityController@crm_search_locality');

Route::get('/crm_locality_id', 'App\Http\Controllers\Api\AreaLocalityController@crm_locality_id');

Route::get('/crm_sub_localityby_localityid', 'App\Http\Controllers\Api\AreaSubLocalityController@crm_sub_localityby_localityid');

 Route::get('crm_property_rent_slip', 'App\Http\Controllers\Api\ProductController@crm_property_rent_slip');

Route::post('/invoice_status_change', 'App\Http\Controllers\PlansController@invoice_status_change');
Route::post('/property_price_change', 'App\Http\Controllers\PlansController@property_price_change');
Route::post('/rollback_property', 'App\Http\Controllers\PlansController@rollback_property');
Route::post('/payment_forfeited', 'App\Http\Controllers\PlansController@payment_forfeited');
Route::get('rent_property_slip', 'App\Http\Controllers\PlansController@rent_property_slip');
Route::get('crm_getinvoiceById', 'App\Http\Controllers\PlansController@crm_get_invoice_details');


Route::post('property_live_bycrm', 'App\Http\Controllers\PlansController@property_live_bycrm');
Route::post('purchasedplan_propertylive', 'App\Http\Controllers\PlansController@purchasedplan_propertylive');

Route::get('/get_plan_by_user', 'App\Http\Controllers\PlansController@get_plan_by_user');
Route::post('/store_property_image', 'App\Http\Controllers\Api\ProductImgController@store');
Route::get('/delete_property_img', 'App\Http\Controllers\Api\ProductImgController@delete_product_img_crm');
Route::get('/get_all_property_userDetails', 'App\Http\Controllers\Api\ProductController@get_all_property_userDetails');
Route::post('/create_product_rent', 'App\Http\Controllers\Api\ProductController@crm_create_product_rent');
Route::post('/update_product_rent', 'App\Http\Controllers\Api\ProductController@crm_update_product_rent');																			
Route::post('wishlist_crm', 'App\Http\Controllers\Api\WishlistController@Crm_store');
Route::get('get_wishlist_userid', 'App\Http\Controllers\Api\WishlistController@get_wishlist_userid');	
Route::get('get_pro_img_byid', 'App\Http\Controllers\Api\ProductImgController@get_pro_img_byid');   																		
Route::post('wishlist_delete_crm', 'App\Http\Controllers\Api\WishlistController@crm_delete');
Route::middleware('auth:api')->post('posts', 'App\Http\Controllers\PostController@store');
Route::get('posts', 'App\Http\Controllers\PostController@index');
Route::get('posts_latest', 'App\Http\Controllers\PostController@index_latest');

Route::get('posts/{post}', 'App\Http\Controllers\PostController@show');
Route::middleware('auth:api')->post('posts/update/{slug}', 'App\Http\Controllers\PostController@update');
Route::middleware('auth:api')->post('posts/delete/{slug}', 'App\Http\Controllers\PostController@destroy');

Route::get('get_enabled_rent_plans', 'App\Http\Controllers\PlansController@get_enabled_rent_plans');																									
Route::get('get_all_rent_plans', 'App\Http\Controllers\PlansController@get_all_rent_plans');
Route::get('get_enabled_letout_plans', 'App\Http\Controllers\PlansController@get_enabled_letout_plans');
Route::get('get_all_letout_plans', 'App\Http\Controllers\PlansController@get_all_letout_plans');
Route::get('getLetOutPlans_Features', 'App\Http\Controllers\PlansController@getLetOutPlans_Features');
Route::get('get_rent_features', 'App\Http\Controllers\PlansController@get_rent_features');
Route::get('get_letout_features', 'App\Http\Controllers\PlansController@get_letout_features');
Route::post('update_property_plans', 'App\Http\Controllers\PlansController@update_property_plans');
Route::post('add_property_plan', 'App\Http\Controllers\PlansController@add_property_plan');
Route::get('get_all_features', 'App\Http\Controllers\PlansController@get_all_features');	
Route::post('get_plan_features', 'App\Http\Controllers\PlansController@get_plan_features');																							 
Route::post('get_product_details', 'App\Http\Controllers\Api\ProductController@get_product_details');

Route::get('check_email/{email}', 'App\Http\Controllers\Api\AuthController@check_email');
Route::post('reset_password_send_otp', 'App\Http\Controllers\Api\AuthController@reset_password_send_otp');
Route::post('reset_password_verify_otp', 'App\Http\Controllers\Api\AuthController@reset_password_verify_otp');
Route::post('reset_password', 'App\Http\Controllers\Api\AuthController@reset_password');
Route::post('reset_send_otp_email', 'App\Http\Controllers\Api\AuthController@reset_send_otp_email');
Route::post('rp_verify_otp_email', 'App\Http\Controllers\Api\AuthController@rp_verify_otp_email');
Route::get('get_invoice_data', 'App\Http\Controllers\Api\AuthController@get_invoice_data');
Route::get('get_username/{email}', 'App\Http\Controllers\Api\AuthController@get_username');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('/mobile_otp_send', 'App\Http\Controllers\Api\AuthController@mobile_otp_send');
    Route::post('/user_otp_resend_login', 'App\Http\Controllers\Api\AuthController@user_otp_resend_login');

    Route::post('mobile_login_verify_otp', 'App\Http\Controllers\Api\AuthController@mobile_login_verify_otp');
    Route::post('sign_up_otp_send', 'App\Http\Controllers\Api\SignUpController@sign_up_otp_send');
    Route::post('user_otp_resend', 'App\Http\Controllers\Api\SignUpController@user_otp_resend');
    Route::post('sign_up_verify_otp', 'App\Http\Controllers\Api\SignUpController@sign_up_verify_otp');
    Route::get('/sign_up_user_details', 'App\Http\Controllers\Api\SignUpController@sign_up_user_details');

	Route::post('admin_login', 'App\Http\Controllers\Api\AdminControllerNew@admin_login');
	Route::get('/get_user_permissions/{id}', 'App\Http\Controllers\Api\AdminControllerNew@get_user_permissions');																											 
    Route::post('user_logs','App\Http\Controllers\Api\UserLogsController@store');
    Route::post('/user_signup', 'App\Http\Controllers\Api\AuthController@user_signup');
																								  
    Route::post('/user_signup_new', 'App\Http\Controllers\Api\AuthController@user_signup_new');                               
	Route::post('/internal_user_signup', 'App\Http\Controllers\Api\AuthController@internal_user_signup');																								  
    Route::get('/get_product_featured', 'App\Http\Controllers\Api\ProductController@index_featured');

	Route::post('/create_role', 'App\Http\Controllers\Api\AuthController@create_user_role');
	Route::post('/get_access_rights', 'App\Http\Controllers\Api\AuthController@get_access_rights');
    Route::get('/get_roles', 'App\Http\Controllers\Api\AuthController@get_roles');
    Route::get('/role/{id}', 'App\Http\Controllers\Api\AuthController@get_role_details');
    Route::post('roles/update/{id}', 'App\Http\Controllers\Api\AuthController@update_role');
    Route::delete('roles/delete/{id}', 'App\Http\Controllers\Api\AuthController@delete_role');

    Route::get('/get_areas', 'App\Http\Controllers\Api\AuthController@get_areas');
    Route::get('/get_locality', 'App\Http\Controllers\Api\AreaLocalityController@index');
    Route::get('/get_sub_locality', 'App\Http\Controllers\Api\AreaSubLocalityController@sub_localitybyid');
    Route::post('/sub_locality_byid', 'App\Http\Controllers\Api\AreaSubLocalityController@sub_locality_byid');
    Route::get('/get_common_area_data/{value}', 'App\Http\Controllers\Api\AreaSubLocalityController@get_common_area_data');
    Route::get('/get_internal_user_locality/{value}', 'App\Http\Controllers\Api\AreaSubLocalityController@get_internal_user_locality');
    
    Route::get('/search_locality/{value}', 'App\Http\Controllers\Api\AreaLocalityController@search_locality');


    Route::get('/get_state', 'App\Http\Controllers\Api\AreaStateController@index');
    Route::get('/get_district_byid', 'App\Http\Controllers\Api\AreaDistrictController@get_district_byid');
    Route::get('/get_locality_byid', 'App\Http\Controllers\Api\AreaLocalityController@get_locality_byid');

    Route::post('/owner_signup', 'App\Http\Controllers\Api\AuthController@owner_signup');
    Route::post('/dealer_signup', 'App\Http\Controllers\Api\AuthController@dealer_company_signup');
    Route::post('/lawyer_signup', 'App\Http\Controllers\Api\AuthController@lawyer_signup');

    Route::post('/crm_api_call', 'App\Http\Controllers\Api\AuthController@crm_api_call');
    Route::post('/crm_call_appionment', 'App\Http\Controllers\Api\AuthController@crm_call_appointment');

    Route::post('/verify', 'App\Http\Controllers\Api\AuthController@verify');	
    Route::post('/verify_profile_mob', 'App\Http\Controllers\Api\AuthController@verify_profile_mob');
    Route::post('/bank_verify_mobile', 'App\Http\Controllers\Api\AuthController@bank_verify_mobile');
    Route::post('/bank_verify_OTP', 'App\Http\Controllers\Api\AuthController@bank_verify_OTP');																			 
    Route::post('/reverify', 'App\Http\Controllers\Api\AuthController@reverify');
    Route::post('/forgot_password', 'App\Http\Controllers\Api\AuthController@forgot_password');

    Route::group([
        'middleware' => 'web'
    ], function () {
        Route::get('/redirect', 'App\Http\Controllers\Api\AuthController@googleredirect');
        Route::get('/callback', 'App\Http\Controllers\Api\AuthController@googlecallback');
    });

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::get('/logout', 'App\Http\Controllers\Api\AuthController@logout');
        Route::get('/user', 'App\Http\Controllers\Api\AuthController@user');
        Route::get('/user_block_status', 'App\Http\Controllers\Api\AuthController@user_block_status');
        Route::get('/verify_user', 'App\Http\Controllers\Api\AuthController@verify_user');
		Route::get('/verify_user_mobile', 'App\Http\Controllers\Api\AuthController@verify_user_mobile');
        Route::post('/verify_mobile', 'App\Http\Controllers\Api\AuthController@verify_mobile_number');
       Route::post('/verify_mob', 'App\Http\Controllers\Api\AuthController@verify_mob');																								
		Route::post('/upload_profile_pic', 'App\Http\Controllers\Api\AuthController@upload_profile_pic');																														
        Route::post('/change_password', 'App\Http\Controllers\Api\AuthController@change_password');
        
        Route::post('payment','App\Http\Controllers\Api\PaymentController@payment')->name('payment.payment');
        Route::get('plans_payment/{id}','App\Http\Controllers\Api\PaymentController@plans_payment');
        Route::get('plans_rent_payment/{id}','App\Http\Controllers\Api\PaymentController@plans_rent_payment');
        Route::get('remaing_plans_rent_payment/{id}','App\Http\Controllers\Api\PaymentController@remaing_plans_rent_payment');
        
        Route::post('post_selected_plan','App\Http\Controllers\PlansController@post_selected_plan');
        Route::post('store_fixed_appointment','App\Http\Controllers\Api\FixedAppointmentController@store');
        Route::post('post_selected_rent_plan','App\Http\Controllers\PlansController@post_selected_rent_plan');
        Route::get('get_order_details/{id}', 'App\Http\Controllers\PlansController@get_order_details');
        Route::get('user_plan_availability', 'App\Http\Controllers\PlansController@user_plan_availability');
        Route::get('get_rent_order_details/{id}', 'App\Http\Controllers\PlansController@get_rent_order_details');
        Route::get('get_invoice_details/{id}', 'App\Http\Controllers\PlansController@get_invoice_details');
        Route::get('product_invoice_Details', 'App\Http\Controllers\PlansController@product_invoice_Details');
        Route::get('get_user_invoices/{id}', 'App\Http\Controllers\PlansController@get_user_invoices');
        Route::get('get_all_user_invoices/{id}', 'App\Http\Controllers\PlansController@get_all_user_invoices');
        Route::get('get_rented_properties/{id}', 'App\Http\Controllers\PlansController@get_rented_properties');

        Route::get('get_property_payment/{id}', 'App\Http\Controllers\API\AdminPaymentSummeryController@get_property_payment');
        Route::get('user_paymentfail/', 'App\Http\Controllers\PlansController@user_paymentfail');
        
        Route::get('get_property_details/{id}', 'App\Http\Controllers\PlansController@get_property_details');
        Route::get('update_property_details/{id}', 'App\Http\Controllers\PlansController@update_property_details');
        Route::get('update_invoice_details', 'App\Http\Controllers\PlansController@update_invoice_details');

        
        Route::get('get_credit_details/{id}', 'App\Http\Controllers\PlansController@get_credit_details');
        Route::get('get_total_credit/{id}', 'App\Http\Controllers\PlansController@get_total_credit');
        
        
        Route::post('generate_invoice', 'App\Http\Controllers\PlansController@generate_invoice');
        Route::post('generate_rent_invoice', 'App\Http\Controllers\PlansController@generate_rent_invoice');
        Route::get('get_all_internal_users', 'App\Http\Controllers\Api\AuthController@get_all_internal_users');
        Route::get('get_internal_user_details/{id}', 'App\Http\Controllers\Api\AuthController@get_internal_user_details');
        Route::get('get_user_roles/{id}', 'App\Http\Controllers\Api\RolesPermissionsController@get_user_roles');
        Route::post('edit_user_roles', 'App\Http\Controllers\Api\RolesPermissionsController@edit_user_roles');
        Route::get('delete_internal_user/{id}', 'App\Http\Controllers\Api\AuthController@delete_internal_user');
       
    });
    // Route::get('/home', 'App\Http\Controllers\Api\HomeController@index')->name('home');
});
Route::post('post-payment','App\Http\Controllers\Api\PaymentController@postPayment')->name('post.payment');
Route::post('plans-post-payment','App\Http\Controllers\Api\PaymentController@PlansPostPayment');
Route::post('plans-rent-post-payment','App\Http\Controllers\Api\PaymentController@PlansRentPostPayment');
Route::post('plans-rent-remaining-payment','App\Http\Controllers\Api\PaymentController@PlansRentPostPaymentRemaining');

Route::get('/get_permissions', 'App\Http\Controllers\Api\RolesPermissionsController@get_permissions');
Route::post('/create_role', 'App\Http\Controllers\Api\RolesPermissionsController@create_role');
Route::get('/get_roles', 'App\Http\Controllers\Api\RolesPermissionsController@get_roles');
Route::post('/get_role_permissions', 'App\Http\Controllers\Api\RolesPermissionsController@get_role_permissions');
Route::post('/edit_role', 'App\Http\Controllers\Api\RolesPermissionsController@edit_role');
Route::post('/delete_role', 'App\Http\Controllers\Api\RolesPermissionsController@delete_role');

Route::group([
    'prefix' => 'product'
], function () {
    Route::get('/feature_property', 'App\Http\Controllers\Api\ProductController@feature_property');
    Route::get('/getRecently_viewProperty', 'App\Http\Controllers\Api\ProductController@Recently_view');
    Route::get('/get_product', 'App\Http\Controllers\Api\ProductController@product_city_details');
     Route::get('/property_category', 'App\Http\Controllers\Api\ProductController@product_category_details');

     Route::get('/web_dropdown_data', 'App\Http\Controllers\Api\ProductController@web_dropdown_data');
    Route::get('/get_product_featured', 'App\Http\Controllers\Api\ProductController@index_featured');
    Route::get('/product_list_featured', 'App\Http\Controllers\Api\ProductController@product_list_featured');
    Route::get('/seeto', 'App\Http\Controllers\Api\ProductController@product_index');
    Route::post('/see', 'App\Http\Controllers\Api\ProductController@search_prod_by_id');
    Route::post('/similarproperty', 'App\Http\Controllers\Api\ProductController@search_prod_by_city');
    Route::post('/search', 'App\Http\Controllers\Api\ProductController@search_func');
    Route::post('/city_search', 'App\Http\Controllers\Api\ProductController@city_search_func');
    Route::post('/req_index', 'App\Http\Controllers\Api\RequirementController@reqHandler');
    Route::get('/agent_properties', 'App\Http\Controllers\Api\ProductController@agent_properties');

    Route::get('/getlocalArea', 'App\Http\Controllers\Api\LocalareaController@index');
    Route::get('/get_localareaby_id', 'App\Http\Controllers\Api\LocalareaController@get_localareaby_id');
    Route::get('/getarea_service', 'App\Http\Controllers\Api\AreaServiceController@index');
    Route::get('/getarea_service_userpage', 'App\Http\Controllers\Api\AreaServiceController@getarea_service_userpage');
    Route::get('/delete_service', 'App\Http\Controllers\Api\AreaServiceController@delete'); 
    Route::get('/get_service_id', 'App\Http\Controllers\Api\AreaServiceController@get_service_By_id');
    Route::get('/update_service_id', 'App\Http\Controllers\Api\AreaServiceController@update_service_id');
    Route::post('/service_update', 'App\Http\Controllers\Api\AreaServiceController@service_update');
    
    Route::get('/service_user_list', 'App\Http\Controllers\Api\ServiceUserlistController@show');
    Route::get('/delete_service_user', 'App\Http\Controllers\Api\ServiceUserlistController@delete'); 
    Route::get('/sevice_user_get_id', 'App\Http\Controllers\Api\ServiceUserlistController@sevice_user_get_id');
    Route::get('/update_sevice_user_get_id', 'App\Http\Controllers\Api\ServiceUserlistController@update_service_userById');   
    Route::get('/local_service', 'App\Http\Controllers\Api\UserServiceMappingController@search_data'); 

    Route::get('/lawyer_service_index', 'App\Http\Controllers\Api\LawyerController@lawyer_index');
    Route::post('/lawyer_page', 'App\Http\Controllers\Api\LawyerController@lawyer_check');

    Route::post('/product_review', 'App\Http\Controllers\Api\GuestUserFeedbackController@product_review');

    Route::post('/search_pro_type', 'App\Http\Controllers\Api\ProductController@search_pro_type');
    
    Route::post('/productsearching', 'App\Http\Controllers\Api\ProductController@propertysearch_list');
    Route::get('/testimonial', 'App\Http\Controllers\Api\GuestUserFeedbackController@testimonial');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/product_rent_update', 'App\Http\Controllers\Api\ProductController@product_rent_update');
    Route::get('property_rent_slip', 'App\Http\Controllers\Api\ProductController@property_rent_slip');
        Route::post('/product_sales_update', 'App\Http\Controllers\Api\ProductController@update_Sales_product');

        Route::post('/city_search_login', 'App\Http\Controllers\Api\ProductController@city_search_login_uesr');
        Route::post('/loginsimilarproperty', 'App\Http\Controllers\Api\ProductController@loginSimilarproperty');
        Route::post('/requ', 'App\Http\Controllers\Api\RequirementController@create');
        
        Route::post('/post_review', 'App\Http\Controllers\Api\GuestUserFeedbackController@store');
        Route::post('/Login_search_home', 'App\Http\Controllers\Api\ProductController@Login_search_home');
        Route::post('/search_pro_type_login', 'App\Http\Controllers\Api\ProductController@search_pro_type_login');
       Route::post('/check_order_product', 'App\Http\Controllers\Api\ProductOrderController@check_order_product');

        Route::get('/get_requ', 'App\Http\Controllers\Api\RequirementController@index');
        Route::get('/requ_display', 'App\Http\Controllers\Api\RequirementController@display');
        Route::post('/requirement_delete', 'App\Http\Controllers\Api\RequirementController@delete');

        // Route::post('/save_search', 'App\Http\Controllers\Api\SavedsearchesController@store');
        // Route::get('/get_search', 'App\Http\Controllers\Api\SavedsearchesController@index');
        Route::post('/update_product', 'App\Http\Controllers\Api\ProductController@update_product');

        Route::get('/views', 'App\Http\Controllers\Api\ProductController@dashboard_indexer');

        Route::post('/delete_product', 'App\Http\Controllers\Api\ProductController@delete_product');

        Route::post('/delete_video', 'App\Http\Controllers\Api\ProductController@delete_video');

         Route::post('/delete_pro_img', 'App\Http\Controllers\Api\ProductImgController@delete_pro_img');
        Route::get('/agent_properties', 'App\Http\Controllers\Api\ProductController@agent_properties');
        Route::get('/draft_properties', 'App\Http\Controllers\Api\ProductController@Draft_properties');

        Route::post('/insert_product_sale', 'App\Http\Controllers\Api\ProductController@first');
        Route::post('/insert_product_rent', 'App\Http\Controllers\Api\ProductController@insert_product_rent');


        Route::post('/lawyer_create_service', 'App\Http\Controllers\Api\LawyerController@lawyer_create_service');
        Route::get('/lawyer_service', 'App\Http\Controllers\Api\LawyerController@lawyer_service');
        Route::post('/lawyer_service_delete', 'App\Http\Controllers\Api\LawyerController@lawyer_service_delete');
        Route::post('/product_searching_login', 'App\Http\Controllers\Api\ProductController@User_propertysearchlist');
        Route::post('/property_get_id', 'App\Http\Controllers\Api\ProductController@property_get_id');
        Route::get('get_product_wishlist', 'App\Http\Controllers\Api\ProductController@index_featured_wishlist');
        Route::get('/product_listing_wishlist', 'App\Http\Controllers\Api\ProductController@product_listing_wishlist');

        Route::resource('wishlist', 'App\Http\Controllers\Api\WishlistController');
        Route::post('wishlistdelete', 'App\Http\Controllers\Api\WishlistController@delete');
       
         Route::resource('product_comp', 'App\Http\Controllers\Api\ProductComparisionController');
        Route::post('pro_comp_delete', 'App\Http\Controllers\Api\ProductComparisionController@delete');
        Route::post('product_comp_mobile', 'App\Http\Controllers\Api\ProductComparisionController@product_comp_mobile_store');
        Route::get('get_mobile_comp', 'App\Http\Controllers\Api\ProductComparisionController@get_mobile_comp');

         Route::post('recently_product_user', 'App\Http\Controllers\Api\UserProductCountController@count_byID');
       
        Route::get('user_recently_pro', 'App\Http\Controllers\Api\UserProductCountController@index');

        Route::post('/product_login_see', 'App\Http\Controllers\Api\ProductController@product_login_see');
        Route::post('/property_notes_update', 'App\Http\Controllers\Api\ProductController@property_notes_update');
       Route::get('/solid_properties', 'App\Http\Controllers\Api\ProductOrderController@solid_properties');
       Route::get('/purchased_properties', 'App\Http\Controllers\Api\ProductOrderController@purchase_properties');
       Route::get('/user_order_product', 'App\Http\Controllers\Api\ProductOrderController@property_all_orders');

        Route::post('/service_user_reviews', 'App\Http\Controllers\Api\BackendReviewsUserController@store');
        Route::post('/service_created', 'App\Http\Controllers\Api\AreaServiceController@store');
        
        Route::post('/service_user_create', 'App\Http\Controllers\Api\ServiceUserlistController@store');
        Route::post('/service_user_update', 'App\Http\Controllers\Api\ServiceUserlistController@service_user_update');
        Route::get('/getarea_user_details', 'App\Http\Controllers\Api\ServiceUserlistController@user_details_byId');
        Route::get('/getservice_user', 'App\Http\Controllers\Api\ServiceUserlistController@index');
        
        Route::get('/star_ratingbyId', 'App\Http\Controllers\Api\ServiceUserlistController@star_ratingbyId');
    });
    // Route::get('/home', 'App\Http\Controllers\Api\HomeController@index')->name('home');
});

Route::group([
    'prefix' => 'admin'
], function () {
    Route::post('/admin_login', 'App\Http\Controllers\Api\AuthController@admin_login');
    Route::post('/admin_signup', 'App\Http\Controllers\Api\AuthController@admin_signup');
    Route::post('/company_signup', 'App\Http\Controllers\Api\AuthController@company_signup');
    Route::post('/admin_userfind', 'App\Http\Controllers\Api\AdminController@user_update');
    Route::get('/loan_index', 'App\Http\Controllers\Api\LoansController@index');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/delete_product_admin', 'App\Http\Controllers\Api\AdminController@delete_product');

        Route::post('/admin_payment_user_create', 'App\Http\Controllers\Api\AdminPaymentSummeryController@store');
        Route::post('/admin_payment_user_update', 'App\Http\Controllers\Api\AdminPaymentSummeryController@payment_status_update');
        Route::post('/user_page', 'App\Http\Controllers\Api\AdminController@user_check');
        Route::post('/user_update', 'App\Http\Controllers\Api\AdminController@user_update');
        Route::post('/user_update_new', 'App\Http\Controllers\Api\AdminController@user_update_new');
		Route::post('/profile_username_update', 'App\Http\Controllers\Api\AdminController@profile_username_update');
        Route::post('/profile_mobile_update', 'App\Http\Controllers\Api\AdminController@profile_mobile_update');
        Route::post('/admin_loans', 'App\Http\Controllers\Api\LoansController@first');
        Route::post('/loan_delete', 'App\Http\Controllers\Api\LoansController@loan_delete');
        Route::get('/user_index', 'App\Http\Controllers\Api\AdminController@user_index_admin');
        Route::get('/event_index', 'App\Http\Controllers\Api\EventtrackerController@index');
        Route::get('/product_index', 'App\Http\Controllers\Api\AdminController@product_index_admin');
        Route::get('/product_views', 'App\Http\Controllers\Api\AdminController@product_views');
        Route::get('/review_count', 'App\Http\Controllers\Api\AdminController@review_count');
        Route::get('/product_update_admin', 'App\Http\Controllers\Api\AdminController@product_update');

         Route::get('/get_userlist_byinternal', 'App\Http\Controllers\Api\AuthController@get_userlist_byinternal');
    Route::post('/create_user_byinternal', 'App\Http\Controllers\Api\AuthController@create_user_byinternal');
    Route::post('/banner_created', 'App\Http\Controllers\Api\OfferBannerController@create');
    Route::post('/listing_page_heading_create', 'App\Http\Controllers\Api\ListingPageContentController@create');

// state functionalty
    Route::get('/get_state_data', 'App\Http\Controllers\Api\AreaStateController@index');
    Route::get('/get_state', 'App\Http\Controllers\Api\AreaStateController@get_state');
    Route::post('/state_status_changes', 'App\Http\Controllers\Api\AreaStateController@state_status_changes');
    Route::post('/state_create', 'App\Http\Controllers\Api\AreaStateController@create');
    Route::post('/state_update', 'App\Http\Controllers\Api\AreaStateController@state_update');
    Route::get('/delete_area', 'App\Http\Controllers\Api\AreaStateController@delete');

    // district functionalty
    Route::post('/district_create', 'App\Http\Controllers\Api\AreaDistrictController@create');
     Route::post('/get_district_byid', 'App\Http\Controllers\Api\AreaDistrictController@search_district_id');
     Route::post('/district_update', 'App\Http\Controllers\Api\AreaDistrictController@district_update');
      Route::post('/district_status_changes', 'App\Http\Controllers\Api\AreaDistrictController@district_status_changes');
    Route::get('/delete_district', 'App\Http\Controllers\Api\AreaDistrictController@delete');
       Route::post('/search_district', 'App\Http\Controllers\Api\AreaDistrictController@search_district');
    // locality functionalty
     Route::post('/locality_create', 'App\Http\Controllers\Api\AreaLocalityController@create');
      Route::post('/get_locality_byid', 'App\Http\Controllers\Api\AreaLocalityController@search_locality_id');
      Route::post('/locality_status_changes', 'App\Http\Controllers\Api\AreaLocalityController@locality_status_changes');
      
    Route::get('/edit_locality_id', 'App\Http\Controllers\Api\AreaLocalityController@edit_locality_id');
     Route::post('/locality_update', 'App\Http\Controllers\Api\AreaLocalityController@locality_update');
     Route::get('/delete_locality', 'App\Http\Controllers\Api\AreaLocalityController@delete');
      Route::post('/search_locality', 'App\Http\Controllers\Api\AreaLocalityController@search_locality1');
      Route::post('/get_locality_searching', 'App\Http\Controllers\Api\AreaLocalityController@get_locality_searching');
     // sub locality functionalty
     Route::post('/sub_locality_create', 'App\Http\Controllers\Api\AreaSubLocalityController@create');
     Route::post('/get_sub_locality_searching', 'App\Http\Controllers\Api\AreaSubLocalityController@get_sub_locality_searching');
      Route::post('/get_sub_locality_byid', 'App\Http\Controllers\Api\AreaSubLocalityController@search_sub_locality_id');
      Route::post('/sub_locality_status_changes', 'App\Http\Controllers\Api\AreaSubLocalityController@sub_locality_status_changes');
       Route::get('/delete_sub_locality', 'App\Http\Controllers\Api\AreaSubLocalityController@delete');
     Route::post('/sub_locality_update', 'App\Http\Controllers\Api\AreaSubLocalityController@sub_locality_update');
    Route::get('/edit_sub_locality_id', 'App\Http\Controllers\Api\AreaSubLocalityController@edit_sub_locality_id');
// area group functionalty

     Route::post('/area_group_create', 'App\Http\Controllers\Api\AreaGroupController@create');
     Route::post('/area_group_update', 'App\Http\Controllers\Api\AreaGroupController@area_group_update');
     Route::get('/get_group_list', 'App\Http\Controllers\Api\AreaGroupController@index');
    Route::get('/delete_group', 'App\Http\Controllers\Api\AreaGroupController@delete'); 
    Route::get('/get_group_details_id', 'App\Http\Controllers\Api\AreaGroupController@get_group_details_id');

    Route::get('/update_banner_id', 'App\Http\Controllers\Api\OfferBannerController@update_banner_id');
    Route::post('/banner_Update', 'App\Http\Controllers\Api\OfferBannerController@banner_Update');
    Route::post('/banner_status_changes', 'App\Http\Controllers\Api\OfferBannerController@banner_status_changes');
    Route::get('/get_banner', 'App\Http\Controllers\Api\OfferBannerController@index');
    Route::get('/get_listing_heading', 'App\Http\Controllers\Api\ListingPageContentController@index');
    Route::post('/listing_page_heading_Update', 'App\Http\Controllers\Api\ListingPageContentController@heading_Update');
    Route::post('/heading_status_changes', 'App\Http\Controllers\Api\ListingPageContentController@heading_status_changes');
    Route::get('/delete_heading', 'App\Http\Controllers\Api\ListingPageContentController@delete');
    Route::get('/delete_Banner', 'App\Http\Controllers\Api\OfferBannerController@delete');
    Route::post('/update_user_byinternal', 'App\Http\Controllers\Api\AuthController@update_user_byinternal');
    
    Route::post('/edit_user_data', 'App\Http\Controllers\Api\AuthController@edit_user_data');
    Route::post('/update_mobile_no_byinternal', 'App\Http\Controllers\Api\AuthController@update_mobile_no_byinternal');
    Route::post('/update_email_byinternal', 'App\Http\Controllers\Api\AuthController@update_email_byinternal');
        Route::get('/admin_lawyer_service', 'App\Http\Controllers\Api\AdminController@admin_lawyer_service');
        Route::get('/admin_review_index', 'App\Http\Controllers\Api\AdminController@review_index');
		Route::get('/get_reviews', 'App\Http\Controllers\Api\GuestUserFeedbackController@search_data');
        
        Route::get('admin_get_invoice_data/{id}', 'App\Http\Controllers\PlansController@admin_get_invoice_data');

       Route::get('admin_property_rent_slip', 'App\Http\Controllers\Api\ProductController@admin_property_rent_slip');
        Route::get('admin_get_invoice_data/{id}', 'App\Http\Controllers\PlansController@admin_get_invoice_data');
        Route::get('/admin_get_property', 'App\Http\Controllers\Api\ProductController@admin_get_property');
        Route::get('/admin_get_property_excel', 'App\Http\Controllers\Api\ProductController@admin_get_property_excel');
        Route::get('/get_invoice_searching', 'App\Http\Controllers\Api\InvoiceController@search_data');
        Route::get('/get_invoice_searching_excel', 'App\Http\Controllers\Api\InvoiceController@search_data_excel');
        Route::get('/get_visit_user_feedback', 'App\Http\Controllers\Api\UserVisitFeedbackController@search_data');
        Route::get('/get_search_user', 'App\Http\Controllers\Api\AuthController@get_search_user');
        Route::post('user_reviews_delete', 'App\Http\Controllers\Api\GuestUserFeedbackController@destroy');
        Route::post('/reviews_status_changes', 'App\Http\Controllers\Api\GuestUserFeedbackController@reviews_status_changes');
        Route::post('/user_status_changes', 'App\Http\Controllers\Api\AuthController@user_status_changes');
        Route::get('/get_userbank_details', 'App\Http\Controllers\Api\AuthController@get_userbank_details');
        Route::get('/get_payment_user', 'App\Http\Controllers\Api\AdminPaymentSummeryController@get_payment_user');
        Route::get('/get_payment_user_excel', 'App\Http\Controllers\Api\AdminPaymentSummeryController@get_payment_user_excel');

       Route::get('/admin_get_search_user/{value}', 'App\Http\Controllers\Api\AuthController@admin_get_search_user');
       Route::get('/admin_get_user/{value}', 'App\Http\Controllers\Api\AuthController@admin_get_user');
        Route::get('/admin_mobile_user/{value}', 'App\Http\Controllers\Api\AuthController@admin_mobile_user');
       Route::get('/admin_mobile_search_user/{value}', 'App\Http\Controllers\Api\AuthController@admin_mobile_search_user');
       
    Route::get('/admin_get_property_id', 'App\Http\Controllers\Api\ProductController@admin_get_property_id');
        Route::get('/user_block_status', 'App\Http\Controllers\Api\AuthController@user_block_status');
        Route::get('/get_all_user', 'App\Http\Controllers\Api\AuthController@get_all_user');
         Route::post('delete_user', 'App\Http\Controllers\Api\AuthController@delete_user');
        Route::get('/get_userbank_history_id', 'App\Http\Controllers\Api\UserBankDetailsHistoryController@get_userbank_history_id');
         Route::post('bank_details_delete', 'App\Http\Controllers\Api\AuthController@bank_details_delete');
          Route::post('update_bank_paytm_id', 'App\Http\Controllers\Api\AuthController@update_bank_paytm_id');
    }); 
    // Route::get('/home', 'App\Http\Controllers\Api\HomeController@index')->name('home');
});
