<?php

use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\OrderController;
use App\Http\Controllers\Api\v1\ProductController;
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

//Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//    return $request->user();
//});
Route::prefix('user')->group(function () {
    Route::post('/register', [AuthController::class, 'register'])->name('register.api');
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/forget/password', [AuthController::class, 'passwordForget']);
    Route::post('/change/password', [AuthController::class, 'changePassword']);
});
Route::prefix('user')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/details', [AuthController::class, 'details']);
    Route::post('/update/password', [AuthController::class, 'updatePassword']);
    Route::post('/update/profile', [AuthController::class, 'updateProfile'])->name('updateProfile.api');
});
Route::prefix('product')->group(function () {
    Route::get('/list', [ProductController::class, 'index'])->name('product.list');
    Route::get('/details', [ProductController::class, 'show'])->name('product.show');
    Route::get('/search', [ProductController::class, 'search'])->name('product.search');
    Route::get('/filter', [ProductController::class, 'filter'])->name('product.filter');
});
Route::prefix('order')->middleware(['auth:sanctum'])->group(function () {
    Route::get('/list', [OrderController::class, 'index'])->name('order.list');
    Route::get('/filter', [OrderController::class, 'filter'])->name('product.filter');
    Route::post('/create', [OrderController::class, 'create'])->name('order.create');
    Route::post('/edit/{id}', [OrderController::class, 'edit'])->name('order.edit');
});
