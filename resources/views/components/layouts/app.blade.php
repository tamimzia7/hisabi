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
    <header class="border-b border-slate-200 bg-white">
        <div class="mx-auto flex max-w-4xl items-center justify-between px-4 py-3">
            <a href="{{ route('dashboard') }}" class="text-lg font-bold text-green-700">Hisabi</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="rounded-lg px-3 py-2 text-sm font-medium text-slate-700 hover:bg-slate-100">
                    লগআউট
                </button>
            </form>
        </div>
    </header>

    <main class="mx-auto max-w-4xl px-4 py-6">
        {{ $slot }}
    </main>
</body>
</html>
