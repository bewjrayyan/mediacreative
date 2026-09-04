<?php

use App\Http\Controllers\Api\AdminApiController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:web')->prefix('admin')->name('api.admin.')->group(function () {
    Route::get('/stats', [AdminApiController::class, 'stats'])->name('stats');
    Route::get('/messages', [AdminApiController::class, 'messages'])->name('messages.index');
    Route::get('/messages/chart', [AdminApiController::class, 'messagesChart'])->name('messages.chart');
    Route::get('/messages/{message}', [AdminApiController::class, 'showMessage'])->name('messages.show');
    Route::patch('/messages/{message}', [AdminApiController::class, 'markMessage'])->name('messages.mark');
    Route::delete('/messages/{message}', [AdminApiController::class, 'destroyMessage'])->name('messages.destroy');
});
