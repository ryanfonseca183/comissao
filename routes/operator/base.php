<?php

use App\Http\Controllers\OperatorProfileController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AdminDashboard;
use App\Http\Controllers\BudgetController;
use App\Http\Controllers\CommissionController;
use App\Http\Controllers\Admin\IndicationController;
use App\Http\Controllers\Admin\UserController;
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
    Route::get('/users/datatable', [UserController::class, 'datatable'])->name('users.datatable');
    Route::resource('/users', UserController::class)->except('show');
    
    Route::resource('/services', ServiceController::class)->except('show')->middleware('can:edit-config');
    Route::get('/payments/datatable', [CommissionController::class, 'datatable'])->name('payments.datatable');
    Route::resource('/commissions', CommissionController::class)->parameters([
        'commissions' => 'company'
    ])->only('index', 'edit', 'update');

    Route::get('/indications/datatable', [IndicationController::class, 'datatable'])->name('indications.datatable');
    Route::resource('/indications', IndicationController::class)->parameters(['indications' => 'company'])->except('show');
    Route::prefix('/indications/{company}/budget')->name('indications.budget.')->controller(BudgetController::class)->group(function(){
        Route::middleware('budgetWasNotCreated')->group(function(){
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
        });
        Route::middleware('budgetWasCreated')->group(function(){
            Route::put('/status', 'updateStatus')->name('status.update');
            Route::middleware('budgetCanBeUpdated')->group(function(){
                Route::get('/edit', 'edit')->name('edit');
                Route::put('/', 'update')->name('update');
            });
            Route::get('/show', 'show')->name('show');
            Route::post('/show/revoke', 'revoke')->name('revoke');
            Route::post('/show/quantity/change', 'changeQuantity')->name('quantity.change');
        });
    });
    Route::get('/budgets', [BudgetController::class, 'index'])->name('budgets.index');
});