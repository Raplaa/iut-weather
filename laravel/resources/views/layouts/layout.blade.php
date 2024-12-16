@vite(['resources/css/app.css', 'resources/js/app.js'])
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    <!-- Include the header -->
    @include('partials.header')

    <div class="content">
        <!-- This section will be filled by specific pages -->
        @yield('content')
    </div>
    <footer class="bg-white dark:bg-gray-900">
        <div class="container flex flex-col items-center justify-between px-6 py-8 mx-auto lg:flex-row">
            <a href="#">
                <img class="w-auto h-7" src="https://merakiui.com/images/full-logo.svg" alt="">
            </a>
            <p class="mt-6 text-sm text-gray-500 lg:mt-0 dark:text-gray-400">© Copyright 2024 Marin Chapuis </p>
        </div>
    </footer>
</body>
</html>