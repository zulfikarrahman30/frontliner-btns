<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Home\HomeController;
use App\Http\Controllers\Api\Marketing\ActivityController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
//auth
Route::post('sign-in',[AuthController::class, 'login']);
//home
Route::prefix('home')->group(function () {
	Route::get('data',[HomeController::class, 'getDataHome']);
	Route::get('all_assignment',[HomeController::class, 'getAllAssigment']);
	Route::get('all_assignment_by_category',[HomeController::class, 'getAllAssigmentByCategory']);
	Route::get('assignment',[HomeController::class, 'getDetailAssigment']);
	Route::get('assignment_get_all_riwayat',[HomeController::class, 'getAllRiwayat']);
	Route::get('get_number_admin',[HomeController::class, 'getNumberAdmin']);
});
//marketing
Route::prefix('marketing')->group(function () {
	Route::get('bookmar_unbookmark_assignment',[ActivityController::class, 'bookmarOrUnBookmarkkActivity']);
	Route::get('assignment_bookmarked',[ActivityController::class, 'getBookmarkAssignment']);
	Route::post('add_activity',[ActivityController::class, 'submitActivity']);
	Route::post('update_profile_data',[ActivityController::class, 'updateProfile']);
	Route::post('update_profile_photo',[ActivityController::class, 'updatePhotoProfile']);
	Route::post('change_password',[ActivityController::class, 'changePassword']);
	Route::post('search_by_category_and_name',[ActivityController::class, 'searchByCategoryName']);
	Route::post('search_by_new_customer_and_name',[ActivityController::class, 'searchByNewsName']);
	Route::post('search_by_bookmark_and_name',[ActivityController::class, 'searchByBookmarkName']);
});