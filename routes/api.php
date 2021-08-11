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

//Route::post('/blog-create-post', 'App\Http\Controllers\PostController@store');
//Route::resource('/blog', PostsController::class);
Route::resource('amenities', 'App\Http\Controllers\Api\AmenitieController');
Route::post('contact-form', 'App\Http\Controllers\ContactController@store');																			
Route::middleware('auth:api')->post('posts', 'App\Http\Controllers\PostController@store');
Route::get('posts', 'App\Http\Controllers\PostController@index');
Route::get('posts_latest', 'App\Http\Controllers\PostController@index_latest');

Route::get('posts/{post}', 'App\Http\Controllers\PostController@show');
Route::middleware('auth:api')->post('posts/update/{slug}', 'App\Http\Controllers\PostController@update');
Route::middleware('auth:api')->delete('posts/delete/{slug}', 'App\Http\Controllers\PostController@destroy');

Route::group([
    'prefix' => 'auth'
], function () {
    Route::post('/login', 'App\Http\Controllers\Api\AuthController@login');
    Route::post('/user_signup', 'App\Http\Controllers\Api\AuthController@user_signup');
	Route::post('/verify_mobile', 'App\Http\Controllers\Api\AuthController@verify_mobile_number');																							  
    Route::post('/user_signup_new', 'App\Http\Controllers\Api\AuthController@user_signup_new');
    Route::get('/get_product_featured', 'App\Http\Controllers\Api\ProductController@index_featured');

    Route::post('/owner_signup', 'App\Http\Controllers\Api\AuthController@owner_signup');
    Route::post('/dealer_signup', 'App\Http\Controllers\Api\AuthController@dealer_company_signup');
    Route::post('/lawyer_signup', 'App\Http\Controllers\Api\AuthController@lawyer_signup');

    Route::post('/verify', 'App\Http\Controllers\Api\AuthController@verify');
	Route::post('/verify_mob', 'App\Http\Controllers\Api\AuthController@verify_mob');																				 
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
        Route::get('/verify_user', 'App\Http\Controllers\Api\AuthController@verify_user');
		Route::get('/verify_user_mobile', 'App\Http\Controllers\Api\AuthController@verify_user_mobile');																								
        Route::post('/change_password', 'App\Http\Controllers\Api\AuthController@change_password');
    });
    // Route::get('/home', 'App\Http\Controllers\Api\HomeController@index')->name('home');
});

Route::group([
    'prefix' => 'product'
], function () {
    Route::get('/getRecently_viewProperty', 'App\Http\Controllers\Api\ProductController@Recently_view');
    Route::get('/get_product', 'App\Http\Controllers\Api\ProductController@index');
    Route::get('/get_product_featured', 'App\Http\Controllers\Api\ProductController@index_featured');
    Route::get('/seeto', 'App\Http\Controllers\Api\ProductController@product_index');
    Route::post('/see', 'App\Http\Controllers\Api\ProductController@search_prod_by_id');
    Route::post('/similarproperty', 'App\Http\Controllers\Api\ProductController@search_prod_by_city');
    Route::post('/search', 'App\Http\Controllers\Api\ProductController@search_func');
    Route::post('/city_search', 'App\Http\Controllers\Api\ProductController@city_search_func');
    Route::post('/req_index', 'App\Http\Controllers\Api\RequirementController@reqHandler');
    Route::get('/agent_properties', 'App\Http\Controllers\Api\ProductController@agent_properties');

    Route::get('/lawyer_service_index', 'App\Http\Controllers\Api\LawyerController@lawyer_index');
    Route::post('/lawyer_page', 'App\Http\Controllers\Api\LawyerController@lawyer_check');

    Route::post('/product_review', 'App\Http\Controllers\Api\ReviewsController@product_review');
    Route::post('/product_Searching', 'App\Http\Controllers\Api\ProductController@propertysearch_list');
    Route::get('/testimonial', 'App\Http\Controllers\Api\ReviewsController@testimonial');

    Route::group([
        'middleware' => 'auth:api'
    ], function () {
        Route::post('/loginSimilarproperty', 'App\Http\Controllers\Api\ProductController@loginSimilarproperty');
        Route::post('/requ', 'App\Http\Controllers\Api\RequirementController@create');
        Route::get('/review_index', 'App\Http\Controllers\Api\ReviewsController@review_index');
        Route::post('/post_review', 'App\Http\Controllers\Api\ReviewsController@store');


        Route::get('/get_requ', 'App\Http\Controllers\Api\RequirementController@index');
        Route::get('/requ_display', 'App\Http\Controllers\Api\RequirementController@display');
        Route::post('/requirement_delete', 'App\Http\Controllers\Api\RequirementController@delete');

        Route::post('/save_search', 'App\Http\Controllers\Api\SavedsearchesController@store');
        Route::get('/get_search', 'App\Http\Controllers\Api\SavedsearchesController@index');
        Route::post('/update_product', 'App\Http\Controllers\Api\ProductController@update_product');

        Route::get('/views', 'App\Http\Controllers\Api\ProductController@dashboard_indexer');

        Route::post('/delete_product', 'App\Http\Controllers\Api\ProductController@delete_product');
        Route::get('/agent_properties', 'App\Http\Controllers\Api\ProductController@agent_properties');

        Route::post('/insert_product_sale', 'App\Http\Controllers\Api\ProductController@first');
        Route::post('/insert_product_rent', 'App\Http\Controllers\Api\ProductController@second');


        Route::post('/lawyer_create_service', 'App\Http\Controllers\Api\LawyerController@lawyer_create_service');
        Route::get('/lawyer_service', 'App\Http\Controllers\Api\LawyerController@lawyer_service');
        Route::post('/lawyer_service_delete', 'App\Http\Controllers\Api\LawyerController@lawyer_service_delete');
        Route::post('/product_Searching_login', 'App\Http\Controllers\Api\ProductController@User_propertysearchlist');
        Route::post('/Propery_get_id', 'App\Http\Controllers\Api\ProductController@Propery_get_id');
        Route::get('/get_product_wishlist', 'App\Http\Controllers\Api\ProductController@index_featured_wishlist');
        Route::resource('wishlist', 'App\Http\Controllers\Api\WishlistController');
        Route::post('wishlistDelete', 'App\Http\Controllers\Api\WishlistController@delete');
         Route::post('User_productCount', 'App\Http\Controllers\Api\UserProductCountController@count_byID');
        Route::get('User_CountData', 'App\Http\Controllers\Api\UserProductCountController@index');

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

      Route::post('/product_Rent_update', 'App\Http\Controllers\Api\AdminController@update_Rent_product');
        Route::post('/product_sales_update', 'App\Http\Controllers\Api\AdminController@update_Sales_product');
        Route::post('/delete_product_admin', 'App\Http\Controllers\Api\AdminController@delete_product');
        Route::post('/user_page', 'App\Http\Controllers\Api\AdminController@user_check');
        Route::post('/user_update', 'App\Http\Controllers\Api\AdminController@user_update');
        Route::post('/admin_loans', 'App\Http\Controllers\Api\LoansController@first');
        Route::post('/loan_delete', 'App\Http\Controllers\Api\LoansController@loan_delete');
        Route::get('/user_index', 'App\Http\Controllers\Api\AdminController@user_index_admin');
        Route::get('/event_index', 'App\Http\Controllers\Api\EventtrackerController@index');
        Route::get('/product_index', 'App\Http\Controllers\Api\AdminController@product_index_admin');
        Route::get('/product_views', 'App\Http\Controllers\Api\AdminController@product_views');
        Route::get('/review_count', 'App\Http\Controllers\Api\AdminController@review_count');
        Route::get('/product_update_admin', 'App\Http\Controllers\Api\AdminController@product_update');
        Route::get('/admin_lawyer_service', 'App\Http\Controllers\Api\AdminController@admin_lawyer_service');
        Route::get('/admin_review_index', 'App\Http\Controllers\Api\AdminController@review_index');
    });
    // Route::get('/home', 'App\Http\Controllers\Api\HomeController@index')->name('home');
});
