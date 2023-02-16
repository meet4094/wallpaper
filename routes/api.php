<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MasterController;

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

Route::post('apicall', [MasterController::class, 'ApiCallData']);
Route::post('category', [MasterController::class, 'CategoryData']);
Route::post('images', [MasterController::class, 'ImagesData']);
Route::post('videos', [MasterController::class, 'VideosData']);
Route::post('appbyimagecategory', [MasterController::class, 'appbyimagecategoryData']);
Route::post('appbyvideocategory', [MasterController::class, 'appbyvideocategoryData']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
