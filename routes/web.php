<?php

use App\Http\livewire\HomeComponent;
use App\Http\livewire\ShopComponent;
use App\Http\livewire\CartComponent;
use App\Http\livewire\CheckoutComponent;
use App\Http\livewire\DetailsComponent;
use App\Http\livewire\CategoryComponent;
use App\Http\livewire\SearchComponent;
use App\Http\livewire\WishlistComponent;
use App\Http\livewire\ThankyouComponent;

use App\Http\livewire\admin\AdminDashboardComponent;
use App\Http\livewire\admin\AdminCategoryComponent;
use App\Http\livewire\admin\AdminAddCategoryComponent;
use App\Http\livewire\admin\AdminEditCategoryComponent;
use App\Http\livewire\admin\AdminProductComponent;
use App\Http\livewire\admin\AdminAddProductComponent;
use App\Http\livewire\admin\AdminEditProductComponent;
use App\Http\livewire\admin\AdminHomeSliderComponent;
use App\Http\livewire\admin\AdminAddHomeSliderComponent;
use App\Http\livewire\admin\AdminEditHomeSliderComponent;
use App\Http\livewire\admin\AdminHomeCategoryComponent;
use App\Http\livewire\admin\AdminCouponsComponent;
use App\Http\livewire\admin\AdminAddCouponsComponent;
use App\Http\livewire\admin\AdminEditCouponsComponent;
use App\Http\livewire\admin\AdminSaleComponent;
use App\Http\livewire\admin\AdminOrderComponent;
use App\Http\livewire\admin\AdminOrderDetailsComponent;

use App\Http\livewire\user\UserDashboardComponent;
use App\Http\livewire\user\UserOrderComponent;
use App\Http\livewire\user\UserOrderDetailsComponent;

use Illuminate\Support\Facades\Route;

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

Route::get('/', HomeComponent::class);

Route::get('/shop', ShopComponent::class);

Route::get('/cart', CartComponent::class)->name('product.cart');

Route::get('/checkout', CheckoutComponent::class)->name('checkout');

Route::get('/product/{slug}', DetailsComponent::class)->name('product.details');

Route::get('/product-category/{category_slug}', CategoryComponent::class)->name('product.category');

Route::get('/search', SearchComponent::class)->name('product.search');

Route::get('/wishlist', WishlistComponent::class)->name('product.wishlist');

Route::get('/thank-you', ThankyouComponent::class)->name('thankyou');

// Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
//     return view('dashboard');
// })->name('dashboard');


// For Admin
Route::middleware(['auth:sanctum', 'verified', 'AuthAdmin'])->group(function() {
    Route::get('/admin/dashboard', AdminDashboardComponent::class)->name('admin.dashboard');

    //Admin catogaries routes
    Route::get('/admin/categories', AdminCategoryComponent::class)->name('admin.categories');
    Route::get('/admin/category/add', AdminAddCategoryComponent::class)->name('admin.addcategory');
    Route::get('/admin/category/edit/{category_slug}', AdminEditCategoryComponent::class)->name('admin.editcategory');
    Route::get('/admin/category/delete/{category_id}', AdminEditCategoryComponent::class)->name('admin.deletecategory');

    //Admin Products routes
    Route::get('/admin/products', AdminProductComponent::class)->name('admin.products');
    Route::get('/admin/products/add', AdminAddProductComponent::class)->name('admin.addproducts');
    Route::get('/admin/products/edit/{product_slug}', AdminEditProductComponent::class)->name('admin.editproduct');

    //Admin Home slider routes
    Route::get('/admin/slider', AdminHomeSliderComponent::class)->name('admin.homeslider');
    Route::get('/admin/slider/add', AdminAddHomeSliderComponent::class)->name('admin.addhomeslider');
    Route::get('/admin/slider/edit/{slide_id}', AdminEditHomeSliderComponent::class)->name('admin.edithomeslider');
    Route::get('/admin/slider/delete/{slide_id}', AdminEditHomeSliderComponent::class)->name('admin.deletehomeslider');

    Route::get('/admin/home-categories', AdminHomeCategoryComponent::class)->name('admin.homecategories');
    Route::get('/admin/sale', AdminSaleComponent::class)->name('admin.sale');

    //Admin coupons routes
    Route::get('/admin/coupons', AdminCouponsComponent::class)->name('admin.coupons');
    Route::get('/admin/coupons/add', AdminAddCouponsComponent::class)->name('admin.addcoupons');
    Route::get('/admin/coupons/edit/{coupon_id}', AdminEditCouponsComponent::class)->name('admin.editcoupons');

    Route::get('/admin/orders', AdminOrderComponent::class)->name('admin.orders');
    Route::get('/admin/orders/{order_id}', AdminOrderDetailsComponent::class)->name('admin.orderdetails');

});

// For User or Customer
Route::middleware(['auth:sanctum', 'verified', ])->group(function() {
    Route::get('/user/dashboard', UserDashboardComponent::class)->name('user.dashboard');

    Route::get('/user/orders', UserOrderComponent::class)->name('user.orders');
    Route::get('/user/order/{order_id}', UserOrderDetailsComponent::class)->name('user.orderdetails');
});
