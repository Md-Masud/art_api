<?php

use App\Http\Controllers\ApiAdmin\CategoryController;
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

Route::prefix('v1/admin')->group(function () {
    Route::get('auth/create-token', [App\Http\Controllers\ApiAdmin\AuthController::class, 'createToken']);

    Route::post('login', [App\Http\Controllers\ApiAdmin\AuthController::class, 'login']);
    Route::group(['middleware' => 'auth:api', 'prifix' => 'admin', 'namespace' => 'App\Http\Controllers\ApiAdmin'], function () {
        //auth route
        Route::post('register',  'AuthController@register');
        Route::post('change-password', 'AuthController@change_password');
        Route::post('logout', 'AuthController@logout');
        //user route
        Route::get('users', 'UserController@index');
        Route::get('user/edit/{id}', 'UserController@edit');
        Route::post('user/update/{id}', 'UserController@update');
        Route::post('user/delete/{id}', 'UserController@delete');
        //category route
        Route::get('category', 'CategoryController@index');
        Route::post('category/create', 'CategoryController@store');
        Route::get('category/edit/{id}', 'CategoryController@edit');
        Route::post('category/update/{id}', 'CategoryController@update');
        Route::post('category/delete/{id}', 'CategoryController@destroy');
        //subCategory
        Route::apiResource('subCategories', 'SubCategoryController');
        //product Route
        Route::apiResource('products', 'ProductController');
        //Post Category
        Route::apiResource('postCategories', 'PostCategoryController');
        //Post
        Route::apiResource('posts', 'PostController');
    });
});
Route::prefix('v1')->group(function () {
    Route::get('art/post', [App\Http\Controllers\ApiFrontend\DasboardController::class, 'post']);
    Route::get('art/category', [App\Http\Controllers\ApiFrontend\DasboardController::class, 'category']);
    Route::get('art/product', [App\Http\Controllers\ApiFrontend\DasboardController::class, 'product']);
    Route::get('art/category/{id}', [App\Http\Controllers\ApiFrontend\DasboardController::class, 'getCategoryIdAllProduct']);
});

