<?php

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\MainController;

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

Route::post('apicall', [MainController::class, 'ApiCallData']);
Route::post('category', [MainController::class, 'CategoryData']);
Route::post('images', [MainController::class, 'ImagesData']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
