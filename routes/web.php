<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Admin\MasterController;
use App\Http\Middleware\Authenticate;

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
    Route::post('/add_category', [MasterController::class, 'add_category']);
    Route::view('/category', 'Admin/Master/category', ['title' => 'category']);
    Route::get('/category_list', [MasterController::class, 'category_list'])->name('category_list');  // list
    Route::post('/delete_category', [MasterController::class, 'delete_category']);
    Route::post('/getcategorydata', [MasterController::class, 'getcategorydata']);

    Route::view('/category_items', 'Admin/Master/category_items', ['title' => 'items']);
    Route::post('/getCategory', [MasterController::class, 'getCategory']);
    Route::post('/add_items', [MasterController::class, 'add_items']);
    Route::get('/items_list', [MasterController::class, 'items_list'])->name('items_list');  // list
    Route::post('/delete_item', [MasterController::class, 'delete_item']);
    Route::post('/getitemdata', [MasterController::class, 'getitemdata']);
});
