<?php

use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [InvoiceController::class, 'index'])->name('invoices.index');
Route::resource('invoices', InvoiceController::class);
Route::put('invoices/{invoice}/cancel', [InvoiceController::class, 'cancel'])->name('invoices.cancel');
Route::post('invoices/search', [InvoiceController::class, 'search'])->name('invoices.search');
