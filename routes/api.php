<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CompanyController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'companies'], function () {

    Route::get('/', [CompanyController::class, 'index'])->name('index');
    Route::get('/{id}', [CompanyController::class, 'show'])->name('show');
    Route::post('/', [CompanyController::class, 'store'])->name('store');
    Route::put('/{id}', [CompanyController::class, 'update'])->name('update');
    Route::delete('/{id}', [CompanyController::class, 'destroy'])->name('destroy');

});

Route::group(['prefix' => 'articles'], function () {

    Route::get('/', [ArticleController::class, 'index'])->name('index');
    Route::get('/company/{companyId}', [ArticleController::class, 'findByCompanyId'])->
        name('findByCompanyId');
    Route::get('/{id}', [ArticleController::class, 'show'])->name('show');
    Route::post('/', [ArticleController::class, 'store'])->name('store');
    Route::put('/{id}', [ArticleController::class, 'update'])->name('update');
    Route::delete('/{id}', [ArticleController::class, 'destroy'])->name('destroy');

});

