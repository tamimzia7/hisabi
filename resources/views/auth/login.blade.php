<x-layouts.guest>
    <h1 class="mb-2 text-xl font-bold text-slate-900">লগইন</h1>
    <p class="mb-6 text-sm text-slate-600">আপনার হিসাবে প্রবেশ করুন।</p>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}" class="space-y-4">
        @csrf

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">ইমেইল</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required autofocus
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">পাসওয়ার্ড</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-slate-600">
                <input type="checkbox" name="remember" value="1" class="h-4 w-4 rounded border-slate-300 text-green-600">
                মনে রাখুন
            </label>
            <a href="{{ route('password.request') }}" class="text-sm font-medium text-green-700 hover:underline">পাসওয়ার্ড ভুলে গেছেন?</a>
        </div>

        <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-3 text-base font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
            লগইন করুন
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        নতুন ব্যবহারকারী? <a href="{{ route('register') }}" class="font-medium text-green-700 hover:underline">নিবন্ধন করুন</a>
    </p>
</x-layouts.guest>
