<?php

use App\Http\Controllers\MapController;
use App\Http\Controllers\CommodityController;
use App\Http\Controllers\VarietyController;
use App\Http\Controllers\PestController;
use App\Http\Controllers\PestSearchController;
use App\Http\Controllers\PestChatbotController;
use App\Http\Controllers\Api\MapController as ApiMapController;
use Illuminate\Support\Facades\Route;

Route::get('/health-check', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
    ]);
})->name('health-check');

// Main map page
Route::get('/', [MapController::class, 'index'])->name('home');

// Map API routes
Route::prefix('api/map')->group(function () {
    Route::get('/', [ApiMapController::class, 'index']);
});

// Commodity routes
Route::resource('commodities', CommodityController::class)->only(['index', 'show']);

// Variety routes
Route::resource('varieties', VarietyController::class)->only(['index', 'show']);

// Pest detection routes
Route::get('/pest-detection', [PestController::class, 'index'])->name('pest-detection');
Route::post('/api/pest-search', [PestSearchController::class, 'store'])->name('pest.search');
Route::post('/api/pest-chatbot', [PestChatbotController::class, 'store'])->name('pest.chatbot');
Route::get('/pests/{pest}', [PestController::class, 'show'])->name('pests.show');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia\Inertia::render('dashboard');
    })->name('dashboard');
});

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
