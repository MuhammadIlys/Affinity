<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\StaffController;
use App\Http\Controllers\Admin\SystemUserController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TestingController;
use App\Http\Controllers\User\PayoutController;
use App\Http\Controllers\User\ReferredUsersController;
use App\Http\Controllers\User\StaffController as UserStaffController;
use App\Http\Controllers\User\SystemUserController as UserSystemUserController;
use App\Http\Controllers\User\UserController as UserUserController;
use App\Http\Controllers\User\UserController;
use App\Models\SystemUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/testing', [TestingController::class, 'index'])->name('testing');

// === AUTH ROUTES ===
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register-store', [RegisterController::class, 'store'])->name('register.store');
Route::get('/', [LoginController::class, 'index'])->name('login');
Route::post('/user-login', [LoginController::class, 'login'])->name('user.login');
Route::get('/logout', [LogoutController::class, 'logout'])->name('logout');


// === USER ROUTES ===
Route::group(['middleware' => ['auth', 'user']], function () {

    Route::controller(UserController::class)->group(function(){
        Route::get('/user','index')->name('user.index');
        Route::post('/user-profile-image-save', 'saveProfileImage')->name('user.profile.image.save');
    });

    Route::controller(ReferredUsersController::class)->group(function(){
        Route::get('/referred-users','referredUsers')->name('referrer.users');
    });

    Route::controller(PayoutController::class)->prefix('payouts')->group(function(){
        Route::get('/','index')->name('payout.index');
        Route::get('/pending','pending')->name('payout.pending');
        Route::get('/completed','completed')->name('payout.completed');
        Route::get('/rejected','rejected')->name('payout.rejected');
        Route::post('/request-payout','requestPayout')->name('payout.request');
        Route::delete('/delete-payout/{id}', 'delete_payout')->name('payout.delete');

    });

});


require __DIR__ . '/admin.php';
