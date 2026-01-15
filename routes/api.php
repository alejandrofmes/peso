<?php

use App\Http\Controllers\NSRP;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// // Define routes
// Route::get('/fetch-municipalities/{province}', [NSRP::class, 'fetchMunicipalities']);
// Route::get('/fetch-barangays/{municipality}', [NSRP::class, 'fetchBarangays']);
