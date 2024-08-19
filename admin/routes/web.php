<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\MenuController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdProductController;
use App\Http\Controllers\AdminRoleController;
use App\Http\Controllers\AdminPermissionController;
use App\Http\Controllers\AdSliderController;
use App\Http\Controllers\AdSettingController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminCartController;



Route::get('/admin', [AdminController::class,'login']);
Route::post('/admin', [AdminController::class,'loginAdmin']);

Route::get('/home', function () {
    return view('home');
});
Route::group(['prefix' => 'laravel-filemanager', 'middleware' => ['web', 'auth']], function () {
    \UniSharp\LaravelFilemanager\Lfm::routes();
});
Route::prefix('admin')->group(function () {
    Route::prefix('carts')->group(function () {
        Route::get('/', [AdminCartController::class, 'index'])->name('carts.index');
        Route::get('/show/{id}', [AdminCartController::class, 'show'])->name('carts.show');
    });
Route::prefix('categories')->group(function () {
    Route::get('/', [CategoryController::class, 'index'])->name('categories.index')->middleware('can:category-list');
    Route::get('/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('can:category-add');
    Route::post('/store', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('/edit/{id}', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('can:category-edit');
    Route::post('/update/{id}', [CategoryController::class, 'update'])->name('categories.update');
    Route::get('/delete/{id}', [CategoryController::class, 'delete'])->name('categories.delete')->middleware('can:category-delete');



});
Route::prefix('menus')->group(function () {
    Route::get('/', [MenuController::class, 'index'])->name('menus.index')->middleware('can:menu-list');
    Route::get('/create', [MenuController::class, 'create'])->name('menus.create')->middleware('can:menu-add');
    Route::post('/store', [MenuController::class, 'store'])->name('menus.store');
    Route::get('/edit/{id}', [MenuController::class, 'edit'])->name('menus.edit')->middleware('can:menu-edit');
    Route::post('/update/{id}', [MenuController::class, 'update'])->name('menus.update');
    Route::get('/delete/{id}', [MenuController::class, 'delete'])->name('menus.delete')->middleware('can:menu-delete');
});
Route::prefix('products')->group(function () {
    Route::get('/', [AdProductController::class, 'index'])->name('products.index')->middleware('can:product-list');;
    Route::get('/create', [AdProductController::class, 'create'])->name('products.create')->middleware('can:product-add');;
    Route::post('/store', [AdProductController::class, 'store'])->name('products.store');
    Route::get('/edit/{id}', [AdProductController::class, 'edit'])->name('products.edit')->middleware('can:product-edit,id');;
    Route::post('/update/{id}', [AdProductController::class, 'update'])->name('products.update');
    Route::get('/delete/{id}', [AdProductController::class, 'delete'])->name('products.delete')->middleware('can:product-delete,id');;
});

Route::prefix('slider')->group(function () {
    Route::get('/', [AdSliderController::class, 'index'])->name('sliders.index')->middleware('can:slider-list');
    Route::get('/create', [AdSliderController::class, 'create'])->name('sliders.create')->middleware('can:slider-add');
    Route::post('/store', [AdSliderController::class, 'store'])->name('sliders.store');
    Route::get('/edit/{id}', [AdSliderController::class, 'edit'])->name('sliders.edit')->middleware('can:slider-edit');
    Route::post('/update/{id}', [AdSliderController::class, 'update'])->name('sliders.update');
    Route::get('/delete/{id}', [AdSliderController::class, 'delete'])->name('sliders.delete')->middleware('can:slider-delete');
});

Route::prefix('settings')->group(function () {
    Route::get('/', [AdSettingController::class, 'index'])->name('settings.index')->middleware('can:setting-list');
    Route::get('/create', [AdSettingController::class, 'create'])->name('settings.create')->middleware('can:setting-add');
    Route::post('/store', [AdSettingController::class, 'store'])->name('settings.store');
    Route::get('/edit/{id}', [AdSettingController::class, 'edit'])->name('settings.edit')->middleware('can:setting-edit');
    Route::post('/update/{id}', [AdSettingController::class, 'update'])->name('settings.update');
    Route::get('/delete/{id}', [AdSettingController::class, 'delete'])->name('settings.delete')->middleware('can:setting-delete');
});

Route::prefix('users')->group(function () {
    Route::get('/', [AdminUserController::class, 'index'])->name('users.index');
    Route::get('/create', [AdminUserController::class, 'create'])->name('users.create');
    Route::post('/store', [AdminUserController::class, 'store'])->name('users.store');
    Route::get('/edit/{id}', [AdminUserController::class, 'edit'])->name('users.edit');
    Route::post('/update/{id}', [AdminUserController::class, 'update'])->name('users.update');
    Route::get('/delete/{id}', [AdminUserController::class, 'delete'])->name('users.delete');
});

Route::prefix('roles')->group(function () {
    Route::get('/', [AdminRoleController::class, 'index'])->name('roles.index');
    Route::get('/create', [AdminRoleController::class, 'create'])->name('roles.create');
    Route::post('/store', [AdminRoleController::class, 'store'])->name('roles.store');
    Route::get('/edit/{id}', [AdminRoleController::class, 'edit'])->name('roles.edit');
    Route::post('/update/{id}', [AdminRoleController::class, 'update'])->name('roles.update');
    Route::get('/delete/{id}', [AdminRoleController::class, 'delete'])->name('roles.delete')->middleware('can:role-delete');
});
Route::prefix('permissions')->group(function () {
    Route::get('/', [AdminPermissionController::class, 'index'])->name('permissions.index');
    Route::get('/', [AdminPermissionController::class, 'create'])->name('permissions.create');
    Route::post('/store', [AdminPermissionController::class, 'store'])->name('permissions.store');
    Route::get('/edit/{id}', [AdminPermissionController::class, 'edit'])->name('permissions.edit');
    Route::post('/update/{id}', [AdminPermissionController::class, 'update'])->name('permissions.update');
    Route::get('/delete/{id}', [AdminPermissionController::class, 'delete'])->name('permissions.delete');
});
});



