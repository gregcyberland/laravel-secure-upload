<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\UploadController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
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
});

require __DIR__.'/auth.php';
