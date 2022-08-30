<?php

use App\Http\Controllers\Api\Client\ClientController;
use App\Http\Controllers\Api\Company\CompanyController;
use App\Http\Controllers\Api\Auth\TokenController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('token', TokenController::class);

Route::middleware('auth:sanctum')->group(function () {
    Route::get('companies', [CompanyController::class, 'index']);
    Route::get('clients', [CompanyController::class, 'companyClients']);
    Route::get('client_companies', [ClientController::class, 'clientCompanies']);
});

