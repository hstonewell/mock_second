<?php

use App\Http\Controllers\CsvController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\SearchController;
use App\Http\Controllers\BookmarkController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\ReviewController;

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

Route::get('/', [ShopController::class, 'index'])->name('index');
Route::get('/search', [SearchController::class, 'search'])->name('search');
Route::get('/detail/{shop_id}', [ShopController::class, 'detail'])->name('detail');

Route::middleware(['auth', 'verified'])->group(function () {

    // 一般ユーザ
    Route::middleware('role:user')->group(function () {
        // マイページ表示
        Route::get('/mypage', [ShopController::class, 'viewMyPage'])->name('mypage.show');

        // お気に入り
        Route::post('/bookmarks', [BookmarkController::class, 'store'])->name('bookmarks.show');
        Route::delete('/bookmarks', [BookmarkController::class, 'destroy'])->name('bookmarks.destroy');

        // 予約
        Route::post('/bookings', [BookingController::class, 'store'])->name('bookings.store');;
        Route::delete('/bookings', [BookingController::class, 'destroy'])->name('bookings.destroy');
        Route::get('/done', [BookingController::class, 'viewDone'])->name('done');

        // 評価機能機能
        Route::get('/review/{shop_id}', [ReviewController::class, 'review'])->name('review.create');
    });

    // 管理ユーザ
    Route::middleware('role:admin')->group(function () {

        // CSVインポート
        Route::get('/admin', [CsvController::class, 'upload'])->name('admin.show');
        Route::post('/admin', [CsvController::class, 'importCsv'])->name('csv.store');
    });

    Route::middleware('permission:delete_review')->group(function (){
        Route::delete('/delete/{review_id}', [ReviewController::class, 'destroy'])->name('review.destroy');
    });
});