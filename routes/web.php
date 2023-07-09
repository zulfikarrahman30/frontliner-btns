<?php

use Illuminate\Support\Facades\Route;
//auth
use App\Http\Controllers\Auth\LoginController;
//admin-user
use App\Http\Controllers\Admin\AdminUserController;
use App\Http\Controllers\Admin\CustomerServiceUserController;
use App\Http\Controllers\Admin\FinancingServiceUserController;
use App\Http\Controllers\Admin\ManagerUserController;
use App\Http\Controllers\Admin\TellerUserController;
use App\Http\Controllers\Admin\MarketingUserController;
use App\Http\Controllers\Admin\UserLogController;
use App\Http\Controllers\Nasabah\CustomerServiceSubmissionController;
use App\Http\Controllers\Nasabah\FinancingServiceSubmissionController;
use App\Http\Controllers\Nasabah\TellerSubmissionController;



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

Route::get('/', function () {
     return view('auth.login');
});
Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/profile_user', [App\Http\Controllers\HomeController::class, 'getEditProfile']);
Route::post('login_user',[LoginController::class, 'loginUser']);

//User Page Handler
Route::get('/user/admin_index', [AdminUserController::class, 'index']);
Route::post('user/admin_store',[AdminUserController::class, 'store']);
Route::get('user/admin_delete/{id}',[AdminUserController::class, 'destroy']);
Route::get('/user/admin_create', [AdminUserController::class, 'create']);
Route::post('/user/admin_update/{id}', [AdminUserController::class, 'update']);
Route::get('user/admin_edit/{id}',[AdminUserController::class, 'edit']);

Route::get('/user/customer_service_index', [CustomerServiceUserController::class, 'index']);
Route::post('user/customer_service_store',[CustomerServiceUserController::class, 'store']);
Route::get('user/customer_service_delete/{id}',[CustomerServiceUserController::class, 'destroy']);
Route::get('/user/customer_service_create', [CustomerServiceUserController::class, 'create']);
Route::post('/user/customer_service_update/{id}', [CustomerServiceUserController::class, 'update']);
Route::get('user/customer_service_edit/{id}',[CustomerServiceUserController::class, 'edit']);

Route::get('/user/financing_service_index', [FinancingServiceUserController::class, 'index']);
Route::post('user/financing_service_store',[FinancingServiceUserController::class, 'store']);
Route::get('user/financing_service_delete/{id}',[FinancingServiceUserController::class, 'destroy']);
Route::get('/user/financing_service_create', [FinancingServiceUserController::class, 'create']);
Route::post('/user/financing_service_update/{id}', [FinancingServiceUserController::class, 'update']);
Route::get('user/financing_service_edit/{id}',[FinancingServiceUserController::class, 'edit']);

Route::get('/user/manager_index', [ManagerUserController::class, 'index']);
Route::post('user/manager_store',[ManagerUserController::class, 'store']);
Route::get('user/manager_delete/{id}',[ManagerUserController::class, 'destroy']);
Route::get('/user/manager_create', [ManagerUserController::class, 'create']);
Route::post('/user/manager_update/{id}', [ManagerUserController::class, 'update']);
Route::get('user/manager_edit/{id}',[ManagerUserController::class, 'edit']);


Route::get('/user/teller_index', [TellerUserController::class, 'index']);
Route::post('/user/teller_store', [TellerUserController::class, 'store']);
Route::get('user/teller_delete/{id}',[TellerUserController::class, 'destroy']);
Route::get('/user/teller_create', [TellerUserController::class, 'create']);
Route::post('/user/teller_update/{id}', [TellerUserController::class, 'update']);
Route::get('user/teller_edit/{id}',[TellerUserController::class, 'edit']);

Route::get('/user/marketing_index', [MarketingUserController::class, 'index']);
Route::post('/user/marketing_store', [MarketingUserController::class, 'store']);
Route::get('user/marketing_delete/{id}',[MarketingUserController::class, 'destroy']);
Route::get('/user/marketing_create', [MarketingUserController::class, 'create']);
Route::post('/user/marketing_update/{id}', [MarketingUserController::class, 'update']);
Route::get('user/marketing_edit/{id}',[MarketingUserController::class, 'edit']);

Route::get('/layanan/customer_service_submission_index', [CustomerServiceSubmissionController::class, 'index']);
Route::post('/layanan/customer_service_submission_store',[CustomerServiceSubmissionController::class, 'store']);
Route::get('layanan/customer_service_submission_delete/{id}',[CustomerServiceSubmissionController::class, 'destroy']);
Route::get('/layanan/customer_service_submission_create', [CustomerServiceSubmissionController::class, 'create']);
Route::post('/layanan/customer_service_submission_update/{id}', [CustomerServiceSubmissionController::class, 'update']);
Route::get('layanan/customer_service_submission_edit/{id}',[CustomerServiceSubmissionController::class, 'edit']);

Route::get('/layanan/financing_service_submission_index', [FinancingServiceSubmissionController::class, 'index']);
Route::post('layanan/financing_service_submission_store',[FinancingServiceSubmissionController::class, 'store']);
Route::get('layanan/financing_service_submission_delete/{id}',[FinancingServiceSubmissionController::class, 'destroy']);
Route::get('/layanan/financing_service_submission_create', [FinancingServiceSubmissionController::class, 'create']);
Route::post('/layanan/financing_service_submission_update/{id}', [FinancingServiceSubmissionController::class, 'update']);
Route::get('layanan/financing_service_submission_edit/{id}',[FinancingServiceSubmissionController::class, 'edit']);

Route::get('/layanan/teller_submission_index', [TellerSubmissionController::class, 'index']);
Route::post('/layanan/teller_submission_store', [TellerSubmissionController::class, 'store']);
Route::get('layanan/teller_submission_delete/{id}',[TellerSubmissionController::class, 'destroy']);
Route::get('/layanan/teller_submission_create', [TellerSubmissionController::class, 'create']);
Route::post('/layanan/teller_submission_update/{id}', [TellerSubmissionController::class, 'update']);
Route::get('layanan/teller_submission_edit/{id}',[TellerSubmissionController::class, 'edit']);

Route::get('/layanan/assignment_index', [ManagerUserController::class, 'assignment']);
Route::post('/layanan/assignment_store', [ManagerUserController::class, 'assignment_store']);
Route::get('layanan/assignment_delete/{id}',[ManagerUserController::class, 'assignment_destroy']);
Route::get('/layanan/assignment_create', [ManagerUserController::class, 'assignment_create']);
Route::post('/layanan/assignment_update/{id}', [ManagerUserController::class, 'assignment_update']);
Route::get('layanan/assignment_edit/{id}',[ManagerUserController::class, 'assignment_edit']);
Route::get('layanan/assignment_detail_riwayat/{id}',[ManagerUserController::class, 'getHistoryAssigment']);

Route::get('/layanan/klasifikasi_index', [ManagerUserController::class, 'klasifikasi']);

Route::get('/layanan/marketing_assignment_index', [MarketingUserController::class, 'marketing_assignment']);
Route::post('/layanan/marketing_assignment_store', [MarketingUserController::class, 'marketing_assignment_store']);
Route::get('layanan/marketing_assignment_delete/{id}',[MarketingUserController::class, 'marketing_assignment_destroy']);
Route::get('/layanan/marketing_assignment_create', [MarketingUserController::class, 'marketing_assignment_create']);
Route::post('/layanan/marketing_assignment_update/{id}', [MarketingUserController::class, 'marketing_assignment_update']);
Route::get('layanan/marketing_assignment_edit/{id}',[MarketingUserController::class, 'marketing_assignment_edit']);
Route::get('layanan/marketing_assignment_detail_riwayat/{id}',[ManagerUserController::class, 'getHistoryAssigment']);
Route::post('layanan_marketing_activites_add',[MarketingUserController::class, 'submitActivity']);

Route::get('/user/user_log_index', [UserLogController::class, 'index']);
     

