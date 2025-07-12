<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AdminPayouts;
use App\Http\Controllers\Admin\AdminsController;
use App\Http\Controllers\Admin\EmployeesController;
use App\Http\Controllers\Admin\PayoutRequestsController;
use App\Http\Controllers\Admin\PdfController;
use App\Http\Controllers\Admin\ReferrerController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use Illuminate\Support\Facades\Route;

   // For running command
    Route::post('/run-hours-command', [SettingsController::class, 'runCommand'])->name('run.command');

    // Forgot password request
    Route::controller(ForgotPasswordController::class)->group(function () {
        Route::get('/forgot-password', 'showLinkRequestForm')->name('forgot.password');
        Route::post('/forgot-password', 'sendResetLinkEmail')->name('password.email');
    });
    // Password reset form
    Route::controller(ResetPasswordController::class)->group(function () {
        Route::get('/reset-password/{token}', 'showResetForm')->name('password.reset');
        Route::post('/reset-password', 'reset')->name('password.update');
    });

    
// === ADMIN ROUTES ===
Route::group(['middleware' => ['admin']], function () {

    Route::controller(AdminController::class)->group(function () {
        Route::get('/admin', 'index')->name('admin.index');
        Route::get('/profile', 'profile')->name('admin.profile');
        Route::post('/profile-save', 'saveProfile')->name('admin.profile.save');
        Route::post('/change-password', 'changePassword')->name('password.change');
    });

    Route::resource('referrers', ReferrerController::class);
    Route::controller(PdfController::class)->group(function(){
        Route::get('/download-pdf','downloadPDF')->name('download.pdf');
    });
    Route::resource('employees', EmployeesController::class);
    Route::get('employees/{employee}/connecteam-user', [EmployeesController::class, 'getConnecteamUser'])
     ->name('employees.connecteam.user');

    Route::resource('admins', AdminsController::class);
    Route::resource('settings', SettingsController::class);
    Route::post('settings/sync-env', [SettingsController::class, 'syncEnv'])->name('settings.syncEnv');

    Route::controller(PayoutRequestsController::class)->group(function () {
        Route::get('/pending-payout-requests', 'pending')->name('pending-payouts');
        Route::get('/approved-payout-requests', 'approved')->name('approved-payouts');
        Route::get('/rejected-payout-requests', 'rejected')->name('rejected-payouts');

        Route::get('/approve-request/{id}', 'approve_request')->name('request.approve');
        Route::get('/pending-request/{id}', 'pending_request')->name('request.pending');
        Route::get('/reject-request/{id}', 'reject_request')->name('request.reject');
        Route::post('/update-request/{id}', 'update_request')->name('request.update');
        Route::delete('/delete-request/{id}', 'delete_request')->name('request.delete');
    });
});
