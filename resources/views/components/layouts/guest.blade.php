<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Hisabi') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 antialiased">
    <div class="mx-auto flex min-h-screen max-w-md flex-col justify-center px-4 py-8">
        <div class="mb-6 text-center">
            <a href="{{ route('home') }}" class="text-2xl font-bold text-green-700">Hisabi</a>
            <p class="mt-1 text-sm text-slate-600">সহজ হিসাব, সবার জন্য</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm ring-1 ring-slate-200">
            {{ $slot }}
        </div>
    </div>
</body>
</html>
