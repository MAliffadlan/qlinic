<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\QueueController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->role === 'admin') {
            return redirect()->route('admin.dashboard');
        }

        return redirect()->route('patient.dashboard');
    }

    return view('landing');
})->name('landing');

Route::get('/home', function () {
    return redirect('/');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:10,1');
    Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/register', [AuthController::class, 'register'])->middleware('throttle.registration');
});
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth', 'admin'])->prefix('admin')->group(function () {
    Route::get('/dashboard', [QueueController::class, 'adminDashboard'])->name('admin.dashboard');
    Route::get('/display', [QueueController::class, 'adminDisplay'])->name('admin.display');
    Route::post('/queue/next', [QueueController::class, 'callNext'])->name('admin.queue.next');
    Route::post('/queue/update/{id}', [QueueController::class, 'updateQueueStatus'])->name('admin.queue.update');
});

Route::middleware(['auth'])->prefix('patient')->group(function () {
    Route::get('/dashboard', [QueueController::class, 'patientDashboard'])->name('patient.dashboard');
    Route::post('/queue/take', [QueueController::class, 'takeQueue'])->name('patient.queue.take');
});

Route::get('/display', [QueueController::class, 'liveDisplay'])->name('queue.display');
Route::get('/api/live-status', [QueueController::class, 'liveStatusAPI'])->name('queue.api.status');
