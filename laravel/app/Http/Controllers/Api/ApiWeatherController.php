<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use App\Http\Resources\WeatherResource;
use App\Http\Resources\ForecastResource;

class ApiWeatherController extends Controller
{
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        $this->apiKey = config('services.openweather.api_key');
        $this->baseUrl = config('services.openweather.base_url');
    }

    public function getWeather(Request $request)
    {
        $request->validate([
            'place' => 'string|max:255',
        ]);
    
        $city = $request->input('place');

        $response = Http::get($this->baseUrl . "weather", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'fr'
        ]);
        if ($response->successful()) {
            // Return view with data
            return new WeatherResource($response->json());
        } else {
            return "error";
        }
    }

    public function getForecast(Request $request) {
        $request->validate([
            'place' => 'string|max:255',
        ]);
    
        $city = $request->input('place');

        $response = Http::get($this->baseUrl . "forecast", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'fr'
        ]);
        if ($response->successful()) {
            // Return view with data
            return new ForecastResource($response->json());
        } else {
            return "error";
        }
    }
}
