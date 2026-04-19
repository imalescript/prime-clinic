<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PatientController;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->group(function () {
    
    Route::get('/patients', [PatientController::class, 'index'])->name('patients.index');
    
    Route::get('/patients/{patient}', [PatientController::class, 'show'])->name('patients.show');

    Route::post('/patients', [PatientController::class, 'store'])->name('patients.store');

    Route::put('/patients/{patient}', [PatientController::class, 'update'])->name('patients.update');

    Route::delete('/patients/{patient}', [PatientController::class, 'destroy']);
});