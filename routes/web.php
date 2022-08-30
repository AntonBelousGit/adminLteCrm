<?php

use App\Http\Controllers\Crm\ClientController;
use App\Http\Controllers\Crm\CompanyController;
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

Route::group(['middleware' => 'auth'], function() {
    Route::get('/', function () {
        return view('home');
    })->name('home');

    Route::resources(
        [
            'client' => ClientController::class,
            'company' => CompanyController::class
        ]
    );
});
