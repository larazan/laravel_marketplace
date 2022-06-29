<?php

use Illuminate\Support\Facades\Auth;
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
use App\Http\Controllers\Admin\SubscribeController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LogActivityController;
use App\Http\Controllers\Admin\ProductReviewController as ProductReview;
use App\Http\Controllers\Admin\IngredientController;


use App\Http\Controllers\CkeditorFileUploadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController as Product;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\ArticleController as Article;
use App\Http\Controllers\OrderController as Order;
use App\Http\Controllers\UserDashboardController;
use App\Http\Controllers\UserSubscribeController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ProductReviewController;
use App\Http\Controllers\ShopController as Shop;
use App\Http\Controllers\ReceivedController;

use App\Http\Controllers\Dashboard\DashboardController as DDashboard;
use App\Http\Controllers\Dashboard\OrderController as DOrder;
use App\Http\Controllers\Dashboard\OrderOutController;
use App\Http\Controllers\Dashboard\ProductController as DProduct;
use App\Http\Controllers\Dashboard\TransactionController;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\SettingController as DSetting;
use App\Http\Controllers\Dashboard\ShopController as DShop;
use App\Http\Controllers\Dashboard\ShipmentController as DShipment;

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


Route::get('/home', [HomeController::class, 'index'])->name('home');
// Route::get('/produk/{id?}', [HomeController::class, 'index'])->name('home');

// require_once(__DIR__.'/frontend/auth.php');

Route::get('/products', [Product::class, 'index']);
Route::get('/product/{slug}', [Product::class, 'show']);
Route::get('/products/quick-view/{slug}', [Product::class, 'quickView'])->name('quick-view');
Route::get('/produk/json_grid', [Product::class, 'loadBarang'])->name('json_grid');
Route::get('/produk/{id?}', [HomeController::class, 'index'])->name('home');
Route::get('/produk/detail_produk/{slug}', [Product::class, 'detail_produk'])->name('detail_produk');

Route::get('/vendors', [Shop::class, 'index']);
Route::get('/vendor/{slug}', [Shop::class, 'show']);
Route::get('/vendor/produk_grid', [Shop::class, 'loadBarang'])->name('produk_grid');

Route::get('/tes', [Shop::class, 'tes']);

Route::get('/carts', [CartController::class, 'index']);
Route::get('/carts/remove/{cartID}', [CartController::class, 'destroy']);
Route::post('/carts', [CartController::class, 'store']);
Route::post('/carts/add-cart', [CartController::class, 'addCart'])->name('add-cart');
Route::post('/carts/update', [CartController::class, 'update']);
Route::post('/carts/list-produk', [CartController::class, 'listProduk'])->name('list-produk');
Route::post('/carts/delete-list-cart', [CartController::class, 'deleteList'])->name('delete-list-cart');
Route::post('/carts/edit-qty-cart', [CartController::class, 'editQty'])->name('edit-qty-cart');
Route::post('/carts/cek-shop', [CartController::class, 'cekShop'])->name('cek-shop');


Route::group(
	['prefix' => 'wishlist', 'middleware' => ['auth']],
	function () {
		Route::get('/', [FavoriteController::class , 'index']);
		Route::post('/add-product', [FavoriteController::class , 'addProduct'])->name('add-product');
	}
);

Route::group(
	['prefix' => 'orders', 'middleware' => ['auth']],
	function () {
		Route::get('/', [Order::class, 'index']);
	}
);

Route::get('orders/checkout', [Order::class, 'checkout']);
Route::post('orders/checkout', [Order::class, 'doCheckout']);
Route::post('orders/shipping-cost', [Order::class, 'shippingCost']);
Route::post('orders/set-shipping', [Order::class, 'setShipping']);
Route::get('orders/final/{orderID}', [Order::class, 'final']);
Route::get('orders/cities', [Order::class, 'cities']);
// Route::get('orders/clear', [Order::class, 'deleteItems']);
// Route::get('orders', [Order::class, 'index']);
// Route::get('orders/{orderID}', [Order::class, 'show']);

// Route::post('payments/notification', [PaymentController::class, 'notification']);
// Route::get('payments/completed', [PaymentController::class, 'completed']);
// Route::get('payments/failed', [PaymentController::class, 'failed']);
// Route::get('payments/unfinish', [PaymentController::class, 'unfinish']);

Route::resource('favorites', FavoriteController::class);
Route::get('/kirim', [FavoriteController::class, 'kirim']);
Route::get('/tes', [FavoriteController::class, 'tes']);

Route::get('/blogs', [Article::class, 'index']);
Route::get('/blog/{slug}', [Article::class, 'show']);

Route::post('/subscriber', [UserSubscribeController::class, 'postSubscribe']);
Route::post('/check-subscriber-email', [UserSubscribeController::class, 'checkSubscriber']);
Route::post('/add-subscriber-email', [UserSubscribeController::class, 'addSubscriber']);

// Product Review
Route::post('/reviews/create-review', [ProductReviewController::class, 'store'])->name('create-review');

// Route::post('/review', [ReviewController::class, 'postReview']);
// Route::post('/check-reviewer', [ReviewController::class, 'checkReviewer']);
// Route::post('/add-review', [ReviewController::class, 'addReview']);

Route::get('/info', [HomeController::class, 'info']);
Route::get('/contact', [HomeController::class, 'contact']);
Route::get('/about', [HomeController::class, 'about']);
Route::get('/guide', [HomeController::class, 'guide']);
Route::get('/policy', [HomeController::class, 'policy']);
Route::get('/terms', [HomeController::class, 'terms']);
Route::get('/received', [ReceivedController::class, 'index']);
Route::get('/final', [ReceivedController::class, 'final']);

Route::group(
	['prefix' => 'user', 'middleware' => ['auth']],
	function () {
		// Route::get('dashboard', [UserDashboardController::class, 'index']);
		Route::get('dashboard', [DDashboard::class, 'index']);
		Route::get('orders', [DOrder::class, 'index']);
		Route::get('orders/detail/{orderID}', [DOrder::class, 'detail']);
		
		Route::resource('products', DProduct::class);
		Route::get('products/{productID}/images', [DProduct::class, 'images'])->name('products.images');
		Route::get('products/{productID}/add-image', [DProduct::class, 'addImage'])->name('products.add_image');
		Route::post('products/images/{productID}', [DProduct::class , 'uploadImage'])->name('products.upload_image');
		Route::delete('products/images/{imageID}', [DProduct::class , 'removeImage'])->name('products.remove_image');

		Route::get('transactions', [TransactionController::class, 'index']);
		Route::get('transactions/detail/{transactionID}', [TransactionController::class, 'detail']);
		
		Route::get('profile', [ProfileController::class, 'index']);
		Route::get('profile/edit', [ProfileController::class, 'edit']);
		Route::put('profile/update', [ProfileController::class, 'update'])->name('updateProfile');
		Route::get('profile/reset', [ProfileController::class, 'reset']);
		Route::post('profile/change-password', [ProfileController::class, 'changePassword'])->name('changePasswordPost');
		
		Route::get('settings', [SettingController::class, 'index']);
		
		Route::get('shop', [DShop::class, 'index']);
		Route::get('shop/create', [DShop::class, 'create']);
		Route::post('shop/store', [DShop::class, 'store']);
		Route::get('shop/edit', [DShop::class, 'edit']);
		Route::put('shop/update', [DShop::class, 'update'])->name('updateShop');

		Route::get('orders/trashed', [DOrder::class, 'trashed']);
		Route::get('orders/restore/{orderID}', [DOrder::class, 'restore']);
		Route::resource('orders', DOrder::class);
		Route::get('orders/{orderID}/cancel', [DOrder::class, 'cancel']);
		Route::put('orders/cancel/{orderID}', [DOrder::class, 'doCancel']);
		Route::post('orders/complete/{orderID}', [DOrder::class, 'doComplete']);
		Route::post('orders/confirm/{orderID}', [DOrder::class, 'doConfirm']);

		Route::resource('shipments', DShipment::class);

		Route::get('orderout', [OrderOutController::class, 'index']);
		Route::get('orderout/detail/{orderID}', [OrderOutController::class, 'detail']);
		Route::get('orderout/received', [OrderOutController::class, 'received']);
		Route::get('orderout/confirm/{orderID}', [OrderOutController::class, 'confim_paid']);
		Route::post('orderout/confim_paid/{orderID}', [OrderOutController::class, 'doConfirmPaid']);
	}
);

Route::group(
	['prefix' => 'admin', 'middleware' => ['auth', 'admin']],
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
		Route::resource('reviews', ProductReview::class);

		Route::resource('articles', ArticleController::class);
        Route::resource('category_articles', CategoryArticleController::class);
        Route::resource('ingredients', IngredientController::class);
	
		Route::get('subscribes', [SubscribeController::class, 'index']);

		Route::get('setting', [SettingController::class, 'index']);
		Route::get('setting/create', [SettingController::class, 'create']);
		Route::post('setting/store', [SettingController::class, 'store']);
		Route::get('setting/edit', [SettingController::class, 'edit']);
		Route::put('setting/update', [SettingController::class, 'update'])->name('updateSetting');
	
		Route::get('logs', [LogActivityController::class, 'index']);
	}
);

// Route::middleware(['request-header', 'auth-login'])->group(function () {
// 	Route::get('/', [HomeController::class, 'index']);
// });

Route::get('/', [HomeController::class, 'index']);



Route::post('ckeditor', [CkeditorFileUploadController::class, 'store'])->name('ckeditor.upload');

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Auth::routes();
