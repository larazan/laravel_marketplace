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
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CkeditorFileUploadController;

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
    return view('welcome');
});

Route::group(
	['prefix' => 'admin'],
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

		Route::resource('articles', ArticleController::class);
        Route::resource('category_articles', CategoryArticleController::class);

		
	}
);

Route::post('ckeditor', [CkeditorFileUploadController::class, 'store'])->name('ckeditor.upload');


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
