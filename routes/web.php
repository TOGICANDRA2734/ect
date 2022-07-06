<?php

use App\Http\Controllers\MPTableController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SettingController;
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
Route::get('/tabel-mp/export', [MPTableController::class, 'fileExport'])->name('mp.export');
Route::post('/tabel-mp/show', [MPTableController::class, 'getUserbyid'])->name('mp.show');
Route::get('/setting', [SettingController::class, 'index'])->name('setting.index');
Route::post('/setting/update', [SettingController::class, 'update'])->name('setting.update');
Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');

// Login
// Route::post('custom-login', [C])


require __DIR__.'/auth.php';
