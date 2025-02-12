<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="mt-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    Saluuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuuut
                </div>
            </div>
        </div>
        <div
            class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <form method="POST" action="{{ route('dashboard') }}" class="text-gray-900 dark:text-gray-100">
                @csrf

                <label for="city">Entrer une ville</label>

                <input id="city" type="text" name="city" class="text-black">

                @error('city')
                    <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </form>
        </div>
        <div
            class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
            <div class="text-gray-900 dark:text-gray-100">
                @if (isset($weather))
                    <form method="post" action={{ route('saveCity') }}>
                        @csrf
                        <button value={{ $weather['name'] }} name="saveCity"
                            class="px-6 py-2 font-medium tracking-wide text-white capitalize transition-colors duration-300 transform bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none focus:ring focus:ring-blue-300 focus:ring-opacity-80">
                            Save
                        </button>
                    </form>
                    <h2>Ville : {{ $weather['name'] }}</h2>
                    <p>Température : {{ $weather['main']['temp'] }} °C</p>
                    <p>Conditions : {{ $weather['weather'][0]['description'] }}</p>
                    <p>Humidité : {{ $weather['main']['humidity'] }}%</p>
                    @if (isset($coordinate))
                    <p>Lat : {{ $coordinate[0]['lat'] }}</p>
                    <p>Long : {{ $coordinate[0]['lon'] }}</p>
                    @endif
                @elseif (isset($error))
                    <p>{{ $error }}</p>
                @endif
            </div>
        </div>
        @if (isset($forecast))
            @for ($i = 4; $i < count($forecast["list"]); $i += count($forecast["list"]) / 5)
                <div
                    class="p-6 bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg max-w-7xl mx-auto sm:px-6 lg:px-8 mt-6">
                    <div class="text-gray-900 dark:text-gray-100">
                        <h2>{{date('l \t\h\e jS', $forecast['list'][$i]['dt'])}}</h2>
                        <p class="">Température : {{$forecast['list'][$i]['main']['temp']}}°C</p>
                        <p class="">Conditions : {{$forecast['list'][$i]['weather'][0]['description']}}</p>
                        <p class="">Humidité : {{$forecast['list'][$i]['main']['humidity']}}</p>
                    </div>
                </div>
            @endfor
        @endif
    </div>
</x-app-layout>
