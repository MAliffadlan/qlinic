<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QueueController;

Route::get('/', function () {
    if (\Illuminate\Support\Facades\Auth::check()) {
        if (\Illuminate\Support\Facades\Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('patient.dashboard');
    }
    return redirect()->route('login');
});

Route::get('/home', function () {
    return redirect('/');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register']);
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->prefix('admin')->group(function() {
    Route::get('/dashboard', [QueueController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::post('/queue/next', [QueueController::class, 'callNext'])->name('admin.queue.next');
    Route::post('/queue/update/{id}', [QueueController::class, 'updateQueueStatus'])->name('admin.queue.update');
});

Route::middleware(['auth'])->prefix('patient')->group(function() {
    Route::get('/dashboard', [QueueController::class, 'patientDashboard'])->name('patient.dashboard');
    Route::post('/queue/take', [QueueController::class, 'takeQueue'])->name('patient.queue.take');
});

Route::get('/display', [QueueController::class, 'liveDisplay'])->name('queue.display');
Route::get('/api/live-status', [QueueController::class, 'liveStatusAPI'])->name('queue.api.status');
