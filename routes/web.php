<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\FormController;
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

Route::get('/', [HomeController::class, 'getSymbols']);

Route::post('/submit-form', [FormController::class, 'submitFrm']);

Route::match(['get', 'post'],'/fetch-data', [FormController::class, 'getStockData']);

// Route::post('/fetch-chart', [FormController::class, 'getStockDataChart']);