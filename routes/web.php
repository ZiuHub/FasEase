<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Password;
use App\Http\Controllers\ResetController;
use App\Http\Controllers\InfoUserController;
use App\Http\Controllers\RegisterController;
use App\Http\Controllers\SessionsController;
use App\Http\Controllers\Item\ItemController;
use App\Http\Controllers\User\UserController;
use App\Http\Controllers\ChangePasswordController;
use App\Http\Controllers\Category\CategoryController;
use App\Http\Controllers\Organization\OrganizationController;

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



Route::group(['middleware' => 'auth'], function () {

    Route::get('/', [HomeController::class, 'home']);
	Route::get('dashboard', function () {
		return view('dashboard');
	})->name('dashboard');

	Route::get('billing', function () {
		return view('billing');
	})->name('billing');

	Route::get('profile', function () {
		return view('profile');
	})->name('profile');

	Route::group(['middleware' => 'superadmin'], function () {
		// User management
		Route::get('user-management', [UserController::class, 'index'])->name('user-management-index');
		Route::get('user-management/create', [UserController::class, 'create'])->name('user-management-create');
		Route::post('user-management/create', [UserController::class, 'store'])->name('user-management-store');
		Route::get('user-management/{id}/edit', [UserController::class, 'edit'])->name('user-management-edit');
		Route::put('user-management/{id}/edit', [UserController::class, 'update'])->name('user-management-update');
		Route::delete('user-management/{id}/delete', [UserController::class, 'destroy'])->name('user-management-destroy');

		// Organization management
		Route::get('organization-management', [OrganizationController::class, 'index'])->name('organization-management-index');
		Route::get('organization-management/create', [OrganizationController::class, 'create'])->name('organization-management-create');
		Route::post('organization-management/create', [OrganizationController::class, 'store'])->name('organization-management-store');
		Route::get('organization-management/{slug}/edit', [OrganizationController::class, 'edit'])->name('organization-management-edit');
		Route::put('organization-management/{slug}/edit', [OrganizationController::class, 'update'])->name('organization-management-update');
		Route::delete('organization-management/{slug}/delete', [OrganizationController::class, 'destroy'])->name('organization-management-destroy');
	});

	Route::prefix('org/{organization:slug}')
		->middleware(['tenant'])
		->group(function () {
		Route::get('dashboard', [HomeController::class, 'home'])->name('org.dashboard');

		Route::group(['middleware' => 'admin'], function () {
			// Category management
			Route::get('category-management', [CategoryController::class, 'index'])->name('org.category-management-index');
			Route::get('category-management/create', [CategoryController::class, 'create'])->name('org.category-management-create');
			Route::post('category-management/create', [CategoryController::class, 'store'])->name('org.category-management-store');
			Route::get('category-management/{slug}/edit', [CategoryController::class, 'edit'])->name('org.category-management-edit');
			Route::put('category-management/{slug}/edit', [CategoryController::class, 'update'])->name('org.category-management-update');
			Route::delete('category-management/{slug}/delete', [CategoryController::class, 'destroy'])->name('org.category-management-destroy');

			// Item management
			Route::get('item-management', [ItemController::class, 'index'])->name('org.item-management-index');
			Route::get('item-management/create', [ItemController::class, 'create'])->name('org.item-management-create');
			Route::post('item-management/create', [ItemController::class, 'store'])->name('org.item-management-store');
			Route::get('item-management/{slug}/edit', [ItemController::class, 'edit'])->name('org.item-management-edit');
			Route::put('item-management/{slug}/edit', [ItemController::class, 'update'])->name('org.item-management-update');
			Route::delete('item-management/{slug}/delete', [ItemController::class, 'destroy'])->name('org.item-management-destroy');
		});
	});

	Route::get('tables', function () {
		return view('tables');
	})->name('tables');

    Route::get('/logout', [SessionsController::class, 'destroy']);
	Route::get('/user-profile', [InfoUserController::class, 'create']);
	Route::post('/user-profile', [InfoUserController::class, 'store']);
    Route::get('/login', function () {
		return view('dashboard');
	})->name('sign-up');
});


// Global auth
Route::group(['middleware' => 'guest'], function () {
    Route::get('/register', [RegisterController::class, 'create']);
    Route::post('/register', [RegisterController::class, 'store']);
    Route::get('/login', [SessionsController::class, 'create']);
    Route::post('/session', [SessionsController::class, 'store']);
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])->name('password.reset');
	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])->name('password.update');

});

// Tenant/organization auth
Route::prefix('org/{organization:slug}')
    ->middleware(['guest', 'tenant'])
    ->group(function () {

	// REGISTER
	Route::get('/register', [RegisterController::class, 'create'])
		->name('org.register');
	Route::post('/register', [RegisterController::class, 'store']);

	// LOGIN
	Route::get('/login', [SessionsController::class, 'create'])
		->name('org.login');
	Route::post('/session', [SessionsController::class, 'store']);

	// FORGOT PASSWORD
	Route::get('/login/forgot-password', [ResetController::class, 'create']);
	Route::post('/forgot-password', [ResetController::class, 'sendEmail']);

	// RESET PASSWORD
	Route::get('/reset-password/{token}', [ResetController::class, 'resetPass'])
		->name('password.reset');

	Route::post('/reset-password', [ChangePasswordController::class, 'changePassword'])
		->name('password.update');
});


Route::get('/login', function () {
    return view('session/login-session');
})->name('login');