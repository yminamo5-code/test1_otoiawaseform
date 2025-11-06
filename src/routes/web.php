<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\Auth\LoginController;

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

 Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
 Route::post('/confirm', [ContactController::class, 'confirm'])->name('contacts.confirm');
 Route::post('/contacts', [ContactController::class, 'store'])->name('contacts.store');
 Route::get('/admin', [ContactController::class, 'admin'])->middleware('auth')->name('contacts.admin');
 Route::delete('/contacts/{id}', [ContactController::class, 'destroy'])->name('contacts.destroy');
 Route::get('/contacts/export', [ContactController::class, 'export'])->name('contacts.export');
 Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
 Route::post('/login', [LoginController::class, 'login']);
 Route::post('/logout', [LoginController::class, 'logout'])->name('logout');