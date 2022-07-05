<?php

use App\Http\Controllers\cobacobacontroller;
use App\Http\Controllers\DistribusiJamPMA2BController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PDFViewController;
use App\Http\Controllers\MPTableController;
use App\Http\Controllers\PopulasiUnitPMA2BController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
use App\Http\Controllers\testingController;
use App\Http\Controllers\TPController;
use Doctrine\DBAL\Schema\Index;
use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('dashboard');
})->name('dashboard');

Route::get('/tabel-mp', [MPTableController::class, 'index'])->name('mp.index');
Route::post('/tabel-mp/show', [MPTableController::class, 'getUserbyid'])->name('mp.show');
Route::get('/distribusi-jam-tp', [TPController::class, 'index'])->name('distribusi-jam-tp.index');
Route::get('/distribusi-jam-tp/pdf', [TPController::class, 'downloadPDF'])->name('distribusi-jam-tp.pdf');
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
Route::get('/populasi-unit-pma2b', [PopulasiUnitPMA2BController::class, 'index'])->name('pma2b.populasi.index');
Route::get('/distribusi-jam-pma2b', [DistribusiJamPMA2BController::class, 'index'])->name('pma2b.distribusi.index');

require __DIR__.'/auth.php';
