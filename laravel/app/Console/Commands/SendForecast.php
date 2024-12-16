<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\userPlace;
use App\Models\saveCity;
use App\Notifications\NotificationForecast;
use Illuminate\Support\Facades\Http;

class SendForecast extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'weather:send-forecast';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send a daily forecast to subscribed users';

    /**
     * Execute the console command.
     */
    protected $apiKey;
    protected $baseUrl;

    public function handle()
    {
        $subscriptions = userPlace::where('send_forecast', true)->get();
        foreach ($subscriptions as $subscription) {
            $user = User::find($subscription->user_id);
            $city = saveCity::where('id', $subscription->place_id)->get()->first();
            $csvPath = $this->makeCSV($city->name);
            if ($user) {
                try {
                    $user->notify(new NotificationForecast($csvPath));
                } catch (\Exception $e) {
                    $this->error("Failed to send email to {$user->email}: {$e->getMessage()}");
                }
            }
        }

        $this->info('All daily report emails have been sent.');
    }

    private function makeCSV($city)
    {
        $this->baseUrl = config('services.openweather.base_url');
        $this->apiKey = config('services.openweather.api_key');
        $forecast = Http::get("{$this->baseUrl}forecast", [
            'q' => $city,
            'appid' => $this->apiKey,
            'units' => 'metric',
            'lang' => 'fr',
        ]);
        $filePath = '';
        if ($forecast->successful()) {
            $forecastData = $forecast->json();
            // fputcsv function to create a csv
            $filePath =  public_path() . '/data/' . (string)$forecastData['list'][0]['dt'] . (string)$forecastData['city']['name'] . '.csv';
            $file = fopen($filePath, 'w');
            // head csv
            fputcsv($file, ['Time', 'Temperature (°C)', 'Description', 'Humidity (%)']);
            // data weather
            for ($i = 0; $i < count($forecastData['list']) / 5 - 1; $i++) {
                fputcsv($file, [
                    date('H:i:s', $forecastData['list'][$i]['dt']),
                    $forecastData['list'][$i]['main']['temp'],
                    $forecastData['list'][$i]['weather'][0]['description'],
                    $forecastData['list'][$i]['main']['humidity'],
                ]);
            }
            fclose($file);
        }
        return $filePath;
    }
}
