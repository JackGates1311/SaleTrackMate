<?php

use App\Http\Controllers\Api\CompanyControllerApi;
use App\Http\Controllers\Api\InvoiceControllerApi;
use App\Http\Controllers\Api\UserControllerApi;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ArticleDetailsController;
use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'companies'], function () {

    Route::get('/', [CompanyControllerApi::class, 'index'])->name('index');
    Route::get('/{id}', [CompanyControllerApi::class, 'show'])->name('show');
    Route::post('/', [CompanyControllerApi::class, 'store'])->name('store');
    Route::put('/{id}', [CompanyControllerApi::class, 'update'])->name('update');
    Route::get('/user/{id}', [CompanyControllerApi::class, 'findByUserId'])->name('findByUserId');

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

    Route::get('/', [InvoiceControllerApi::class, 'index'])->name('index');
    Route::get('/{id}', [InvoiceControllerApi::class, 'show'])->name('show');
    Route::post('/', [InvoiceControllerApi::class, 'store'])->name('store');
    Route::get('/{id}/pdf', [InvoiceControllerApi::class, 'exportAsPdf'])->name('exportAsPdf');
    Route::get('/{id}/xml', [InvoiceControllerApi::class, 'exportAsXml'])->name('exportAsXml');

});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserControllerApi::class, 'register'])->name('register');
    Route::post('/login', [UserControllerApi::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/logout', [UserControllerApi::class, 'logout'])->name('logout');
});
