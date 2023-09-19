<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\Cms\Article\CategoryController as ArticleCategoryController;
use App\Http\Controllers\Cms\Article\TagController as ArticleTagController;
use App\Http\Controllers\Cms\Article\DataController as ArticleDataController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Cms\DashboardController;
use App\Http\Controllers\Cms\MenuController;
use App\Http\Controllers\Cms\PermissionController;
use App\Http\Controllers\Cms\ProfileController;
use App\Http\Controllers\Cms\RoleController;
use App\Http\Controllers\Cms\UserController;
use App\Http\Controllers\Cms\WebsiteController;
use Illuminate\Support\Facades\Auth;

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


Route::prefix('cms')->middleware('auth')->group(function(){
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

    Route::get('trashed/menus', [MenuController::class, 'trashed'])->name('menus.trashed');
    Route::post('trashed/menus', [MenuController::class, 'storeTrashed'])->name('menus.trashed.store');
    Route::get('sorting/menus', [MenuController::class, 'sorting'])->name('menus.sorting');
    Route::post('sorting/menus', [MenuController::class, 'storeSorting'])->name('menus.sorting.store');
    Route::resource('menus', MenuController::class);

    Route::resource('roles', RoleController::class);

    Route::resource('website', WebsiteController::class);

    Route::get('trashed/users', [UserController::class, 'trashed'])->name('users.trashed');
    Route::post('trashed/users', [UserController::class, 'storeTrashed'])->name('users.trashed.store');
    Route::resource('users', UserController::class);

    Route::resource('permissions', PermissionController::class);
    Route::get('roles/permission/{any}', [RoleController::class, 'permission'])->name('roles.permission');
    Route::post('roles.storePermission', [RoleController::class, 'storePermission'])->name('roles.storePermission');

    Route::get('profile', [ProfileController::class, 'index'])->name('profile');
    Route::post('profile', [ProfileController::class, 'store'])->name('profile.store');
    Route::post('profile/change/{any}', [ProfileController::class, 'change'])->name('profile.change');

    Route::prefix('article')->group(function(){
        Route::resource('article-category', ArticleCategoryController::class);
        Route::resource('article-tag', ArticleTagController::class);
        Route::post('data-article/trashed', [ArticleDataController::class, 'storeTrashed'])->name('data-article.trashed.store');
        Route::resource('data-article', ArticleDataController::class);
    });
});

Route::get('login', [AuthController::class, 'index'])->name('login');
Route::POST('login.do', [AuthController::class, 'doLogin'])->name('login.do');
Route::get('register', [AuthController::class, 'register'])->name('register');
Route::POST('register.do', [AuthController::class, 'doRegister'])->name('register.do');

Route::get('logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/', [AuthController::class, 'index']);
