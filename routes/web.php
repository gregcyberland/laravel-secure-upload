<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StaffApprove;
use App\Http\Controllers\StaffController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/testpass', function () {
    echo md5('admin');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {

    Route::get('/myuploads', [UploadController::class, 'index'])->name('upload.index');
    Route::post('/myuploads', [UploadController::class, 'store'])->name('upload.store');
    Route::post('/myuploads', [UploadController::class, 'store'])->name('upload.store');
    Route::get('/myuploads/show/{id}', [UploadController::class, 'show'])->name('upload.show');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/product/create', [ProductController::class, 'create'])->name('product.create');
    Route::get('/product/details/{id}', [ProductController::class, 'details'])->name('product.details');
    Route::get('/product/update/{id}', [ProductController::class, 'update'])->name('product.update');

    //admin
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.index');
    Route::get('/admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('/admin/settings', [AdminController::class, 'uppdateLinkExpiration'])->name('admin.settings.link.post');
    Route::post('/admin/addtime', [AdminController::class, 'addtime'])->name('admin.addtime');
    Route::get('/admin/killall', [AdminController::class, 'killAll'])->name('admin.killall');
    Route::post('/admin/killall', [AdminController::class, 'logoutAll'])->name('admin.logoutAll');
    //staff
    Route::get('/staff', [StaffController::class, 'index'])->name('staff.index');
    Route::get('/staff/history', [StaffController::class, 'history'])->name('staff.history');
    Route::post('/staff/endsession', [StaffController::class, 'endsession'])->name('staff.endsession');
    Route::post('/staff', [StaffController::class, 'store'])->name('staff.store');

});


Route::get('/staff/approve/{link}', [StaffApprove::class, 'approve'])->name('staff.approve');

require __DIR__.'/auth.php';
