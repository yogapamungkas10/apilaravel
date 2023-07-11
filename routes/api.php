<?php

use App\Http\Controllers\SampahController;
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

Route::get('/sampah', [SampahController::class, 'index']);
Route::post('/sampah/store', [SampahController::class, 'store']);
Route::get('/sampah/{id}', [SampahController::class, 'show']);
Route::patch('/sampah/{id}/update', [SampahController::class, 'update']);
Route::delete('/sampah/{id}/delete', [SampahController::class, 'destroy']);
Route::get('/sampah/show/trash', [SampahController::class, 'trash']);
Route::get('/sampah/trash/restore/{id}', [SampahController::class, 'restore']);
Route::get('/sampah/trash/restore/{id}', [SampahController::class, 'restore']);
Route::get('/sampah/trash/delete/permanent/{id}', [SampahController::class, 'permanentDelete']);
