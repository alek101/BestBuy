<?php

use Illuminate\Support\Facades\Route;
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


Route::get('/',[FileController::class, 'index']);
Route::post('/uploadfile',[FileController::class, 'addCSV'])->name('import');

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
