<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\ReviewController;
use Flynsarmy\CsvSeeder\CsvSeeder;

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
Route::get('/search', [ShopController::class, 'search'])->name('search');
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');

//予約・お気に入り
Route::middleware(['auth', 'verified'])->group(function () {
    Route::post('/bookmarks', [ShopController::class, 'storeBookmark'])->name('bookmark.show');
    Route::delete('/bookmarks', [ShopController::class, 'destroyBookmark'])->name('bookmark.destroy');
    Route::get('/mypage', [ShopController::class, 'viewMyPage'])->name('mypage.show');
    Route::post('/bookings', [ShopController::class, 'storeBooking'])->name('booking.store');;
    Route::delete('/bookings', [ShopController::class, 'destroyBooking'])->name('booking.destroy');
    Route::get('/done', [ShopController::class, 'viewDone'])->name('done');
});

// 追加機能：CSVインポート
Route::get('/upload', [CsvController::class, 'upload'])->name('upload.show');
Route::post('/upload', [CsvController::class, 'importCsv'])->name('csv.store');

// 追加機能：評価投稿
Route::get('/review/{shop_id}', [ReviewController::class, 'review'])->name('review.show');
Route::delete('/delete/{review_id}', [ReviewController::class, 'destroy'])->name('review.destroy');
