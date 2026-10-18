<x-layouts.app>
    <h1 class="mb-4 text-2xl font-bold text-slate-900">ড্যাশবোর্ড</h1>

    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <p class="text-sm text-slate-600">স্বাগতম, <span class="font-semibold text-slate-900">{{ $user->name }}</span></p>

        <div class="mt-4 grid gap-3 sm:grid-cols-2">
            <div class="rounded-xl bg-green-50 p-4">
                <p class="text-xs font-medium text-green-700">হিসাবের ধরন</p>
                <p class="mt-1 text-lg font-semibold text-green-900">
                    @php
                        $labels = [
                            'personal' => 'Personal হিসাব',
                            'mess' => 'মেস / ব্যাচেলর হিসাব',
                            'business' => 'ব্যবসার হিসাব',
                        ];
                    @endphp
                    {{ $labels[$user->account_type] ?? 'অজানা' }}
                </p>
            </div>

            <div class="rounded-xl bg-blue-50 p-4">
                <p class="text-xs font-medium text-blue-700">ট্রায়াল অবস্থা</p>
                @if ($user->onTrial())
                    <p class="mt-1 text-lg font-semibold text-blue-900">{{ $user->trialDaysRemaining() }} দিন বাকি</p>
                    <p class="text-xs text-blue-700">শেষ হবে: {{ $user->trial_ends_at?->format('d M Y') }}</p>
                @else
                    <p class="mt-1 text-lg font-semibold text-red-700">ট্রায়াল শেষ</p>
                    <p class="text-xs text-red-600">হিসাব চালিয়ে যেতে সাবস্ক্রিপশন কিনুন।</p>
                @endif
            </div>
        </div>

        @if (in_array($user->account_type, ['personal', 'business'], true) && isset($totals))
            <div class="mt-4 grid gap-3 sm:grid-cols-3">
                <div class="rounded-xl bg-green-50 p-4">
                    <p class="text-xs text-green-700">মোট আয়</p>
                    <p class="text-xl font-bold text-green-900">{{ $totals['income'] }}</p>
                </div>
                <div class="rounded-xl bg-red-50 p-4">
                    <p class="text-xs text-red-700">মোট খরচ</p>
                    <p class="text-xl font-bold text-red-900">{{ $totals['expense'] }}</p>
                </div>
                <div class="rounded-xl bg-blue-50 p-4">
                    <p class="text-xs text-blue-700">ব্যালেন্স</p>
                    <p class="text-xl font-bold text-blue-900">{{ $totals['balance'] }}</p>
                </div>
            </div>

            <div class="mt-4">
                <a href="{{ route('transactions.index') }}" class="inline-block rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">লেনদেন দেখুন</a>
                <a href="{{ route('dues.index') }}" class="ml-2 inline-block rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">বাকি হিসাব</a>
            </div>
        @endif

        @if ($user->account_type === 'mess' && isset($workspaces))
            <div class="mt-4">
                <a href="{{ route('workspaces.index') }}" class="inline-block rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">মেস ওয়ার্কস্পেস</a>
            </div>
        @endif

        <div class="mt-4 flex flex-wrap gap-2">
            <a href="{{ route('subscription.index') }}" class="inline-block rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">সাবস্ক্রিপশন</a>
        </div>

        <p class="mt-4 text-xs text-slate-500">আপনার সংরক্ষিত হিসাবের তথ্য নিরাপদ আছে। ট্রায়াল শেষ হলেও তথ্য মুছে যাবে না।</p>
    </div>
</x-layouts.app>
