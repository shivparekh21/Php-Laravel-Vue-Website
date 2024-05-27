<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



Route::get('/getCustomers',[\App\Http\Controllers\CustomerController::class,'index'])->middleware('verify.shopify');


Route::group(["middleware"=>'verify.shopify'],function(){

    Route::get('/allCustomers',[CustomerController::class,'index']);
    Route::get('/newCustomers',[CustomerController::class,'store']);
    Route::get('/graphQlCustomers',[CustomerController::class,'graphQl']);
//    Route::get('/syncProduct',[ProductController::class,'syncProduct']);
    Route::get('/showProduct',[ProductController::class,'showProduct']);
    Route::get('/displayProduct',[ProductController::class,"displayProduct"]);
    Route::get('/displayProductVariants',[ProductController::class,"displayProductVariants"]);
    Route::post('/updateProductVariantPrice',[ProductController::class,"updateProductVariantPrice"]);

});
