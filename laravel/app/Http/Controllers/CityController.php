<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\saveCity;
use App\Models\userPlace;

class CityController extends Controller
{
    public function saveCity(Request $request)
    {
        $name = $request->input('saveCity');
        $place = saveCity::where('name', $name)->first();
        if (!$place) {
            $place = saveCity::create([
                'name' => $name
            ]);
        }

        $userId = Auth::id();
        $placeId = $place->id;

        $userPlace = userPlace::where('place_id', $placeId)->where('user_id', $userId)->first();
        if (!$userPlace) {
            $userPlace = userPlace::create([
                'user_id' => $userId,
                'place_id' => $placeId,
                'is_favorite' => false,
                'send_forecast' => false
            ]);
        }
        return redirect()->route('saved');
    }

    public function removeCity(Request $request) {
        $city_id = $request->input('deleteCity');
        $userId = Auth::id();

        $userPlace = userPlace::where('place_id', $city_id)->where('user_id', $userId)->delete();
        // var_dump($userPlace);
        return redirect()->route('saved');
    }

    public function getSavedCities()
    {
        $userId = Auth::id();

        $cities = userPlace::with('place')->where('user_id', $userId)->get();
        return view('saved', [
            'cities' => $cities,
        ]);
    }

    public function addFavCity(Request $request)
    {
        $city_id = $request->input('addFavCity');
        $user_id = Auth::id();

        // Retire l'ancien favori, s'il y en a un
        userPlace::where('user_id', $user_id)
            ->where('is_favorite', true)
            ->update(['is_favorite' => false]);

        // Marque cette ville comme favorite
        userPlace::where('user_id', $user_id)
            ->where('place_id', $city_id)
            ->update(['is_favorite' => true]);

        return redirect()->route('saved')->with('status', 'Ville ajoutée aux favoris !');
    }

    public function removeFavCity(Request $request)
    {
        $city_id = $request->input('removeFavCity');
        $user_id = Auth::id();

        userPlace::where('user_id', $user_id)
            ->where('place_id', $city_id)
            ->update(['is_favorite' => false]);

        return redirect()->route('saved')->with('status', 'Ville retirée des favoris !');
    }
    
    public function startSubscription (Request $request) {
        $city_id = $request->input("startSubscription");
        $user_id = Auth::id();

        // Update the city to receive daily reports
        userPlace::where('user_id', $user_id)
            ->where('place_id', $city_id)
            ->update(['send_forecast' => true]);

        return redirect()->route('saved')->with('status', 'Vous recevrez des prévisions régulierement!');
    } 

    // Unsubscribe daily weather reports
    public function stopSubscription (Request $request) {
        $city_id = $request->input("stopSubscription");
        $user_id = Auth::id();

        // Update the city to no longer receive daily reports
        userPlace::where('user_id', $user_id)
            ->where('place_id', $city_id)
            ->update(['send_forecast' => false]);

        return redirect()->route('saved')->with('status', 'Vous ne recevrez plus de prévisions quotidienne!');
    } 
}
