<x-layouts.guest>
    <h1 class="mb-2 text-xl font-bold text-slate-900">পাসওয়ার্ড রিসেট</h1>
    <p class="mb-6 text-sm text-slate-600">আপনার ইমেইল লিখুন, রিসেট লিংক পাঠানো হবে।</p>

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

    <form method="POST" action="{{ route('password.email') }}" class="space-y-4">
        @csrf
        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">ইমেইল</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-3 text-base font-semibold text-white hover:bg-green-700">
            রিসেট লিংক পাঠান
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        <a href="{{ route('login') }}" class="font-medium text-green-700 hover:underline">লগইনে ফিরে যান</a>
    </p>
</x-layouts.guest>
