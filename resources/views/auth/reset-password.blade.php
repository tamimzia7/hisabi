<x-layouts.guest>
    <h1 class="mb-2 text-xl font-bold text-slate-900">নতুন পাসওয়ার্ড</h1>
    <p class="mb-6 text-sm text-slate-600">আপনার নতুন পাসওয়ার্ড সেট করুন।</p>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" class="space-y-4">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">ইমেইল</label>
            <input id="email" name="email" type="email" value="{{ old('email', $email) }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">নতুন পাসওয়ার্ড</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">পাসওয়ার্ড আবার লিখুন</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-3 text-base font-semibold text-white hover:bg-green-700">
            পাসওয়ার্ড পরিবর্তন করুন
        </button>
    </form>
</x-layouts.guest>
