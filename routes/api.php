<?php

use App\Http\Controllers\AdsController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\MessagesController;
use App\Http\Controllers\RoomsController;
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
    Route::post('updateFcmKey', [UserController::class, 'updateFcmKey']);
    Route::post('completeProfile', 'App\Http\Controllers\UserController@completeProfile');


});
Route::group(['prefix' => 'post'], function () {

    Route::post('createPost', 'App\Http\Controllers\PostsController@createPost');
    Route::post('allPosts', 'App\Http\Controllers\PostsController@allPosts');


});
Route::group(['prefix' => 'ad'], function () {

    Route::post('createAd', [AdsController::class, 'createAd']);
    Route::post('allAds', [AdsController::class, 'allAds']);
    Route::post('getMyAds', [AdsController::class, 'getMyAds']);
    Route::post('adDetails', [AdsController::class, 'adDetails']);


});
Route::group(['prefix' => 'room'], function () {

    Route::post('createRoom', [RoomsController::class, 'createRoom']);

});


Route::group(['prefix' => 'comments'], function () {

    Route::post('getAllComments', [CommentsController::class, 'getAllComments']);
    Route::post('addComment', [CommentsController::class, 'addComment']);

});

Route::group(['prefix' => 'message'], function () {

    Route::post('createMessage', [MessagesController::class, 'createMessage']);
    Route::post('allRoomMessages', [MessagesController::class, 'allRoomMessages']);
    Route::post('userMessages', [MessagesController::class, 'userMessages']);

});
