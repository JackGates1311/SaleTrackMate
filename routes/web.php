<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\GoodOrServiceController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\PriceController;
use App\Http\Controllers\PriceDiscountController;
use App\Http\Controllers\RecipientController;
use App\Http\Controllers\TaxCategoryController;
use App\Http\Controllers\TaxRateController;
use App\Http\Controllers\UnitOfMeasureController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|----------------------------------------------p----------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (session()->get('user_data') != '' && session()->get('user_data') != null) {
        return redirect('/invoices');
    } else {
        return view('index');
    }
});

Route::group(['prefix' => 'login'], function () {
    Route::get('/', function () {
        return view('login');
    })->name('login');

    Route::post('/', [UserController::class, 'login'])->name('login');
});

Route::group(['prefix' => 'register'], function () {
    Route::get('/', function () {
        return view('register');
    })->name('register');

    Route::post('/', [UserController::class, 'register'])->name('register');
});

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware('auth:web')->group(function () {
    Route::group(['prefix' => 'invoices'], function () {
        Route::get('/', [InvoiceController::class, 'index'])->name('invoices');
        Route::get('/create', [InvoiceController::class, 'createView'])->name('create_invoice_view');
        Route::post('/create', [InvoiceController::class, 'create'])->name('create_invoice');
    });
    Route::group(['prefix' => 'recipients'], function () {
        Route::get('/', [RecipientController::class, 'index'])->name('recipients');
        Route::get('/create', [RecipientController::class, 'createView'])->name('create_recipient_view');
        Route::post('/create', [RecipientController::class, 'create'])->name('create_recipient');
        Route::get('/edit', [RecipientController::class, 'edit'])->name('recipient_edit');
        Route::post('/edit', [RecipientController::class, 'update'])->name('recipient_edit_save');
        Route::post('/delete', [RecipientController::class, 'delete'])->name('recipient_delete');
    });
    Route::group(['prefix' => 'account'], function () {
        Route::get('/', [UserController::class, 'index'])->name('account');
        Route::get('/edit', [UserController::class, 'edit'])->name('account_edit');
    });
    Route::group(['prefix' => 'companies'], function () {
        Route::get('/', [CompanyController::class, 'index'])->name('companies');
        Route::get('/edit', [CompanyController::class, 'edit'])->name('company_edit');
        Route::post('/edit', [CompanyController::class, 'update'])->name('company_edit_save');
        Route::get('/create', [CompanyController::class, 'createView'])->name('create_company_view');
        Route::post('/create', [CompanyController::class, 'create'])->name('create_company');
        Route::get('/selectCompany', [CompanyController::class, 'selectCompany'])->name('select_company');
    });
    Route::group(['prefix' => 'bank_accounts'], function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('bank_accounts');
        Route::get('/edit', [BankAccountController::class, 'edit'])->name('bank_account_edit');
        Route::post('/edit', [BankAccountController::class, 'update'])->name('bank_account_edit_save');
        Route::post('/delete', [BankAccountController::class, 'delete'])->name('bank_account_delete');
        Route::post('/create', [BankAccountController::class, 'create'])->name('create_bank_account');
    });
    Route::group(['prefix' => 'goods_and_services'], function () {
        Route::get('/', [GoodOrServiceController::class, 'index'])->name('goods_and_services');
        Route::get('/create', [GoodOrServiceController::class, 'createView'])->
        name('create_goods_and_services_view');
        Route::post('/create', [GoodOrServiceController::class, 'create'])->name('create_good_or_service');
        Route::get('/edit', [GoodOrServiceController::class, 'edit'])->name('good_or_service_edit');
        Route::post('/edit', [GoodOrServiceController::class, 'update'])->name('good_or_service_edit_save');
    });
    Route::group(['prefix' => 'unit_of_measures'], function () {
        Route::get('/', [UnitOfMeasureController::class, 'index'])->name('unit_of_measures');
        Route::get('/edit', [UnitOfMeasureController::class, 'edit'])->name('unit_of_measure_edit');
        Route::post('/edit', [UnitOfMeasureController::class, 'update'])->name('unit_of_measure_edit_save');
        Route::post('/create', [UnitOfMeasureController::class, 'create'])->name('create_unit_of_measure');
        Route::post('/delete', [UnitOfMeasureController::class, 'delete'])->name('unit_of_measure_delete');
    });
    Route::group(['prefix' => 'tax_categories'], function () {
        Route::get('/', [TaxCategoryController::class, 'index'])->name('tax_categories');
        Route::post('/create', [TaxCategoryController::class, 'create'])->name('create_tax_category');
        Route::post('/delete', [TaxCategoryController::class, 'delete'])->name('tax_category_delete');
        Route::post('/edit', [TaxCategoryController::class, 'update'])->name('tax_category_save');
    });
    Route::group(['prefix' => 'tax_rates'], function () {
        Route::post('/create', [TaxRateController::class, 'create'])->name('create_tax_rate');
        Route::get('/edit', [TaxRateController::class, 'edit'])->name('tax_rate_edit');
        Route::post('/edit', [TaxRateController::class, 'update'])->name('tax_rate_edit_save');
        Route::post('/delete', [TaxRateController::class, 'delete'])->name('tax_rate_delete');
    });
    Route::group(['prefix' => 'prices'], function () {
        Route::get('/', [PriceController::class, 'index'])->name('prices');
        Route::get('/edit', [PriceController::class, 'edit'])->name('price_edit');
        Route::post('/edit', [PriceController::class, 'update'])->name('price_edit_save');
        Route::get('/create', [PriceController::class, 'createView'])->name('create_price_view');
        Route::post('/create', [PriceController::class, 'create'])->name('create_price');
        Route::post('/delete', [PriceController::class, 'delete'])->name('price_delete');
    });
    Route::group(['prefix' => 'price_discounts'], function () {
        Route::get('/', [PriceDiscountController::class, 'index'])->name('price_discounts');
        Route::get('/edit', [PriceDiscountController::class, 'edit'])->name('price_discount_edit');
        Route::post('/edit', [PriceDiscountController::class, 'update'])->name('price_discount_edit_save');
        Route::get('/create', [PriceDiscountController::class, 'createView'])->
        name('create_price_discount_view');
        Route::post('/create', [PriceDiscountController::class, 'create'])->name('create_price_discount');
        Route::post('/delete', [PriceDiscountController::class, 'delete'])->name('price_discount_delete');
    });
    Route::match(['get', 'post'], '/logout', [UserController::class, 'logout'])->name('logout');
});


