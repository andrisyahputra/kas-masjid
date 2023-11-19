<?php

use App\Http\Controllers\InfakController;
use App\Http\Controllers\InformasiController;
use App\Http\Controllers\KasController;
use App\Http\Controllers\KategoriController;
use App\Http\Controllers\KurbanController;
use App\Http\Controllers\KurbanHewanController;
use App\Http\Controllers\KurbanPesertaController;
use App\Http\Controllers\MasjidBankController;
use App\Http\Controllers\MasjidController;
use App\Http\Controllers\PesertaController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\UserProfileController;
use App\Http\Middleware\EnsureDataMasjidCompleted;
use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Auth\EmailVerificationRequest;
use Illuminate\Http\Request;

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

Route::get('logout-user', function () {
    Auth::logout();
    return redirect('/');
})->name('logout-user');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::resource('masjid', MasjidController::class)->middleware('verified');
    Route::middleware(EnsureDataMasjidCompleted::class)->group(function () {
        Route::resource('infak', InfakController::class);
        Route::resource('kurbanpeserta', KurbanPesertaController::class);
        Route::resource('peserta', PesertaController::class);
        Route::resource('kurbanhewan', KurbanHewanController::class);
        Route::resource('kurban', KurbanController::class);
        Route::resource('masjidbank', MasjidBankController::class);
        Route::resource('informasi', InformasiController::class);
        Route::resource('kategori', KategoriController::class);
        Route::resource('kas', KasController::class);
        Route::resource('profil', ProfilController::class);
        Route::resource('userprofile', UserProfileController::class);
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});

Route::get('/email/verify', function () {
    // return view('auth.verif_adminkit');
    return view('auth.verify');
})->middleware('auth')->name('verification.notice');

Route::get('/email/verify/{id}/{hash}', function (EmailVerificationRequest $request) {
    $request->fulfill();

    return redirect('/home');
})->middleware(['auth', 'signed'])->name('verification.verify');

Route::post('/email/verification-notification', function (Request $request) {
    $request->user()->sendEmailVerificationNotification();

    return back()->with('message', 'Verification link sent!');
})->middleware(['auth', 'throttle:6,1'])->name('verification.resend');
