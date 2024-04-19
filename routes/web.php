<?php

use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MediaDownloadController;
use App\Http\Controllers\MenuController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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


Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    //startseite
    Route::get('/', function (){
        return redirect()->route('home');
    });
    Route::get('/home', HomeController::class)->name('home');

    //Menu
    Route::resource('/menu', MenuController::class)->except('show');

    //Kasse
    Route::resource('/checkout', CheckoutController::class)->only('index', 'store');

    //Export
    Route::get('/excel', [MediaDownloadController::class, 'exportExcel'])->name('excel');
    Route::get('/pdf', [MediaDownloadController::class, 'exportPDF'])->name('pdf');

});
