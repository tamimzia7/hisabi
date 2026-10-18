@extends('layouts.admin')

@section('title', 'অ্যাডমিন ড্যাশবোর্ড')

@section('content')
    <div class="grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">মোট ব্যবহারকারী</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['users_total'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">Personal / Mess / Business</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['personal'] }} / {{ $stats['mess'] }} / {{ $stats['business'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">সক্রিয় ট্রায়াল</p>
            <p class="text-2xl font-bold text-green-900">{{ $stats['trial_active'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">মেয়াদ শেষ ট্রায়াল</p>
            <p class="text-2xl font-bold text-red-700">{{ $stats['trial_expired'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">সক্রিয় সাবস্ক্রিপশন</p>
            <p class="text-2xl font-bold text-green-900">{{ $stats['subscriptions_active'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">মেয়াদ শেষ সাবস্ক্রিপশন</p>
            <p class="text-2xl font-bold text-red-700">{{ $stats['subscriptions_expired'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">যাচাইকৃত পেমেন্ট</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['payments_verified'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <p class="text-xs text-slate-500">পেন্ডিং পেমেন্ট</p>
            <p class="text-2xl font-bold text-amber-700">{{ $stats['payments_pending'] }}</p>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 sm:col-span-2">
            <p class="text-xs text-slate-500">যাচাইকৃত রাজস্ব (gross)</p>
            <p class="text-2xl font-bold text-slate-900">{{ $stats['revenue'] }}</p>
        </div>
    </div>

    <div class="mt-6 grid gap-4 lg:grid-cols-2">
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <h2 class="mb-3 text-lg font-semibold">সাম্প্রতিক নিবন্ধন</h2>
            <ul class="divide-y divide-slate-100">
                @foreach ($recentUsers as $u)
                    <li class="py-2 text-sm">
                        <span class="font-medium">{{ $u->name }}</span>
                        <span class="text-slate-500">— {{ $u->email }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
        <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <h2 class="mb-3 text-lg font-semibold">সাম্প্রতিক সাবস্ক্রিপশন</h2>
            <ul class="divide-y divide-slate-100">
                @foreach ($recentSubscriptions as $s)
                    <li class="py-2 text-sm">
                        <span class="font-medium">{{ $s->user?->email }}</span>
                        <span class="text-slate-500">— {{ $s->status }}</span>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
@endsection
PHP