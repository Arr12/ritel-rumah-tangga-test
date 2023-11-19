<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\FilesController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\WishlistController;
use App\Http\Controllers\ShippingAddressController;
use App\Http\Controllers\ProductControllerAuthenticatedSessionController;
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
Route::get('claim-jwt-token', [AuthenticatedSessionController::class, 'show_jwt_token']);

Route::get('products', [ProductController::class, 'show']);
Route::get('products/{id}', [ProductController::class, 'edit']);

Route::get('categories', [CategoriesController::class, 'show']);
Route::get('categories/{id}', [CategoriesController::class, 'edit']);

Route::post('buyer/login', [HomeController::class, 'loginRequest']);

Route::middleware('jwt')->group(function () {
    Route::prefix('products')->group(function(){
        Route::post('/', [ProductController::class, 'store']);
        Route::put('/{id}', [ProductController::class, 'update']);
        Route::delete('/{id}', [ProductController::class, 'destroy']);
        Route::post('uploads/', [FilesController::class, 'store']);
    });
    Route::prefix('shipping-address')->group(function(){
        Route::get('/', [ShippingAddressController::class, 'show']);
        Route::get('/{id}', [ShippingAddressController::class, 'edit']);
        Route::post('/', [ShippingAddressController::class, 'store']);
        Route::put('/{id}', [ShippingAddressController::class, 'update']);
        Route::delete('/{id}', [ShippingAddressController::class, 'destroy']);
    });
    Route::prefix('categories')->group(function(){
        Route::post('/', [CategoriesController::class, 'store']);
        Route::put('/{id}', [CategoriesController::class, 'update']);
        Route::delete('/{id}', [CategoriesController::class, 'destroy']);
        Route::post('uploads/', [FilesController::class, 'store']);
    });
    Route::prefix('wishlist')->group(function(){
        Route::get('/', [WishlistController::class, 'show']);
        Route::get('/{id}', [WishlistController::class, 'edit']);
        Route::post('/', [WishlistController::class, 'store']);
        Route::put('/{id}', [WishlistController::class, 'update']);
        Route::delete('/{id}', [WishlistController::class, 'destroy']);
    });
    Route::prefix('cart')->group(function(){
        Route::get('/', [CheckoutController::class, 'show']);
        Route::get('/{id}', [CheckoutController::class, 'edit']);
        Route::post('/', [CheckoutController::class, 'store']);
        Route::put('/{id}', [CheckoutController::class, 'update']);
        Route::delete('/{id}', [CheckoutController::class, 'destroy']);
    });
    Route::prefix('checkout')->group(function(){
        Route::get('/', [CheckoutController::class, 'show']);
        Route::get('/{id}', [CheckoutController::class, 'edit']);
        Route::post('/', [CheckoutController::class, 'store']);
        Route::put('/{id}', [CheckoutController::class, 'update']);
        Route::delete('/{id}', [CheckoutController::class, 'destroy']);
    });
    Route::prefix('buyer')->group(function(){
        Route::get('/', [BuyerController::class, 'show']);
        Route::get('/{id}', [BuyerController::class, 'edit']);
        Route::post('/', [BuyerController::class, 'store']);
        Route::put('/{id}', [BuyerController::class, 'update']);
        Route::delete('/{id}', [BuyerController::class, 'destroy']);
    });
    Route::prefix('users')->group(function(){
        Route::get('/', [UserController::class, 'show']);
        Route::get('/{id}', [UserController::class, 'edit']);
        Route::post('/', [UserController::class, 'store']);
        Route::put('/', [UserController::class, 'update']);
        Route::delete('/{id}', [UserController::class, 'destroy']);
    });
    // Route::prefix('blogs')->group(function(){
    //     Route::get('/', [ProductController::class, 'show']);
    //     Route::get('/{id}', [ProductController::class, 'edit']);
    //     Route::post('/', [ProductController::class, 'store']);
    //     Route::put('/{id}', [ProductController::class, 'update']);
    //     Route::delete('/{id}', [ProductController::class, 'destroy']);
    // });
});

