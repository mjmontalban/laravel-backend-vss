<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\LoginController;

Route::middleware(['apikey'])->group(function () {
    Route::post('/create_product', [ProductController::class, 'create']);
    Route::get('/fetch_products', [ProductController::class, 'getProducts']);
    Route::delete('/delete_product', [ProductController::class, 'delete']);
    Route::get('/get_product', [ProductController::class, 'get_product']);
}); 

Route::post('/login', [LoginController::class, 'login']);
Route::post('/register', [LoginController::class, 'register']);

 