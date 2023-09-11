<?php

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

Route::get('/login', function () {
    return view('login');
})->name('login');

Route::post('/login', [UserController::class, 'login'])->name('login');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', [UserController::class, 'register'])->name('register');

Route::get('/about', function () {
    return view('about');
})->name('about');

Route::middleware('auth:web')->group(function () {
    Route::get('/invoices', [InvoiceController::class, 'index'])->name('invoices');
    Route::get('/account', [UserController::class, 'index'])->name('account');
    Route::get('/account/edit', [UserController::class, 'edit'])->name('account_edit');
    Route::match(['get', 'post'], '/logout', [UserController::class, 'logout'])->name('logout');
});


