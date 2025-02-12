<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WeatherResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'city' => $this['name'] ?? 'Unknown city',
            'temperature' => $this['main']['temp'] ?? null,
            'humidity' => $this['main']['humidity'] ?? null,
            'weather_description' => $this['weather'][0]['description'] ?? null,
            'wind_speed' => $this['wind']['speed'] ?? null,
        ];
    }
}
