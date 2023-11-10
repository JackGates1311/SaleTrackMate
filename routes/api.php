<?php

use App\Http\Controllers\Api\BankAccountControllerApi;
use App\Http\Controllers\Api\CompanyControllerApi;
use App\Http\Controllers\Api\GoodOrServiceControllerApi;
use App\Http\Controllers\Api\InvoiceControllerApi;
use App\Http\Controllers\Api\RecipientControllerApi;
use App\Http\Controllers\Api\UnitOfMeasureControllerApi;
use App\Http\Controllers\Api\UserControllerApi;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->group(function () {
    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', [CompanyControllerApi::class, 'index'])->name('index');
        Route::get('/{id}', [CompanyControllerApi::class, 'show'])->name('show');
        Route::post('/', [CompanyControllerApi::class, 'store'])->name('store');
        Route::put('/{id}', [CompanyControllerApi::class, 'update'])->name('update');
        Route::get('/user', [CompanyControllerApi::class, 'findByUserId'])->name('findByUserId');
    });

    Route::group(['prefix' => 'bank_accounts'], function () {
        Route::get('/company/{id}', [BankAccountControllerApi::class, 'findByCompanyId'])
            ->name('findByCompanyId');
        Route::post('/', [BankAccountControllerApi::class, 'store'])->name('store');
        Route::put('/{id}', [BankAccountControllerApi::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [BankAccountControllerApi::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'good_or_services'], function () {
        Route::get('/', [GoodOrServiceControllerApi::class, 'index'])->name('index');
        Route::get('/details', [GoodOrServiceControllerApi::class, 'indexWithDetails'])->
        name('indexWithDetails');
        Route::get('/company/{companyId}', [GoodOrServiceControllerApi::class, 'findByCompanyId'])->
        name('findByCompanyId');
        Route::get('/{id}', [GoodOrServiceControllerApi::class, 'show'])->name('show');
        Route::post('/', [GoodOrServiceControllerApi::class, 'store'])->name('store');
        Route::put('/{id}', [GoodOrServiceControllerApi::class, 'update'])->name('update');
        Route::delete('/{id}', [GoodOrServiceControllerApi::class, 'destroy'])->name('destroy');
    });

    Route::group(['prefix' => 'invoices'], function () {
        Route::get('/', [InvoiceControllerApi::class, 'index'])->name('index');
        Route::get('/{id}', [InvoiceControllerApi::class, 'show'])->name('show');
        Route::post('/', [InvoiceControllerApi::class, 'store'])->name('store');
        Route::get('/{id}/pdf', [InvoiceControllerApi::class, 'exportAsPdf'])->name('exportAsPdf');
        Route::get('/{id}/xml', [InvoiceControllerApi::class, 'exportAsXml'])->name('exportAsXml');
        Route::get('/company/{id}', [InvoiceControllerApi::class, 'findByCompanyId'])
            ->name('findByCompanyId');
    });

    Route::group(['prefix' => 'recipients'], function () {
        Route::get('/company/{id}', [RecipientControllerApi::class, 'getByCompanyId'])->
        name('getByCompanyId');
        Route::get('/{id}', [RecipientControllerApi::class, 'show'])->name('show');
        Route::post('/', [RecipientControllerApi::class, 'store'])->name('store');
        Route::put('/{id}', [RecipientControllerApi::class, 'update'])->name('update');
        Route::delete('/{id}', [RecipientControllerApi::class, 'destroy'])->name('destroy');
    });
    Route::group(['prefix' => 'unit_of_measures'], function () {
        Route::post('/', [UnitOfMeasureControllerApi::class, 'store'])->name('store');
        Route::get('/', [UnitOfMeasureControllerApi::class, 'index'])->name('index');
        Route::get('/{id}', [UnitOfMeasureControllerApi::class, 'show'])->name('show');
        Route::put('/{id}', [UnitOfMeasureControllerApi::class, 'update'])->name('update');
        Route::delete('/{id}', [UnitOfMeasureControllerApi::class, 'destroy'])->name('destroy');
    });
});

Route::group(['prefix' => 'user'], function () {
    Route::post('/register', [UserControllerApi::class, 'register'])->name('register');
    Route::post('/login', [UserControllerApi::class, 'login'])->name('login');
    Route::match(['get', 'post'], '/logout', [UserControllerApi::class, 'logout'])->name('logout');
});
