<?php

use App\Http\Controllers\Admin\MatchController as AdminMatchController;
use App\Http\Controllers\Admin\TeamController as AdminTeamController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BetController;
use Illuminate\Support\Facades\Route;

Route::redirect('/', '/matches');

// Auth
Route::middleware('guest')->group(function () {
    Route::get('/login',    [LoginController::class,    'showForm'])->name('login');
    Route::post('/login',   [LoginController::class,    'login']);
    Route::get('/register', [RegisterController::class, 'showForm'])->name('register');
    Route::post('/register',[RegisterController::class, 'register']);
});
Route::post('/logout', [LoginController::class, 'logout'])->name('logout')->middleware('auth');

// User
Route::middleware('auth')->group(function () {
    Route::get('/matches',           [BetController::class, 'index'])->name('matches.index');
    Route::get('/matches/{match}',   [BetController::class, 'show'])->name('matches.show');
    Route::post('/matches/{match}/bet', [BetController::class, 'store'])->name('matches.bet');
});

// Admin
Route::middleware(['auth', \App\Http\Middleware\AdminMiddleware::class])->prefix('admin')->name('admin.')->group(function () {
    Route::redirect('/', '/admin/matches');

    Route::get('/teams',              [AdminTeamController::class, 'index'])->name('teams.index');
    Route::post('/teams',             [AdminTeamController::class, 'store'])->name('teams.store');
    Route::delete('/teams/{team}',    [AdminTeamController::class, 'destroy'])->name('teams.destroy');

    Route::get('/matches',            [AdminMatchController::class, 'index'])->name('matches.index');
    Route::post('/matches',           [AdminMatchController::class, 'store'])->name('matches.store');
    Route::delete('/matches/{match}', [AdminMatchController::class, 'destroy'])->name('matches.destroy');
    Route::get('/matches/{match}/edit',    [AdminMatchController::class, 'editForm'])->name('matches.edit');
    Route::put('/matches/{match}',         [AdminMatchController::class, 'update'])->name('matches.update');
    Route::get('/matches/{match}/result',  [AdminMatchController::class, 'resultForm'])->name('matches.result');
    Route::post('/matches/{match}/result', [AdminMatchController::class, 'storeResult'])->name('matches.storeResult');
    Route::patch('/matches/{match}/status',[AdminMatchController::class, 'updateStatus'])->name('matches.updateStatus');
});
