@extends('layouts.admin')

@section('title', 'সাবস্ক্রিপশন')

@section('content')
    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3">ব্যবহারকারী</th>
                    <th class="px-4 py-3">প্ল্যান</th>
                    <th class="px-4 py-3">অবস্থা</th>
                    <th class="px-4 py-3">শেষ</th>
                    <th class="px-4 py-3">কার্যক্রম</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($subscriptions as $sub)
                    <tr>
                        <td class="px-4 py-3">{{ $sub->user?->email }}</td>
                        <td class="px-4 py-3">{{ $sub->plan?->name }}</td>
                        <td class="px-4 py-3">{{ $sub->status }}</td>
                        <td class="px-4 py-3">{{ $sub->ends_at?->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            <form method="POST" action="{{ route('admin.subscriptions.extend', $sub) }}" class="flex gap-2">
                                @csrf
                                <input name="days" type="number" min="1" value="30" class="w-20 rounded border border-slate-300 px-2 py-1 text-sm">
                                <button class="rounded bg-blue-600 px-3 py-1 text-xs font-semibold text-white">বাড়ান</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $subscriptions->links() }}</div>
@endsection
PHP