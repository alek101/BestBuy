<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::post('/uploadfile',[FileController::class, 'addCSV']);

Route::prefix('/categories')->group(function()
{
    Route::get('/index',[CategoryController::class, 'index']);
    Route::post('/update',[CategoryController::class, 'update']);
    Route::get('/delete/{id}',[CategoryController::class, 'destroy']);
});

Route::prefix('/products')->group(function()
{
    Route::get('/index',[ProductController::class, 'index']);
    Route::get('/showProductsByCategoryID/{id}',[ProductController::class, 'showProductsByCategoryID']);
    Route::post('/update',[ProductController::class, 'update']);
    Route::get('/delete/{id}',[ProductController::class, 'destroy']);
});
