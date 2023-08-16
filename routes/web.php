<?php

use App\Http\Controllers\admin\AdminController;
use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\HomeController;
use App\Http\Controllers\admin\OrderController as AdminOrderController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\TempImagesController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\FrontController;
use App\Http\Controllers\OrderController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Str;

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

Route::get('/', [FrontController::class, 'index'])->name('home');

Route::get('cart', [CartController::class, 'index'])->name('cart');
Route::post('add-to-cart', [CartController::class, 'addToCart'])->name('add-cart');
Route::post('update-cart', [CartController::class, 'updateQuantity'])->name('update-cart');
Route::post('remove-cart', [CartController::class, 'remove'])->name('remove-cart');

Route::prefix('user')->name('user.')->group(function () {
    Route::middleware(['guest'])->group(function () {
        Route::get('login', [AuthController::class, 'login'])->name('login');
        Route::post('login', [AuthController::class, 'loginAuthenticate']);
        Route::get('register', [AuthController::class, 'register'])->name('register');
        Route::post('register', [AuthController::class, 'store']);
    });

    Route::middleware(['auth'])->group(function () {
        Route::get('profile', [AuthController::class, 'profile'])->name('profile');
        Route::get('logout', [AuthController::class, 'logout'])->name('logout');
        Route::get('checkout', [CartController::class, 'checkout'])->name('checkout');
        Route::post('checkout', [CheckoutController::class, 'processCheckout']);
        Route::get('thankyou', [CheckoutController::class, 'thankyou'])->name('thankyou');

        Route::get('orders', [OrderController::class, 'index'])->name('orders');
        Route::get('orders-view/{order_id}', [OrderController::class, 'view'])->name('orders-view');
    });
});


Route::prefix('admin')->name('admin.')->group(function () {

    Route::middleware(['admin.guest'])->group(function () {
        Route::get('login', [AdminController::class, 'index']);
        Route::post('login', [AdminController::class, 'authenticate'])->name('login');
    });
        
    Route::middleware(['admin.auth'])->group(function () {
        Route::get('/', [HomeController::class, 'index'])->name('dashboard');
        Route::get('logout', [HomeController::class, 'logout'])->name('logout');

        Route::prefix('category')->name('category.')->group(function () {
            Route::get('create', [CategoryController::class, 'create'])->name('create');
            Route::post('create', [CategoryController::class, 'store']);

            Route::get('edit/{slug}', [CategoryController::class, 'edit'])->name('edit');
            Route::put('update/{slug}', [CategoryController::class, 'update'])->name('update');

            Route::delete('delete/{slug}', [CategoryController::class, 'destroy'])->name('destroy');

            Route::get('create-slug', [CategoryController::class, 'createSlug'])->name('slug');

            Route::get('/', [CategoryController::class, 'index'])->name('index');
            Route::post('upload-temp-image', [TempImagesController::class, 'create'])->name('upload-image');
        });

        Route::prefix('sub-category')->name('subCat.')->group(function () {
            Route::get('/', [SubCategoryController::class, 'index'])->name('index');
            Route::get('create', [SubCategoryController::class, 'create'])->name('create');
            Route::post('create', [SubCategoryController::class, 'store']);

            Route::get('/{sub_id}/edit', [SubCategoryController::class, 'edit'])->name('edit');
            Route::put('/edit/{sub_id}', [SubCategoryController::class, 'update'])->name('update');

            Route::delete('/delete/{sub_id}', [SubCategoryController::class, 'destroy'])->name('destroy');
        });

        Route::prefix('product')->name('product.')->group(function () {
            Route::get('/', [ProductController::class, 'index'])->name('index');
            
            Route::get('create', [ProductController::class, 'create'])->name('create');
            Route::post('create', [ProductController::class, 'store'])->name('create');
            Route::post('create-sub', [ProductController::class, 'getSubCategories'])->name('sub-cat');

            Route::get('edit/{slug}', [ProductController::class, 'edit'])->name('edit');
            Route::put('edit/{slug}', [ProductController::class, 'update'])->name('update');
            Route::delete('delete/{id}', [ProductController::class, 'destroy'])->name('delete');
        });

        Route::get('order', [AdminOrderController::class, 'index'])->name('order');
    });
});

