<?php

use App\Http\Controllers\CityController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\WeatherController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Route::get('/weather/{city?}', [WeatherController::class, 'getWeather'])->name('weather');

Route::match(['get', 'post'], '/dashboard', [WeatherController::class, 'getWeather'])->middleware(['auth', 'verified'])->name('dashboard');
Route::match(['get', 'post'], '/dashboard', [WeatherController::class, 'getWeather'])->middleware(['auth', 'verified'])->name('dashboard');
Route::post('/saveCity', [CityController::class, 'saveCity'])->name('saveCity');
Route::delete('/removeCity', [CityController::class, 'removeCity'])->name('removeCity');
Route::get('/saved', [CityController::class, 'getSavedCities'])->name('saved');

Route::post('/addFavCity', [CityController::class, 'addFavCity'])->name('addFavCity');
Route::delete('/removeFavCity', [CityController::class, 'removeFavCity'])->name('removeFavCity');
Route::post('/startSubscription', [CityController::class, 'startSubscription'])->name('startSubscription');
Route::delete('/stopSubscription', [CityController::class, 'stopSubscription'])->name('stopSubscription');

Route::get('/saved', [CityController::class, 'getSavedCities'])->name('saved');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
