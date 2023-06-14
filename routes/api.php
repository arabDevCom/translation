<?php

//use App\Http\Controllers\Api\Auth\Provider\AuthController;
use App\Http\Controllers\Api\FavouriteController;
use App\Http\Controllers\Api\GeneralController;
use App\Http\Controllers\Api\ProductsController;

use App\Http\Controllers\Api\Provider\Auth\AuthProviderController;
use App\Http\Controllers\Api\Provider\Auth\CodeCheckController;
use App\Http\Controllers\Api\Provider\Auth\ForgotPasswordController;
use App\Http\Controllers\Api\Provider\Auth\ResetPasswordController;
use App\Http\Controllers\Api\Provider\CategoryController;
use App\Http\Controllers\Api\Provider\OrderController;
use App\Http\Controllers\Api\Provider\ProductController;
use App\Http\Controllers\Api\Provider\SearchController;
use App\Http\Controllers\Api\Provider\ServiceController;
use App\Http\Controllers\Api\SettingController;
use App\Http\Controllers\Api\PaytapsPaymentController;
use Illuminate\Support\Facades\Route;
use Orion\Facades\Orion;

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

Route::group(['prefix' => 'provider/auth'],function (){
    Route::post('password/email',  ForgotPasswordController::class);
    Route::post('password/code/check', CodeCheckController::class);
    Route::post('password/reset', ResetPasswordController::class);
    Route::post('login',[AuthProviderController::class, 'login']);
    Route::POST('register',[AuthProviderController::class, 'register']);
    Route::POST('update-profile',[AuthProviderController::class, 'update_profile']);
    Route::POST('delete-account',[AuthProviderController::class, 'deleteAccount']);
    Route::get('my-profile',[AuthProviderController::class, 'me']);
    Route::get('profile-by-phone',[AuthProviderController::class, 'profileWithPhone']);
//    Route::post('insert-token',[NotificationController::class, 'insert_token']);
});
Route::group(['prefix' => 'provider/categories'],function (){
    Route::get('list', [CategoryController::class, 'index']);
    Route::post('store', [CategoryController::class, 'store']);
    Route::get('find/{id}', [CategoryController::class, 'find']);
    Route::post('update/{id}', [CategoryController::class, 'update']);
    Route::post('delete/{id}', [CategoryController::class, 'destroy']);
});

Route::group(['prefix' => 'services'],function (){
    Route::post('store', [ServiceController::class, 'store']);
    Route::post('add-to-favourites', [FavouriteController::class, 'post_favourite']);
    Route::get('get-favourites', [FavouriteController::class, 'get_favourites']);

});

Route::get('providers/list', [ProviderController::class, 'index']);
Route::get('cities', [GeneralController::class, 'cities']);
Route::get('sliders', [GeneralController::class, 'sliders']);
Route::get('translation_types', [GeneralController::class, 'translation_types']);

Orion::resource('products-api', ProductsController::class);


Route::group([ 'middleware' => 'api','namespace' => 'Api'], function () {
    Route::get('setting',[SettingController::class, 'index']);
    Route::get('/paytap/store',[PaytapsPaymentController::class,'store'])->name('paytap');
    Route::get('/callback_paytabs',[PaytapsPaymentController::class,'callback_paytabs']);
    Route::post('/return_paytabs',[PaytapsPaymentController::class,'return_paytabs']);
    Route::get('/search', [SearchController::class, 'index']);
});



