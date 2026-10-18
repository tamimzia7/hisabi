<x-layouts.guest>
    <h1 class="mb-2 text-xl font-bold text-slate-900">নিবন্ধন</h1>
    <p class="mb-6 text-sm text-slate-600">আপনার হিসাব শুরু করতে তথ্য দিন।</p>

    @if ($errors->any())
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
        @csrf

        <div>
            <label for="name" class="mb-1 block text-sm font-medium text-slate-700">পুরো নাম</label>
            <input id="name" name="name" type="text" value="{{ old('name') }}" required autofocus
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label for="email" class="mb-1 block text-sm font-medium text-slate-700">ইমেইল</label>
            <input id="email" name="email" type="email" value="{{ old('email') }}" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label for="password" class="mb-1 block text-sm font-medium text-slate-700">পাসওয়ার্ড</label>
            <input id="password" name="password" type="password" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <label for="password_confirmation" class="mb-1 block text-sm font-medium text-slate-700">পাসওয়ার্ড আবার লিখুন</label>
            <input id="password_confirmation" name="password_confirmation" type="password" required
                class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base focus:border-green-500 focus:outline-none focus:ring-2 focus:ring-green-200">
        </div>

        <div>
            <p class="mb-2 text-sm font-medium text-slate-700">হিসাবের ধরন বেছে নিন</p>
            <div class="grid gap-3">
                @php
                    $types = [
                        'personal' => ['title' => 'Personal হিসাব', 'desc' => 'ব্যক্তিগত আয়, খরচ ও বাকি হিসাব।'],
                        'mess' => ['title' => 'মেস / ব্যাচেলর হিসাব', 'desc' => 'মিল, সদস্য, বাজার খরচ ও মিল রেট।'],
                        'business' => ['title' => 'ব্যবসার হিসাব', 'desc' => 'বিক্রি, খরচ, কাস্টমার বাকি ও সাপ্লায়ার পাওনা।'],
                    ];
                @endphp
                @foreach ($types as $value => $info)
                    <label class="flex cursor-pointer items-start gap-3 rounded-xl border border-slate-200 p-4 hover:border-green-400 has-[:checked]:border-green-500 has-[:checked]:bg-green-50">
                        <input type="radio" name="account_type" value="{{ $value }}" class="mt-1 h-5 w-5 text-green-600" {{ old('account_type') === $value ? 'checked' : '' }} required>
                        <span>
                            <span class="block font-semibold text-slate-900">{{ $info['title'] }}</span>
                            <span class="block text-sm text-slate-600">{{ $info['desc'] }}</span>
                        </span>
                    </label>
                @endforeach
            </div>
            @error('account_type')
                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="w-full rounded-lg bg-green-600 px-4 py-3 text-base font-semibold text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-300">
            নিবন্ধন করুন
        </button>
    </form>

    <p class="mt-6 text-center text-sm text-slate-600">
        আগেই অ্যাকাউন্ট আছে? <a href="{{ route('login') }}" class="font-medium text-green-700 hover:underline">লগইন করুন</a>
    </p>
</x-layouts.guest>
