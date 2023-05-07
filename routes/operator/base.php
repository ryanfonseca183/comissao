<?php

use App\Http\Controllers\OperatorProfileController;
use App\Http\Controllers\OperatorController;
use Illuminate\Support\Facades\Route;

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
Route::middleware('auth:admin')->group(function(){
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/profile', [OperatorProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [OperatorProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [OperatorProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/operators', OperatorController::class)->except('show')->middleware('can:edit-operators');
});