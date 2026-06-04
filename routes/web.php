<?php

use App\Http\Controllers\TaskController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

Route::middleware(['auth'])->name('tasks.')->group(function () {
    Route::get('/', [TaskController::class, 'index'])->name('index');
    Route::get('/trash', [TaskController::class, 'trash'])->name('trash');
    Route::post('/trash/{task}/restore', [TaskController::class, 'restore'])->name('restore');
    Route::delete('/trash/{task}/force-delete', [TaskController::class, 'forceDelete'])->name('forceDelete');
    Route::delete('/trash/force-delete-all', [TaskController::class, 'forceDeleteAll'])->name('forceDeleteAll');
	Route::get('/create', [TaskController::class, 'create'])->name('create');
	Route::post('/', [TaskController::class, 'store'])->name('store');
	Route::get('/{task}', [TaskController::class, 'show'])->name('show');
	Route::get('/{task}/edit', [TaskController::class, 'edit'])->name('edit');
	Route::put('/{task}', [TaskController::class, 'update'])->name('update');
	Route::delete('/{task}', [TaskController::class, 'destroy'])->name('destroy');
    Route::patch('/tasks/{task}/status', [TaskController::class, 'updateStatus'])->name('updateStatus');
});
