@extends('layouts.admin')

@section('title', 'পেমেন্ট')

@section('content')
    <form method="GET" action="{{ route('admin.payments.index') }}" class="mb-4 flex gap-2">
        <input name="search" value="{{ request('search') }}" placeholder="রেফারেন্স" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <select name="status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">সব</option>
            <option value="pending" @selected(request('status')==='pending')>Pending</option>
            <option value="successful" @selected(request('status')==='successful')>Successful</option>
            <option value="failed" @selected(request('status')==='failed')>Failed</option>
        </select>
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">ফিল্টার</button>
    </form>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3">রেফারেন্স</th>
                    <th class="px-4 py-3">ব্যবহারকারী</th>
                    <th class="px-4 py-3">প্ল্যান</th>
                    <th class="px-4 py-3">পরিমাণ</th>
                    <th class="px-4 py-3">অবস্থা</th>
                    <th class="px-4 py-3">তারিখ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($payments as $pay)
                    <tr>
                        <td class="px-4 py-3">{{ $pay->transaction_reference }}</td>
                        <td class="px-4 py-3">{{ $pay->user?->email }}</td>
                        <td class="px-4 py-3">{{ $pay->plan?->name }}</td>
                        <td class="px-4 py-3">{{ $pay->amount }} {{ $pay->currency }}</td>
                        <td class="px-4 py-3">{{ $pay->status }}</td>
                        <td class="px-4 py-3">{{ $pay->created_at->format('d M Y') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $payments->links() }}</div>
@endsection
PHP