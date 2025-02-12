<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\ApiWeatherController;
use App\Http\Controllers\Api\ApiUserController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('/weather', [ApiWeatherController::class, 'getWeather'])->name('api.weather');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('/forecast', [ApiWeatherController::class, 'getForecast'])->name('api.forecast');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::get('/users/places', [ApiUserController::class, 'getUserPlaces'])->name('api.getUserPlace');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::post('/users/places', [ApiUserController::class, 'addUserPlace'])->name('api.addUserPlace');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::delete('/users/places', [ApiUserController::class, 'removeUserPlace'])->name('api.removeUserPlace');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::patch('/users/places/{place}/send-forecast', [ApiUserController::class, 'toggleForecastPlace'])->name('api.toggleForecastPlace');
});

Route::middleware(['auth:sanctum'])->prefix('v1')->group(function () {
    Route::patch('/users/places/{place}/favorite', [ApiUserController::class, 'toggleFavPlace'])->name('api.toggleFavPlace');
});

// Route::get('/user/{id}', function (string $id) {
//     return new UserResource(User::findOrFail($id));
// });
