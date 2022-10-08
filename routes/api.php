<?php

use App\Http\Controllers\CompanyController;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/', fn () => 'Empresas ' . Carbon::now()->year)->name('home');
Route::get('/companies', [CompanyController::class, 'index'])->name('company.index');

