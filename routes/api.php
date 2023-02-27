<?php

use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

# Companies
Route::get('/companies', [CompanyController::class, 'index'])->name('index');
Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('show');
Route::post('/companies', [CompanyController::class, 'store'])->name('store');
Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('update');
Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('destroy');


