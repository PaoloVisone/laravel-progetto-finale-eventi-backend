<?php

use App\Http\Controllers\Api\BookingController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

// Route::get('/user', function (Request $request) {
//     return $request->user();
// })->middleware('auth:sanctum');
Route::prefix('bookings')->group(function () {
    Route::post('/', [BookingController::class, 'store']);
    Route::get('/', [BookingController::class, 'index']);
    Route::get('/{booking}', [BookingController::class, 'show']);
});

Route::prefix('events')->group(function () {
    Route::get('/', [EventController::class, 'index']);
    Route::get('/{event}', [EventController::class, 'show']);
});
