<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class GetWeather extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:get-weather {place}';
    protected $apiKey;
    protected $baseUrl;

    public function __construct()
    {
        parent::__construct();
        $this->apiKey = config('services.openweather.api_key');
        $this->baseUrl = config('services.openweather.base_url');
    }

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $place = $this->argument('place');

        $response = Http::get("{$this->baseUrl}weather", [
            'q'     => $place,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang'  => 'fr'
        ]);

        if ($response->successful()) {
            $data = $response->json();
            $this->info("{$data['name']} :");
            $this->line("Temperature : {$data['main']['temp']}°C");
            $this->line("Wind : {$data['wind']['speed']}km/h ");
            $this->line("Weather : {$data['weather'][0]['description']}");
        } else {
            $this->error('The city is impossible to find');
        }
    }
}
