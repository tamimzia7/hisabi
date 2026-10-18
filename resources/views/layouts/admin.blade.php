<!DOCTYPE html>
<html lang="bn">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Admin — {{ config('app.name', 'Hisabi') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-slate-100 text-slate-900 antialiased">
    <div class="flex min-h-screen">
        <aside class="hidden w-64 bg-slate-900 text-slate-100 lg:block">
            <div class="px-4 py-5 text-lg font-bold">Hisabi Admin</div>
            <nav class="space-y-1 px-2">
                <a href="{{ route('admin.dashboard') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-800">ড্যাশবোর্ড</a>
                <a href="{{ route('admin.users.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-800">ব্যবহারকারী</a>
                <a href="{{ route('admin.subscriptions.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-800">সাবস্ক্রিপশন</a>
                <a href="{{ route('admin.payments.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-800">পেমেন্ট</a>
                <a href="{{ route('admin.plans.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-800">প্ল্যান</a>
                <a href="{{ route('admin.audit-logs.index') }}" class="block rounded-lg px-3 py-2 text-sm hover:bg-slate-800">অডিট লগ</a>
            </nav>
        </aside>

        <div class="flex-1">
            <header class="border-b border-slate-200 bg-white">
                <div class="flex items-center justify-between px-4 py-3">
                    <h1 class="text-lg font-semibold text-slate-900">@yield('title', 'Admin')</h1>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="rounded-lg px-3 py-2 text-sm text-slate-700 hover:bg-slate-100">লগআউট</button>
                    </form>
                </div>
            </header>

            <main class="p-4">
                @if (session('status'))
                    <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
                @endif
                @if (session('error'))
                    <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>
</body>
</html>
