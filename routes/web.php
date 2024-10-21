
<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\KaryawanController;
use App\Exports\KaryawanExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\UserController;



Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// Rute untuk menyimpan data dengan controller Karyawan
Route::post('/dashboard/store', [KaryawanController::class, 'store'])->name('dashboard.store');
Route::post('/karyawan/export-excel', [KaryawanController::class, 'exportExcel'])->name('karyawan.exportExcel');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';

// Rute untuk admin dashboard, tidak perlu duplikasi
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/dashboard', [HomeController::class, 'index'])->name('admin.dashboard');
});

// Rute untuk Karyawan
Route::get('/admin/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::put('/karyawan/soft-delete/{id}', [KaryawanController::class, 'softDelete'])->name('karyawan.softDelete');
Route::put('/karyawan/restore/{id}', [KaryawanController::class, 'restore'])->name('karyawan.restore');
// Route::post('/dashboard/store', [KaryawanController::class, 'store'])->name('dashboard.store');
// Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

//fitur pdf & excel
Route::get('karyawan/{id}/pdf', [KaryawanController::class, 'cetakPdf'])->name('karyawan.cetakPdf');
// Route untuk mengambil data nomor polisi dan volume
Route::get('/get-volume/{nomer_polisi}', [KaryawanController::class, 'getVolume']);
//fitur excell
Route::get('/karyawan/export', [KaryawanController::class, 'export'])->name('karyawan.export');
// fitur sampah & pengembalian sampah
Route::get('/karyawan', [KaryawanController::class, 'index'])->name('karyawan.index');
Route::put('/karyawan/delete/{id}', [KaryawanController::class, 'softDelete'])->name('karyawan.softDelete');
Route::put('/karyawan/restore/{id}', [KaryawanController::class, 'restore'])->name('karyawan.restore');
Route::get('/karyawan/trashed', [KaryawanController::class, 'trashed'])->name('karyawan.trashed');
Route::put('/karyawan/{id}/restore', [KaryawanController::class, 'restore'])->name('karyawan.restore');
Route::delete('/karyawan/{id}/permanently-delete', [KaryawanController::class, 'permanentlyDelete'])->name('karyawan.permanentlyDelete');
Route::get('/data-nomer', [KaryawanController::class, 'dataNomer'])->name('data.nomer');


Route::get('/karyawan/search', [KaryawanController::class, 'search'])->name('karyawan.search');Route::post('/karyawan/export-excel', [KaryawanController::class, 'exportExcel'])->name('karyawan.exportExcel');
Route::get('/export-excel', [KaryawanController::class, 'exportExcel'])->name('exportExcel');
Route::get('/export-excel-all', [KaryawanController::class, 'exportExcelAll'])->name('exportExcelAll');


Route::get('/get-volumes/{nomer_polisi}', [KaryawanController::class, 'getVolumes']);

Route::get('/dashboard', [KaryawanController::class, 'create'])->name('dashboard');
Route::post('/submit-form', [KaryawanController::class, 'store'])->name('submit.form');

Route::get('/profile', [KaryawanController::class, 'profile'])->name('profile.index');
Route::post('/update-password', [ProfileController::class, 'updatePassword'])->name('password.update');
Route::get('/data-nomer', [KaryawanController::class, 'dataNomer'])->name('data.nomer');
Route::post('/karyawan/import', [KaryawanController::class, 'importFromExcel'])->name('karyawan.import');
Route::post('/import-excel-data', [KaryawanController::class, 'importExcel'])->name('data.import.excel');
Route::put('/update-data/{id}', [KaryawanController::class, 'updateData'])->name('data.update');
Route::put('/data/{id}', [KaryawanController::class, 'updateData'])->name('data.update');
Route::get('/data', [KaryawanController::class, 'index'])->name('data.index');

Route::get('/data-nomer', [KaryawanController::class, 'dataNomer'])->name('data.nomer');
Route::post('/data/store', [KaryawanController::class, 'storeOrUpdateData'])->name('data.store');
Route::get('/show-data', [KaryawanController::class, 'showData'])->name('data.show');
Route::delete('/data/{id}', [KaryawanController::class, 'destroy'])->name('data.destroy');


//data user yang ada di halaman admin
Route::get('/data-user', [UserController::class, 'show'])->name('data.user');
Route::get('/data-user/{id}', [UserController::class, 'show'])->name('user.show'); // Rute untuk menampilkan detail pengguna
Route::put('/user/update/{id}', [UserController::class, 'update'])->name('user.update');
Route::resource('users', UserController::class);
Route::get('/data-user', [UserController::class, 'index'])->name('data.user');

Route::get('/data-user', [UserController::class, 'dataUser'])->name('data.user');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


