<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PersonController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ShoppingCartController;
use App\Http\Controllers\OrderHistoryController;

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

Route::post('/add_person', [PersonController::class, 'add_person']);
Route::get('/get_person', [PersonController::class, 'get_person']);
Route::post('/update_person', [PersonController::class, 'update_person']);
Route::post('/delete_person', [PersonController::class, 'delete_person']);
Route::post('/create_product', [ProductController::class, 'create_product']);
Route::post('/delete_product', [ProductController::class, 'delete_product']);
Route::post('/update_product', [ProductController::class, 'update_product']);
Route::get('/get_all_products', [ProductController::class, 'get_all_products']);
Route::get('/get_product', [ProductController::class, 'get_product']);
Route::get('/get_shopping_cart', [ShoppingCartController::class, 'get_shopping_cart']);
Route::post('/create_update_shopping_cart', [ShoppingCartController::class, 'create_update_shopping_cart']);
Route::post('/delete_shopping_cart', [ShoppingCartController::class, 'delete_shopping_cart']);
Route::get('/get_order_history', [OrderHistoryController::class, 'get_order_history']);
Route::post('/create_order_history', [OrderHistoryController::class, 'create_order_history']);
Route::post('/delete_order_history', [OrderHistoryController::class, 'delete_order_history']);
Route::get('/get_order_history', [OrderHistoryController::class, 'get_order_history']);

