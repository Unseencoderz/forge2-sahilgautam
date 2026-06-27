<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ReplyController;
use App\Http\Controllers\Api\TicketController;
use Illuminate\Support\Facades\Route;

Route::get('/health', fn () => response()->json(['status' => 'ok', 'service' => 'PulseDesk', 'version' => '1.0.0']));

Route::prefix('auth')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);
    Route::post('logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'me'])->middleware('auth:sanctum');
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('tickets', [TicketController::class, 'index']);
    Route::post('tickets', [TicketController::class, 'store']);
    Route::get('tickets/{ticket}', [TicketController::class, 'show']);
    Route::put('tickets/{ticket}', [TicketController::class, 'update'])
        ->middleware('role:admin,agent');
    Route::delete('tickets/{ticket}', [TicketController::class, 'destroy'])
        ->middleware('role:admin');

    Route::get('tickets/{ticket}/replies', [ReplyController::class, 'index']);
    Route::post('tickets/{ticket}/replies', [ReplyController::class, 'store']);
});
