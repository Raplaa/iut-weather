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

    <footer>
        <!-- Footer content -->
        <p>&copy; {{ date('Y') }} Mon Application</p>
    </footer>
</body>
</html>