<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\C_broadcast;
use App\Http\Controllers\TamuController;
use App\Http\Controllers\LoginController;


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

Route::group(['middleware'=>['belumLogin']], function(){

    Route::get('/login', function () {
        return view('auth/login');
    });
    Route::post('/login', [LoginController::class, 'cekUser'])->name("login");

});

Route::group(['middleware'=>['sudahLogin']], function(){

    Route::get('/', [TamuController::class, 'indexAdmin']);
    Route::get('/beranda', [TamuController::class, 'indexAdmin']);

    Route::get('/data-tamu', [TamuController::class, 'index']);
    Route::post('/filter-tamu', [TamuController::class, 'filterTanggal'])->name("filter");
    Route::get('/export-tamu', [TamuController::class, 'exportTamu']);

    Route::get('/broadcast', [C_broadcast::class, 'index']);

    Route::post('/kirim-broadcast', [C_broadcast::class, 'kirimBroadcast'])->name("kirim.broadcast");

    Route::post('/edit-nomor', [C_broadcast::class, 'EditNomor'])->name("editNomor");
    Route::get('/delete-nomor/{id}', [C_broadcast::class, 'deleteNo']);
    Route::get('/delete-broadcast/{id}', [C_broadcast::class, 'deleteBroadcast']);


});

Route::get('/logout', [LoginController::class, 'logout']);

Route::get('/landing-page', function () {
    return view('tamu/app');
});
Route::post('/kirim-tamu', [TamuController::class, 'kirim'])->name("kirim.tamu");
Route::post('/landing-page', [TamuController::class, 'kirim_no'])->name("kirim.no");


