@extends('layouts.admin')

@section('title', 'অডিট লগ')

@section('content')
    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3">অ্যাডমিন</th>
                    <th class="px-4 py-3">অ্যাকশন</th>
                    <th class="px-4 py-3">টার্গেট</th>
                    <th class="px-4 py-3">তারিখ</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($logs as $log)
                    <tr>
                        <td class="px-4 py-3">{{ $log->admin?->email }}</td>
                        <td class="px-4 py-3">{{ $log->action }}</td>
                        <td class="px-4 py-3">{{ $log->target_type }} #{{ $log->target_id }}</td>
                        <td class="px-4 py-3">{{ $log->created_at->format('d M Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="mt-4">{{ $logs->links() }}</div>
@endsection
PHP