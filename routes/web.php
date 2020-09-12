<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TestController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/test1',[TestController::class, 'test1']);
Route::get('/test2',[TestController::class, 'test2']);
Route::get('/test3',[TestController::class, 'test3']);

Route::get('/',[FileController::class, 'index']);
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
