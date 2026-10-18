@extends('layouts.admin')

@section('title', 'ব্যবহারকারী বিবরণ')

@section('content')
    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <p><strong>নাম:</strong> {{ $user->name }}</p>
        <p><strong>ইমেইল:</strong> {{ $user->email }}</p>
        <p><strong>ধরন:</strong> {{ $user->account_type }}</p>
        <p><strong>ট্রায়াল শেষ:</strong> {{ $user->trial_ends_at?->format('d M Y') }}</p>
        <p><strong>সাসপেন্ড:</strong> {{ $user->isSuspended() ? 'হ্যাঁ' : 'না' }}</p>

        <div class="mt-4 flex gap-2">
            @if ($user->isSuspended())
                <form method="POST" action="{{ route('admin.users.reactivate', $user) }}">
                    @csrf
                    <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white">রিঅ্যাক্টিভেট</button>
                </form>
            @else
                <form method="POST" action="{{ route('admin.users.suspend', $user) }}">
                    @csrf
                    <button class="rounded-lg bg-red-600 px-4 py-2 text-sm font-semibold text-white">সাসপেন্ড</button>
                </form>
            @endif
        </div>
    </div>

    <div class="mt-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">সাবস্ক্রিপশন</h2>
        <ul class="divide-y divide-slate-100">
            @foreach ($user->subscriptions as $sub)
                <li class="py-2 text-sm">{{ $sub->status }} — {{ $sub->ends_at?->format('d M Y') }}</li>
            @endforeach
        </ul>
    </div>

    <div class="mt-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">পেমেন্ট</h2>
        <ul class="divide-y divide-slate-100">
            @foreach ($user->paymentRecords as $pay)
                <li class="py-2 text-sm">{{ $pay->transaction_reference }} — {{ $pay->amount }} {{ $pay->currency }} ({{ $pay->status }})</li>
            @endforeach
        </ul>
    </div>
@endsection
PHP