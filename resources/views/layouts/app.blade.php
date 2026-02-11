<!DOCTYPE html>
<html lang="it" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Configuratore Traslochi</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireStyles
    <script
        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google.maps_api_key') }}&libraries=places"
        defer
    ></script>
    <style>
        svg.icon-xs { width: 0.75rem !important; height: 0.75rem !important; display: inline-block !important; vertical-align: middle; flex-shrink: 0; }
        svg.icon-sm { width: 1rem !important; height: 1rem !important; display: inline-block !important; vertical-align: middle; flex-shrink: 0; }
        svg.icon-md { width: 1.25rem !important; height: 1.25rem !important; display: inline-block !important; vertical-align: middle; flex-shrink: 0; }
        svg.icon-lg { width: 1.5rem !important; height: 1.5rem !important; display: inline-block !important; vertical-align: middle; flex-shrink: 0; }
        svg.icon-xl { width: 2rem !important; height: 2rem !important; display: inline-block !important; vertical-align: middle; flex-shrink: 0; }
    </style>
</head>
<body class="font-sans antialiased">
    {{ $slot }}
    @livewireScripts
</body>
</html>
