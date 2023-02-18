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

Route::post('apps/callappsapi', [MasterController::class, 'ApiCallData']);
Route::post('statusimage/category', [MasterController::class, 'StatusImageCategoryData']);
Route::post('stausimage/images', [MasterController::class, 'StatusImagesData']);
Route::post('statusvideo/category', [MasterController::class, 'StatusVideoCategoryData']);
Route::post('statusvideo/videos', [MasterController::class, 'StatusVideosData']);
Route::post('appbycategory/statusimagecategory', [MasterController::class, 'AppByImageCategoryData']);
Route::post('appbycategory/statusvideocategory', [MasterController::class, 'AppByVideoCategoryData']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
