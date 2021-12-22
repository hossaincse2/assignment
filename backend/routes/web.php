<?php

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
    return redirect(route('login'));
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('/base-url-img/{image}/{type}', [App\Http\Controllers\ProductController::class, 'baseUrl'])->name('product.baseUrl');

Route::prefix('product')->middleware('auth')->group(function () {
    Route::get('/list', [App\Http\Controllers\ProductController::class, 'index'])->name('product.list');
    Route::get('/create', [App\Http\Controllers\ProductController::class, 'create'])->name('product.create');
    Route::get('/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('product.edit');
    Route::post('store', [App\Http\Controllers\ProductController::class, 'store'])->name('product.store');
    Route::post('/update/{id}', [App\Http\Controllers\ProductController::class, 'update'])->name('product.update');
    Route::get('/destroy/{id}', [App\Http\Controllers\ProductController::class, 'destroy'])->name('product.destroy');
    Route::get('/datatable-list', [App\Http\Controllers\ProductController::class, 'datatableList'])->name('product.datatable-list');
});
Route::prefix('order')->middleware('auth')->group(function () {
    Route::get('/list', [App\Http\Controllers\OrderController::class, 'index'])->name('order.list');
    Route::get('/create', [App\Http\Controllers\OrderController::class, 'create'])->name('order.create');
    Route::get('/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit'])->name('order.edit');
    Route::post('/store', [App\Http\Controllers\OrderController::class, 'store'])->name('order.store');
    Route::post('/update', [App\Http\Controllers\OrderController::class, 'update'])->name('order.update');
    Route::get('/datatable-list', [App\Http\Controllers\OrderController::class, 'datatableList'])->name('order.datatable-list');
});
Route::prefix('delivery')->middleware('auth')->group(function () {
    Route::get('/list', [App\Http\Controllers\DeliverieController::class, 'index'])->name('delivery.list');
    Route::get('/create', [App\Http\Controllers\DeliverieController::class, 'create'])->name('delivery.create');
    Route::get('/edit/{id}', [App\Http\Controllers\DeliverieController::class, 'edit'])->name('delivery.edit');
    Route::post('store', [App\Http\Controllers\DeliverieController::class, 'store'])->name('delivery.store');
    Route::post('/update/{id}', [App\Http\Controllers\DeliverieController::class, 'update'])->name('delivery.update');
    Route::get('/datatable-list', [App\Http\Controllers\DeliverieController::class, 'datatableList'])->name('delivery.datatable-list');
});
Route::prefix('notification')->middleware('auth')->group(function () {
    Route::get('/list', [App\Http\Controllers\NotificationController::class, 'index'])->name('notification.list');
 });
