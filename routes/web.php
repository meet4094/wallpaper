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

    // Dashboard
    Route::view('/dashboard', 'Admin/Master/dashboard', ['title' => 'dashboard']);

    // Status Image Category
    Route::view('/status_image_category', 'Admin/Master/status_image_category', ['title' => 'status_image_category']);
    Route::get('/status_image_category_list', [MasterController::class, 'status_image_category_list'])->name('status_image_category_list');  // list
    Route::post('/add_status_image_category', [MasterController::class, 'add_status_image_category']);
    Route::post('/delete_status_image_category', [MasterController::class, 'delete_status_image_category']);
    Route::post('/get_status_image_category_data', [MasterController::class, 'get_status_image_category_data']);

    // Status Image
    Route::view('/status_image', 'Admin/Master/status_image', ['title' => 'status_image']);
    Route::get('/status_images_list', [MasterController::class, 'status_images_list'])->name('status_images_list');  // list
    Route::post('/get_status_image_Category', [MasterController::class, 'get_status_image_Category']);
    Route::post('/add_status_images', [MasterController::class, 'add_status_images']);
    Route::post('/delete_status_images', [MasterController::class, 'delete_status_images']);
    Route::post('/get_status_images_data', [MasterController::class, 'get_status_images_data']);

    // App By Image Category
    Route::view('/app_by_image_category', 'Admin/Master/app_by_image_category', ['title' => 'app_by_image_category']);
    Route::post('/getApp', [MasterController::class, 'getApp']);
    Route::post('/add_app_by_image_category', [MasterController::class, 'add_app_by_image_category']);
    Route::get('/app_by_image_category_list', [MasterController::class, 'app_by_image_category_list'])->name('app_by_image_category_list');  // list
    Route::post('/delete_app_by_image_category', [MasterController::class, 'delete_app_by_image_category']);
    Route::post('/get_app_by_image_category_data', [MasterController::class, 'get_app_by_image_category_data']);

    //Status Video Category
    Route::view('/status_video_category', 'Admin/Master/status_video_category', ['title' => 'status_video_category']);
    Route::get('/status_video_category_list', [MasterController::class, 'status_video_category_list'])->name('status_video_category_list');  // list
    Route::post('/add_status_video_category', [MasterController::class, 'add_status_video_category']);
    Route::post('/delete_status_video_category', [MasterController::class, 'delete_status_video_category']);
    Route::post('/get_status_video_category_data', [MasterController::class, 'get_status_video_category_data']);

    //Status Video 
    Route::view('/status_video', 'Admin/Master/status_video', ['title' => 'status_video']);
    Route::get('/status_videos_list', [MasterController::class, 'status_videos_list'])->name('status_videos_list');  // list
    Route::post('/get_status_video_Category', [MasterController::class, 'get_status_video_Category']);
    Route::post('/add_status_videos', [MasterController::class, 'add_status_videos']);
    Route::post('/delete_status_videos', [MasterController::class, 'delete_status_videos']);
    Route::post('/get_status_videos_data', [MasterController::class, 'get_status_videos_data']);

    // App By Video Category
    Route::view('/app_by_video_category', 'Admin/Master/app_by_video_category', ['title' => 'app_by_video_category']);
    Route::post('/add_app_by_video_category', [MasterController::class, 'add_app_by_video_category']);
    Route::get('/app_by_video_category_list', [MasterController::class, 'app_by_video_category_list'])->name('app_by_video_category_list');  // list
    Route::post('/delete_app_by_video_category', [MasterController::class, 'delete_app_by_video_category']);
    Route::post('/get_app_by_video_category_data', [MasterController::class, 'get_app_by_video_category_data']);

    // Api Call
    Route::view('/api_call', 'Admin/Master/api_call', ['title' => 'api_call']);
    Route::get('/api_call_list', [MasterController::class, 'api_call_list'])->name('api_call_list');  // list

    // App Setting
    Route::view('/app_setting', 'Admin/Master/app_setting', ['title' => 'app_setting']);
    Route::get('/app_data_list', [MasterController::class, 'app_data_list'])->name('app_data_list');  // list
    Route::post('/add_app', [MasterController::class, 'add_app']);
    Route::post('/get_App', [MasterController::class, 'get_App']);
    Route::post('/delete_app_data', [MasterController::class, 'delete_app_data']);
    Route::post('/get_app_data', [MasterController::class, 'get_app_data']);
});
