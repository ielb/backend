<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ApiAuthController;
use App\Http\Controllers\ChatRoomController;
use App\Http\Controllers\FriendController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\PhotoController;

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
Route::post('/login',[ApiAuthController::class,'login']);
Route::post('/register',[UserController::class,'register']);

Route::middleware('auth:api')->group(function ()  {

    Route::post('/user/photo',[PhotoController::class,'store']);
    Route::post('/fcm',[UserController::class, 'fcmToken']);
    Route::post('/user/update/email',[UserController::class, 'updateEmail']);
    Route::post('/user/password',[UserController::class, 'changePass']);
    Route::post('/user/update',[UserController::class, 'updateUser']);
    Route::post('/logout',[ApiAuthController::class,'logout']);
    Route::post(("/conversation/user"),[ChatRoomController::class,'get_current_user']);
    Route::get('/user',[UserController::class, 'current']);
    Route::post('/user/search',[UserController::class, 'searchForUser']);
    Route::get('/conversation', [ChatRoomController::class, 'index']);
    Route::delete('/conversation/{id}',[ChatRoomController::class, 'destroy']);
    Route::post('/conversation/delete', [ChatRoomController::class, 'destroy']);
    Route::get('/user/friends', [FriendController::class, 'index']);
    Route::post('/user/friends/create', [FriendController::class, 'store']);
    Route::post('/conversation/create', [ChatRoomController::class, 'store']);
    Route::post('/conversation/read', [ChatRoomController::class, 'makeChatRoomAsReaded']);
    Route::post('/message', [MessageController::class, 'store']);
    Route::post('/user/delete',[UserController::class, 'deleteUser']);
});
