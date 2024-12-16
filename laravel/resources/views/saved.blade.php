<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Saved cities') }}
        </h2>
    </x-slot>

    @if (session('success'))
        <div class="bg-green-500 text-white p-4 rounded-lg shadow-md mb-6">
            {{ session('success') }}
        </div>
    @elseif (session('error'))
        <div class="bg-red-500 text-white p-4 rounded-lg shadow-md mb-6">
            {{ session('error') }}
        </div>
    @endif

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    @if ($cities->isEmpty())
                        <p class="text-gray-600">No cities registered. Add one to view weather information.</p>
                    @else
                        <ul class="space-y-4">
                            @foreach ($cities as $city)
                                <li class="p-4 rounded-lg shadow-md hover:bg-gray-700 transition">
                                    <!-- Name of the city -->
                                    <h3 class="font-semibold text-lg">
                                        {{ $city->place->name }}
                                    </h3>
                                    <div class="mt-4 flex space-x-4">
                                        <!-- Add or remove from favorite -->
                                        @if ($city->is_favorite)
                                            <form method="post" action={{ route('removeFavCity') }}>
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none"
                                                    value={{ $city->place->id }} name="removeFavCity" type="submit">
                                                    Retirer des Favoris
                                                </button>
                                            </form>
                                        @else
                                            <form method="post" action={{ route('addFavCity') }}>
                                                @csrf
                                                <button
                                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none"
                                                    value={{ $city->place->id }} name="addFavCity" type="submit">
                                                    Ajouter aux Favoris
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Start or stop receiving daily forecast -->
                                        @if ($city->send_forecast)
                                            <form method="post" action={{ route('stopSubscription') }}>
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-500 focus:outline-none"
                                                    value={{ $city->place->id }} name="stopSubscription" type="submit">
                                                    Arreter de recevoir des prévisions
                                                </button>
                                            </form>
                                        @else
                                            <form method="post" action={{ route('startSubscription') }}>
                                                @csrf
                                                <button
                                                    class="px-4 py-2 text-sm font-medium text-white bg-blue-600 rounded-lg hover:bg-blue-500 focus:outline-none"
                                                    value={{ $city->place->id }} name="startSubscription"
                                                    type="submit">
                                                    Recevoir des Prévisions Quotidiennes
                                                </button>
                                            </form>
                                        @endif

                                        <!-- Delete saved city -->
                                        <form action={{ route('removeCity') }} method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" value={{ $city->place->id }} name="deleteCity" class="text-red-600 hover:text-red-800 text-sm">
                                                Supprimer
                                            </button>
                                        </form>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
