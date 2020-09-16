<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\UserController;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('uploadFile', 'App\Http\Controllers\FileUploadController@uploadFile');

Route::group(['prefix' => 'user'], function () {

    Route::post('register', 'App\Http\Controllers\UserController@register');
    Route::post('login', [UserController::class, 'login']);
    Route::post('completeProfile', 'App\Http\Controllers\UserController@completeProfile');


});
Route::group(['prefix' => 'post'], function () {

    Route::post('createPost', 'App\Http\Controllers\PostsController@createPost');
    Route::post('allPosts', 'App\Http\Controllers\PostsController@allPosts');


});
Route::group(['prefix' => 'ad'], function () {

    Route::post('createAd', [AdsController::class,'createAd']);
    Route::post('allAds', [AdsController::class,'allAds']);
    Route::post('getMyAds', [AdsController::class,'getMyAds']);
    Route::post('adDetails', [AdsController::class,'adDetails']);


});