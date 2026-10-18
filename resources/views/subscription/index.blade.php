<x-layouts.app>
    <h1 class="mb-4 text-2xl font-bold text-slate-900">সাবস্ক্রিপশন</h1>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-900">{{ session('status') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-4 rounded-lg bg-red-50 p-3 text-sm text-red-700">{{ session('error') }}</div>
    @endif

    <div class="grid gap-4 lg:grid-cols-2">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">বর্তমান অবস্থা</h2>
            <p class="mt-2 text-sm text-slate-600">
                অবস্থা:
                <span class="font-semibold text-slate-900">
                    @if ($status === 'trial') ফ্রি ট্রায়াল
                    @elseif ($status === 'active') সক্রিয় সাবস্ক্রিপশন
                    @else মেয়াদ শেষ
                    @endif
                </span>
            </p>
            @if ($endsAt)
                <p class="mt-1 text-sm text-slate-600">
                    শেষ হবে: <span class="font-semibold">{{ $endsAt->format('d M Y') }}</span>
                    @if ($daysRemaining > 0)
                        ({{ $daysRemaining }} দিন বাকি)
                    @endif
                </p>
            @endif
            @if ($currentSubscription && $currentSubscription->plan)
                <p class="mt-1 text-sm text-slate-600">
                    প্ল্যান: <span class="font-semibold">{{ $currentSubscription->plan->name }}</span>
                </p>
            @endif
        </div>

        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <h2 class="text-lg font-semibold text-slate-900">পেমেন্ট ইতিহাস</h2>
            @if ($paymentHistory->isEmpty())
                <p class="mt-2 text-sm text-slate-600">এখনও কোনো পেমেন্ট নেই।</p>
            @else
                <ul class="mt-2 divide-y divide-slate-100">
                    @foreach ($paymentHistory as $payment)
                        <li class="py-2 text-sm">
                            <span class="font-medium text-slate-900">{{ $payment->transaction_reference }}</span>
                            <span class="text-slate-600">— {{ $payment->amount }} {{ $payment->currency }}</span>
                            <span class="text-xs text-slate-500">({{ $payment->status }})</span>
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>
    </div>

    <div class="mt-6">
        <h2 class="mb-3 text-lg font-semibold text-slate-900">প্ল্যান বেছে নিন</h2>
        @if ($plans->isEmpty())
            <p class="text-sm text-slate-600">এখনও কোনো সক্রিয় প্ল্যান নেই। প্রশাসক প্ল্যান যোগ করলে এখানে দেখাবে।</p>
        @else
            <div class="grid gap-4 sm:grid-cols-2">
                @foreach ($plans as $plan)
                    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                        <h3 class="text-lg font-semibold text-slate-900">{{ $plan->name }}</h3>
                        @if ($plan->description)
                            <p class="mt-1 text-sm text-slate-600">{{ $plan->description }}</p>
                        @endif
                        <p class="mt-3 text-2xl font-bold text-green-900">{{ $plan->price }} {{ $plan->currency }}</p>
                        <p class="text-xs text-slate-500">{{ $plan->duration_days }} দিন</p>

                        <form method="POST" action="{{ route('subscription.checkout') }}" class="mt-4">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                            <button type="submit" class="w-full rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-yellow-500">
                                কিনুন
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <p class="mt-6 text-xs text-slate-500">
        নোট: পেমেন্ট গেটওয়ে কনফিগার না হওয়া পর্যন্ত পেমেন্ট যাচাই সম্পন্ন হবে না। আপনার হিসাবের তথ্য মেয়াদ শেষ হলেও সংরক্ষিত থাকবে।
    </p>
</x-layouts.app>
