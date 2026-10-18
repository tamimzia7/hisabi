@extends('layouts.admin')

@section('title', 'ব্যবহারকারী তালিকা')

@section('content')
    <form method="GET" action="{{ route('admin.users.index') }}" class="mb-4 grid gap-2 sm:grid-cols-4">
        <input name="search" value="{{ request('search') }}" placeholder="নাম বা ইমেইল" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <select name="account_type" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">সব ধরন</option>
            <option value="personal" @selected(request('account_type')==='personal')>Personal</option>
            <option value="mess" @selected(request('account_type')==='mess')>Mess</option>
            <option value="business" @selected(request('account_type')==='business')>Business</option>
        </select>
        <select name="trial_status" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">সব ট্রায়াল</option>
            <option value="active" @selected(request('trial_status')==='active')>সক্রিয়</option>
            <option value="expired" @selected(request('trial_status')==='expired')>মেয়াদ শেষ</option>
        </select>
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">ফিল্টার</button>
    </form>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3">নাম</th>
                    <th class="px-4 py-3">ইমেইল</th>
                    <th class="px-4 py-3">ধরন</th>
                    <th class="px-4 py-3">ট্রায়াল শেষ</th>
                    <th class="px-4 py-3">অবস্থা</th>
                    <th class="px-4 py-3">কার্যক্রম</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-3">{{ $user->name }}</td>
                        <td class="px-4 py-3">{{ $user->email }}</td>
                        <td class="px-4 py-3">{{ $user->account_type }}</td>
                        <td class="px-4 py-3">{{ $user->trial_ends_at?->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($user->isSuspended())
                                <span class="text-red-600">সাসপেন্ড</span>
                            @else
                                <span class="text-green-600">সক্রিয়</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.users.show', $user) }}" class="text-blue-600 hover:underline">দেখুন</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div class="mt-4">{{ $users->links() }}</div>
@endsection
PHP