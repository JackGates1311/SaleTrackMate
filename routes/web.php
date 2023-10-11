<?php

use App\Http\Controllers\BankAccountController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\UserController;
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
        Route::get('/create', [InvoiceController::class, 'createView'])->name('create_invoice');
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
        Route::get('/selectCompany', [CompanyController::class, 'selectCompany'])->name('selectCompany');
    });
    Route::group(['prefix' => 'bank_accounts'], function () {
        Route::get('/', [BankAccountController::class, 'index'])->name('bank_accounts');
        Route::get('/edit', [BankAccountController::class, 'edit'])->name('bank_account_edit');
        Route::post('/edit', [BankAccountController::class, 'update'])->name('bank_account_edit_save');
        Route::post('/delete', [BankAccountController::class, 'delete'])->name('bank_account_delete');
        Route::post('/create', [BankAccountController::class, 'create'])->name('create_bank_account');
    });
    Route::match(['get', 'post'], '/logout', [UserController::class, 'logout'])->name('logout');
});


