<!DOCTYPE html>
<html lang="it" data-theme="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pagamento Completato - Configuratore Traslochi</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md w-full space-y-8">
            <div class="bg-white rounded-3xl shadow-lg p-8 text-center">
                <div class="mb-6">
                    <svg class="mx-auto h-16 w-16 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Pagamento completato!</h2>
                <p class="text-gray-600 mb-6">
                    Il tuo pagamento di <strong class="text-gray-900">€{{ number_format($amount, 2, ',', '.') }}</strong> è stato elaborato con successo.
                </p>
                @if($config)
                    <div class="bg-gray-50 rounded-2xl p-4 mb-6 text-left">
                        <p class="text-sm text-gray-600 mb-2">
                            <strong>Cliente:</strong> {{ $config->nome }}
                        </p>
                        <p class="text-sm text-gray-600 mb-2">
                            <strong>Email:</strong> {{ $config->email }}
                        </p>
                        <p class="text-sm text-gray-600">
                            <strong>Telefono:</strong> {{ $config->phone }}
                        </p>
                    </div>
                @endif
                <p class="text-sm text-gray-500 mb-6">
                    Riceverai una email di conferma con tutti i dettagli della prenotazione.
                </p>
                <a href="{{ route('home') }}" class="btn btn-primary w-full">
                    Vai al riepilogo
                </a>
            </div>
        </div>
    </div>
</body>
</html>
