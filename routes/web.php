<?php

use Illuminate\Support\Facades\Auth;
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

Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('landing');
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::middleware('auth')->group(function () {
    Route::get('/home', [\App\Http\Controllers\HomeController::class, 'home'])->name('home');
    Route::post('/home/search', [\App\Http\Controllers\HomeController::class, 'search'])->name('home.search');
    Route::get('/strafblad/burger/{uuid}', [\App\Http\Controllers\HomeController::class, 'showStrafblad'])->name('player.strafblad');
    Route::get('/account-aanmaken', [\App\Http\Controllers\HomeController::class, 'nieuwAccount'])->name('account.aanmaken');
    Route::get('/accounts', function () {
        return view('account.accounts');
    })->name('account.all');
    Route::get('/accounts-get-all', [\App\Http\Controllers\HomeController::class, 'allAccounts'])->name('account.accounts.all');
    Route::post('/account-aanmaken', [\App\Http\Controllers\HomeController::class, 'registerAccount'])->name('account.register');
    Route::post('/add-rapport', [\App\Http\Controllers\HomeController::class, 'addRapport'])->name('add.rapport');
    Route::get('/get-strafblad', [\App\Http\Controllers\HomeController::class, 'getStrafblad'])->name('get.strafblad');
    Route::post('/accounts-delete', [\App\Http\Controllers\HomeController::class, 'deleteUser'])->name('accounts.delete');
});
