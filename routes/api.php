<?php

use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\CheckoutController;
use App\Http\Controllers\Api\OrderController as ApiOrderController;
use App\Http\Controllers\Api\ProductController as ApiProductController;
use App\Http\Controllers\Api\RajaOngkirController;
use App\Http\Controllers\Api\SliderController;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Kavist\RajaOngkir\RajaOngkir;

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

// api auth
Route::post('/login',[AuthController::class,'login'])->name('api.customer.login');
Route::post('/register',[AuthController::class,'register'])->name('api.customer.register');
Route::get('/user',[AuthController::class,'getUser'])->name('api.customer.user');

// route api order
Route::get('/order',[ApiOrderController::class,'index'])->name('api.order.index');
Route::get('/order/{snap_token?}',[OrderController::class,'show'])->name('api.order.show');

// route api category
Route::get('/categories',[CategoryController::class,'index'])->name('customer.category.index');
Route::get('/category/{slug?}',[CategoryController::class,'show'])->name('customer.category.show');
Route::get('/categoryHeader',[CategoryController::class,'categoryHeader'])->name('customer.categoryHeader');

// route api product
Route::get('/products',[ApiProductController::class,'index'])->name('customer.product.index');
Route::get('/product/{slug?}',[ApiProductController::class,'show'])->name('customer.product.show');

// route api cart
Route::get('/cart',[CartController::class,'index'])->name('customer.cart.index');
Route::post('/cart',[CartController::class,'store'])->name('customer.cart.store');
Route::get('/cart/total',[CartController::class,'getCartTotal'])->name('customer.cart.total');
Route::get('/cart/totalWeight',[CartController::class,'getCartTotalWeight'])->name('customer.cart.getCartTotalWeight');
Route::post('/cart/remove',[CartController::class,'removeCart'])->name('customer.cart.remove');
Route::post('/cart/removeAll',[CartController::class,'removeAllCart'])->name('customer.cart.removeAll');

// route raja ongkir
Route::get('/rajaongkir/provinces',[RajaOngkirController::class,'getProvinces'])->name('customer.rajaongkir.getProvinces');
Route::get('/rajaongkir/cities',[RajaOngkirController::class,'getCities'])->name('customer.rajaongkir.getCities');
Route::post('/rajaongkir/checkOngkir',[RajaOngkirController::class,'checkOngkir'])->name('customer.rajaongkir.checkOngkir');

// route checkout + midtrans
Route::post('/checkout',[CheckoutController::class,'store'])->name('checkout.store');
Route::post('/notificationHandler',[CheckoutController::class,'notoficationHandler'])->name('notificationHandler');

// route slider
Route::get('/sliders',[SliderController::class,'index'])->name('customer.slider.index');



Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});