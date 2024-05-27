<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
    return view('home');
})->middleware(['verify.shopify'])->name('home');

//Route::get('/test', function (Request $request){
//    $shop = $request->user();
//    $web = $shop->api()->rest('GET','/admin/webhooks.json');
//    dd($web);
//})->middleware(['verify.shopify']);

Route::get('/{any}', function () {
    return view('home');
})->middleware(['verify.shopify'])->where('any','.*');


