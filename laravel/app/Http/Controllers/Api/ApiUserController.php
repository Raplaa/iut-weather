<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;
use App\Models\saveCity;
use App\Models\userPlace;

class ApiUserController extends Controller
{
    public function getUserPlaces()
    {
        $userId = Auth::id();

        $cities = userPlace::with('place')->where('user_id', $userId)->paginate();
        return UserResource::collection($cities);
    }

    public function addUserPlace(Request $request)
    {
        $userId = Auth::id();
        $placeName = $request->input("place");
        $place = saveCity::where('name', $placeName)->first();
        if (!$place) {
            $place = saveCity::create([
                'name' => $placeName
            ]);
        }

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
    }

    public function removeUserPlace(Request $request)
    {
        $userId = Auth::id();
        $placeName = $request->input("place");
        $place = saveCity::where('name', $placeName)->first();
        $placeId = $place->id;
        userPlace::where('place_id', $placeId)->where('user_id', $userId)->delete();
    }

    public function toggleForecastPlace($place)
    {
        $userId = Auth::id();
        $placeEntity = saveCity::where('name', $place)->first();
        $placeId = $placeEntity->id;

        $forcastState = userPlace::where('user_id', $userId)
            ->where('place_id', $placeId)
            ->first()->send_forecast;

        userPlace::where('user_id', $userId)
            ->where('place_id', $placeId)
            ->update(['send_forecast' => $forcastState ? false : true]);
    }

    public function toggleFavPlace($place)
    {
        $userId = Auth::id();
        $placeEntity = saveCity::where('name', $place)->first();
        $placeId = $placeEntity->id;

        $favState = userPlace::where('user_id', $userId)
            ->where('place_id', $placeId)
            ->first()->is_favorite;

        if ($favState) {
            userPlace::where('user_id', $userId)
                ->where('place_id', $placeId)
                ->update(['is_favorite' => false]);
        } else {
            userPlace::where('user_id', $userId)
                ->where('is_favorite', true)
                ->update(['is_favorite' => false]);

            userPlace::where('user_id', $userId)
                ->where('place_id', $placeId)
                ->update(['is_favorite' => true]);
        }
    }
}
