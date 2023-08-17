<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleDetailsController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
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
    Route::get('/details', [ArticleController::class, 'indexWithDetails'])->
        name('indexWithDetails');
    Route::get('/company/{companyId}', [ArticleController::class, 'findByCompanyId'])->
        name('findByCompanyId');
    Route::get('/{id}', [ArticleController::class, 'show'])->name('show');
    Route::post('/', [ArticleController::class, 'store'])->name('store');
    Route::put('/{id}', [ArticleController::class, 'update'])->name('update');
    Route::delete('/{id}', [ArticleController::class, 'destroy'])->name('destroy');

});

Route::group(['prefix' => 'articlesDetails'], function () {

    Route::get('/', [ArticleDetailsController::class, 'index'])->name('index');
    Route::get('/{id}', [ArticleDetailsController::class, 'show'])->name('show');
    Route::post('/', [ArticleDetailsController::class, 'store'])->name('store');
    Route::put('/{id}', [ArticleDetailsController::class, 'update'])->name('update');
    Route::delete('/{id}', [ArticleDetailsController::class, 'destroy'])->name('destroy');

});

Route::group(['prefix' => 'invoices'], function () {

    Route::get('/', [InvoiceController::class, 'index'])->name('index');
    Route::get('/{id}', [InvoiceController::class, 'show'])->name('show');
    Route::post('/', [InvoiceController::class, 'store'])->name('store');
    Route::get('/{id}/pdf', [InvoiceController::class, 'exportAsPdf'])->name('exportAsPdf');
    Route::get('/{id}/xml', [InvoiceController::class, 'exportAsXml'])->name('exportAsXml');

});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserController::class, 'register'])->name('register');
    Route::post('/login', [UserController::class, 'login'])->name('login');
});
