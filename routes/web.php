<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Middleware\Authenticate;
use Illuminate\Support\Facades\Auth;

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
Route::controller(LoginController::class)->group(function () {
    Route::get('/', 'login');
    Route::get('/login', 'login')->name('login');
    Route::post('/login_data', 'login_data');
    Route::get('/logout', 'logout');
});
Auth::routes();
Route::middleware([Authenticate::class])->group(function () {
    // Category
    Route::post('/add_category', [MasterController::class, 'add_category']);
    Route::view('/category', 'Admin/Master/category', ['title' => 'category']);
    Route::get('/category_list', [MasterController::class, 'category_list'])->name('category_list');  // list
    Route::post('/delete_category', [MasterController::class, 'delete_category']);
    Route::post('/getcategorydata', [MasterController::class, 'getcategorydata']);

    // Image Item
    Route::view('/category_items', 'Admin/Master/category_items', ['title' => 'items']);
    Route::post('/getCategory', [MasterController::class, 'getCategory']);
    Route::post('/add_items', [MasterController::class, 'add_items']);
    Route::get('/items_list', [MasterController::class, 'items_list'])->name('items_list');  // list
    Route::post('/delete_item', [MasterController::class, 'delete_item']);
    Route::post('/getitemdata', [MasterController::class, 'getitemdata']);

    // Api Call
    Route::view('/api_call', 'Admin/Master/api_call', ['title' => 'api_call']);
    Route::get('/api_call_list', [MasterController::class, 'api_call_list'])->name('api_call_list');  // list

    // App Setting
    Route::view('/app_setting', 'Admin/Master/app_setting', ['title' => 'appsetting']);
    Route::post('/add_app', [MasterController::class, 'add_app']);
    Route::get('/app_data_list', [MasterController::class, 'app_data_list'])->name('app_data_list');  // list
    Route::post('/delete_appdata', [MasterController::class, 'delete_appdata']);
    Route::post('/getappdata', [MasterController::class, 'getappdata']);
});
