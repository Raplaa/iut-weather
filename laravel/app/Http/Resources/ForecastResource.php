<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ForecastResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
    {
        return [
            'city' => $this['city']['name'] ?? 'Unknown city',
            'forecast' => array_map(function ($forecastItem) {
                return [
                    'datetime' => $forecastItem['dt_txt'] ?? null,
                    'temperature' => $forecastItem['main']['temp'] ?? null,
                    'humidity' => $forecastItem['main']['humidity'] ?? null,
                    'weather_description' => $forecastItem['weather'][0]['description'] ?? 'No description available',
                    'wind_speed' => $forecastItem['wind']['speed'] ?? null,
                ];
            }, $this['list'] ?? []),
        ];
    }
}