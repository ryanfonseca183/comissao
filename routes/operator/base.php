<?php

use App\Http\Controllers\OperatorProfileController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\BudgetController;
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
    Route::get('/dashboard', AdminDashboard::class)->name('dashboard');
    Route::get('/profile', [OperatorProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [OperatorProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [OperatorProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('/operators', OperatorController::class)->except('show')->middleware('can:edit-config');
    Route::resource('/services', ServiceController::class)->except('show')->middleware('can:edit-config');

    Route::prefix('/indications/{company}/budget')->name('indications.budget.')->controller(BudgetController::class)->group(function(){
        Route::middleware('budgetWasNotCreated')->group(function(){
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
        Route::middleware('budgetWasCreated')->group(function(){
            Route::middleware('budgetCanBeUpdated')->group(function(){
                Route::get('/edit', 'edit')->name('edit');
                Route::put('/', 'update')->name('update');
            });
            Route::get('/show', 'show')->name('show');
        });
    });
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
});