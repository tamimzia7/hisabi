<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hisabi') }}</title>
    <link rel="icon" href="{{ asset('icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Siliguri:wght@400;500;600;700&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased" style="font-family: 'Hind Siliguri', ui-sans-serif, system-ui, sans-serif;">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4 py-8">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="inline-flex items-center justify-center">
                <img src="{{ asset('logo.png') }}" alt="Hisabi" class="h-12 w-auto">
            </a>
            <p class="mt-1 text-sm text-slate-600">সহজ হিসাব, সবার জন্য</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
