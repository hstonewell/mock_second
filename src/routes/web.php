<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\ShopController;

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

Route::get('/', [ShopController::class, 'index']);

Route::get('/menu', [RegisterController::class, 'menu']);

Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/thanks', [RegisterController::class, 'viewThanks']);


    Route::get('/mypage', [ShopController::class, 'viewMyPage']);

Route::middleware('auth')->group(function(){

    Route::post('/bookmarks', [ShopController::class, 'storeBookmark'])->name('storeBookmark');
    Route::delete('/bookmarks', [ShopController::class, 'destroyBookmark'])->name('destroyBookmark');
//    Route::post('/bookings', [ShopController::class, 'storeBooking']);
//    Route::post('/bookings', [ShopController::class, 'destroyBooking']);
//    Route::get('/done', [ShopController::class, 'viewDone']);
});

//Route::get('/detail/{shop_id}', [ShopController::class, 'detail']);

Route::get('/search', [ShopController::class, 'search'])->name('search');
