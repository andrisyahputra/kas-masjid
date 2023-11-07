<?php

use App\Http\Controllers\MasjidController;
use App\Http\Middleware\EnsureDataMasjidCompleted;
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

Route::get('logout-user', function () {
    Auth::logout();
    return redirect('/');
})->name('logout-user');


Route::get('/', function () {
    return view('welcome');
});

Auth::routes();


Route::middleware(['auth'])->group(function () {
    Route::resource('masjid', MasjidController::class);

    Route::middleware(EnsureDataMasjidCompleted::class)->group(function () {
        Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    });
});
