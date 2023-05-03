<?php

use App\Http\Controllers\API\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


Route::post('/product-create',[ProductController::class,'store']);
Route::get('/all-products',[ProductController::class,'getAllData']);
Route::get('/edit-products/{id}',[ProductController::class,'edit']);
Route::post('/update-products/{id}',[ProductController::class,'update']);
Route::get('/delete-product/{id}',[ProductController::class,'deleteData']);
