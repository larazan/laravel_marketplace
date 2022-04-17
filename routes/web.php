<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryArticleController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\ShipmentController;
use App\Http\Controllers\Admin\SlideController;
use App\Http\Controllers\Admin\ShopController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CkeditorFileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ArticleController as Article;
use App\Http\Controllers\OrderController as Order;

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

Route::get('/', [HomeController::class, 'index']);
Route::get('/home', [HomeController::class, 'index'])->name('home');

// require_once(__DIR__.'/frontend/auth.php');

Route::get('/products', [Product::class, 'index']);
Route::get('/product/{slug}', [Product::class, 'show']);
Route::get('/products/quick-view/{slug}', [Product::class, 'quickView'])->name('quick-view');
Route::get('/produk/json_grid', [Product::class, 'loadBarang'])->name('json_grid');

// Route::get('/carts', [CartController::class, 'index']);
// Route::get('/carts/remove/{cartID}', [CartController::class, 'destroy']);
// Route::post('/carts', [CartController::class, 'store']);
// Route::post('/carts/update', [CartController::class, 'update']);

// Route::get('orders/checkout', [Order::class, 'checkout']);
// Route::post('orders/checkout', [Order::class, 'doCheckout']);
// Route::post('orders/shipping-cost', [Order::class, 'shippingCost']);
// Route::post('orders/set-shipping', [Order::class, 'setShipping']);
// Route::get('orders/received/{orderID}', [Order::class, 'received']);
// Route::get('orders/cities', [Order::class, 'cities']);
// Route::get('orders', [Order::class, 'index']);
// Route::get('orders/{orderID}', [Order::class, 'show']);

// Route::post('payments/notification', [PaymentController::class, 'notification']);
// Route::get('payments/completed', [PaymentController::class, 'completed']);
// Route::get('payments/failed', [PaymentController::class, 'failed']);
// Route::get('payments/unfinish', [PaymentController::class, 'unfinish']);

// Route::resource('favorites', [FavoriteController::class]);

Route::get('/blogs', [Article::class, 'index']);
Route::get('/blog/{slug}', [Article::class, 'show']);

Route::group(
	['prefix' => 'admin', 'middleware' => ['auth']],
	function () {
		Route::get('dashboard', [DashboardController::class, 'index']);
		Route::resource('categories', CategoryController::class);

		Route::resource('products', ProductController::class);
		Route::get('products/{productID}/images', [ProductController::class, 'images'])->name('products.images');
		Route::get('products/{productID}/add-image', [ProductController::class, 'addImage'])->name('products.add_image');
		Route::post('products/images/{productID}', [ProductController::class , 'uploadImage'])->name('products.upload_image');
		Route::delete('products/images/{imageID}', [ProductController::class , 'removeImage'])->name('products.remove_image');

		Route::resource('attributes', AttributeController::class);
		Route::get('attributes/{attributeID}/options', [AttributeController::class, 'options'])->name('attributes.options');
		Route::get('attributes/{attributeID}/add-option', [AttributeController::class, 'add_option'])->name('attributes.add_option');
		Route::post('attributes/options/{attributeID}', [AttributeController::class, 'store_option'])->name('attributes.store_option');
		Route::delete('attributes/options/{optionID}', [AttributeController::class, 'remove_option'])->name('attributes.remove_option');
		Route::get('attributes/options/{optionID}/edit', [AttributeController::class, 'edit_option'])->name('attributes.edit_option');
		Route::put('attributes/options/{optionID}', [AttributeController::class, 'update_option'])->name('attributes.update_option');
	
		Route::resource('roles', RoleController::class);
		Route::resource('users', UserController::class);

		Route::get('orders/trashed', [OrderController::class, 'trashed']);
		Route::get('orders/restore/{orderID}', [OrderController::class, 'restore']);
		Route::resource('orders', OrderController::class);
		Route::get('orders/{orderID}/cancel', [OrderController::class, 'cancel']);
		Route::put('orders/cancel/{orderID}', [OrderController::class, 'doCancel']);
		Route::post('orders/complete/{orderID}', [OrderController::class, 'doComplete']);

		Route::resource('shipments', ShipmentController::class);

		Route::resource('slides', SlideController::class);
		Route::get('slides/{slideID}/up', [SlideController::class , 'moveUp']);
		Route::get('slides/{slideID}/down', [SlideController::class , 'moveDown']);

		Route::get('reports/revenue', [ReportController::class , 'revenue']);
		Route::get('reports/product', [ReportController::class , 'product']);
		Route::get('reports/inventory', [ReportController::class , 'inventory']);
		Route::get('reports/payment', [ReportController::class , 'payment']);

		Route::resource('brands', BrandController::class);
		Route::resource('shops', ShopController::class);

		Route::resource('articles', ArticleController::class);
        Route::resource('category_articles', CategoryArticleController::class);

		
	}
);

// Route::group(
// 	['prefix' => 'produk', 'middleware' => ['auth']],
// 	function () {
// 		Route::get('json_grid', [Product::class , 'loadBarang']);
// 	}
// );

Route::post('ckeditor', [CkeditorFileUploadController::class, 'store'])->name('ckeditor.upload');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
