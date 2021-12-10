<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PrescriptionController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/list-obat', [PrescriptionController::class, 'index'])->name('list.obat');
Route::get('/list-transaksi', [PrescriptionController::class, 'indexTransactions'])->name('list.transaksi');
Route::get('/detail-transaksi/{id}', [PrescriptionController::class, 'detailTransactions'])->name('detail.transaksi');
Route::get('/tambah-resep-non-racikan', [PrescriptionController::class, 'createReceiptNonCombine'])->name('create.resep.non.racikan');
Route::get('/tambah-resep-racikan', [PrescriptionController::class, 'createReceiptCombine'])->name('create.resep.racikan');
Route::post('/store-resep-non-racikan', [PrescriptionController::class, 'storeReceipt'])->name('store.resep.non.racikan');
Route::post('/store-resep-racikan', [PrescriptionController::class, 'storeReceiptCombine'])->name('store.resep.racikan');
Route::get('/export-pdf/{id}', [PrescriptionController::class, 'exportPdf'])->name('export.pdf');
