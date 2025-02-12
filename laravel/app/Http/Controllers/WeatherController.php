<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class WeatherController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    public function getWeather(Request $request)
    {
        $request->validate([
            'city' => 'string|max:255',
        ]);
        $city = $request->input('city');

        $this->baseUrl = config('services.openweather.base_url');
        $this->apiKey = config('services.openweather.api_key');
        $weather = Http::get("{$this->baseUrl}weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'fr',
        ]);
        $forecast = Http::get("{$this->baseUrl}forecast", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'fr',
        ]);
        $coordinate = Http::get("https://api.openweathermap.org/geo/1.0/direct", [
            'q' => $city,
            'limit' => 1,
            'appid' => $this->apiKey,
        ]);

        if ($weather->successful() && $forecast->successful() && $coordinate->json()) {
            $weatherData = $weather->json();
            $forecastData = $forecast->json();
            return view('dashboard', [
                'weather' => $weatherData,
                'forecast' => $forecastData,
                'coordinate' => $coordinate
            ]);
        } else {
            return view('dashboard', [
                'error' => 'Impossible de récupérer les données météo.',
            ]);
        }
    }

    public function getForecast(Request $request)
    {
        $city = $request->input('getForecast');

        $this->baseUrl = config('services.openweather.base_url');
        $this->apiKey = config('services.openweather.api_key');
        $response = Http::get("{$this->baseUrl}forecast", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'fr',
        ]);

        if ($response->successful()) {
            $data = $response->json();
            return view('dashboard', [
                'weather' => $data,
            ]);
        } else {
            return view('dashboard', [
                'error' => 'Impossible de récupérer les données météo.',
            ]);
        }
    }
}
