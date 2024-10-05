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
Route::get('/search', [ShopController::class, 'search'])->name('search');
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');

//ログイン・認証
Route::get('/register', [RegisterController::class, 'create'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);
Route::get('/thanks', [RegisterController::class, 'viewThanks']);


//予約・お気に入り
Route::middleware('auth')->group(function(){
    Route::post('/bookmarks', [ShopController::class, 'storeBookmark'])->name('storeBookmark');
    Route::delete('/bookmarks', [ShopController::class, 'destroyBookmark'])->name('destroyBookmark');
    Route::get('/mypage', [ShopController::class, 'viewMyPage'])->name('viewMypage');
    Route::post('/bookings', [ShopController::class, 'storeBooking'])->name('storeBooking');;
    Route::delete('/bookings', [ShopController::class, 'destroyBooking'])->name('destroyBooking');
    Route::get('/done', [ShopController::class, 'viewDone'])->name('done');
});
