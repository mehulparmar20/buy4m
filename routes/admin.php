<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\CountryController;
use App\Http\Controllers\AdminAuthController;
use App\Http\Controllers\StateController;
use App\Http\Controllers\TaxController;
use App\Http\Controllers\ShopController;
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
Route::get('/admin',[AdminController::class,"index"])->name('admin.index');

// UserController ===============
Route::get('/admin-user',[UserController::class,"index"])->name('admin.user_index');
Route::get('/admin-user_create',[UserController::class,"Create"])->name('admin.user_Create');
Route::post('/admin-user_Store',[UserController::class,"Store"])->name('admin.user_Store');
Route::get('/admin-user_edit/{id}',[UserController::class,"edit"])->name('admin.user_edit');
Route::post('/admin/user_update',[UserController::class,"update"])->name('admin.user_update');
Route::get('/admin/user_delete/{id}',[UserController::class,"delete"])->name('admin.user_delete');

// TripController=========================
Route::get('/admin-trip',[TripController::class,"index"])->name('admin.trip_index');

// OrderController==============================
Route::get('/admin-order',[OrderController::class,"index"])->name('admin.order_index');

// CountryController=======================================================
Route::get('/admin-create_country',[CountryController::class,"create"])->name('admin.create_country');
Route::post('/admin-store_country',[CountryController::class,"store"])->name('admin.store_country');
Route::get('/admin-fatch_country',[CountryController::class,"fatch_country"])->name('admin.fatch_country');
Route::get('/admin-delete_country/{id}',[CountryController::class,"delete_country"])->name('admin.delete_country');
Route::get('/admin-index_country',[CountryController::class,"index"])->name('admin.index_country');

// AdminAuthController
Route::get('admin/logout', [AdminAuthController::class, 'adminLogout'])->name('adminLogout');

// StateController
Route::get('/admin-index_state',[StateController::class,"index"])->name('admin.index_state');
Route::get('/admin-create_state',[StateController::class,"create"])->name('admin.create_state');
Route::post('/admin-store_state',[StateController::class,"store"])->name('admin.store_state');
Route::get('/admin-edit_state/{id}',[StateController::class,"edit"])->name('admin.edit_state');
Route::post('/admin-update_state',[StateController::class,"update"])->name('admin.update_state');
Route::get('/admin-delete_state/{id}',[StateController::class,"delete"])->name('admin.delete_state');
Route::get('/admin-fatch_state',[StateController::class,"fatch_state"])->name('admin.fatch_state');
// AdminAuthController
Route::get('/admin-login', [AdminAuthController::class, 'getLogin'])->name('adminLogin');
Route::post('/admin-LoginPost', [AdminAuthController::class, 'postLogin'])->name('adminLoginPost');

// TaxController
Route::get('/admin-indexTax', [TaxController::class, 'index'])->name('admin.indexTax');
Route::get('/admin-editTax', [TaxController::class, 'edit'])->name('admin.editTax');
Route::post('/admin-updateTax', [TaxController::class, 'update'])->name('admin.updateTax');

// ShopController
Route::get('/admin-index_topShop',[ShopController::class,"index"])->name('admin.index_topShop');
Route::get('/admin-create_topShop',[ShopController::class,"create"])->name('admin.create_topShop');
Route::post('/admin-store_topShop',[ShopController::class,"store"])->name('admin.store_topShop');
Route::get('/admin-edit_topShop/{id}',[ShopController::class,"edit"])->name('admin.edit_topShop');
Route::post('/admin-update_topShop',[ShopController::class,"update"])->name('admin.update_topShop');
Route::get('/admin-delete_topShop/{id}',[ShopController::class,"delete"])->name('admin.delete_topShop');


