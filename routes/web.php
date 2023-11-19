<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages/landing-page');
});

Route::middleware(['auth', 'verified'])->group(function () {
    Route::prefix('admin')->group(function() {
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/product', [ProductController::class, 'index'])->name('product');
        Route::get('/categories', [CategoriesController::class, 'index'])->name('categories');
        Route::get('/blog', [ProductController::class, 'index'])->name('blog');
        Route::get('/user', [UserController::class, 'index'])->name('user');
    });
});

Route::middleware('auth')->group(function () {
    Route::prefix('admin')->group(function() {
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

Route::get('/buyer/login', [HomeController::class, 'login'])->name('login');
Route::get('/buyer/register', [HomeController::class, 'register'])->name('register');
Route::post('/buyer/register', [HomeController::class, 'registerPost'])->name('register');
Route::middleware(['auth', 'user'])->group(function () {
    Route::prefix('buyer')->group(function() {
        Route::get('/cart', [HomeController::class, 'cart'])->name('cart');
        Route::get('/checkout', [HomeController::class, 'checkout'])->name('checkout');
        Route::get('/wishlist', [HomeController::class, 'wishlist'])->name('wishlist');
        Route::get('/profile', [HomeController::class, 'profile'])->name('profile');
        Route::get('/profile/info', [HomeController::class, 'information'])->name('information');
        // Route::get('/profile/order', [HomeController::class, 'order'])->name('order');
    });
});

require __DIR__.'/auth.php';
