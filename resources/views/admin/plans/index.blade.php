@extends('layouts.admin')

@section('title', 'প্ল্যান')

@section('content')
    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">নতুন প্ল্যান</h2>
        <form method="POST" action="{{ route('admin.plans.store') }}" class="grid gap-2 sm:grid-cols-6">
            @csrf
            <input name="name" placeholder="নাম" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="slug" placeholder="slug" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="price" type="number" step="0.01" min="0" placeholder="দাম" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="currency" value="BDT" maxlength="3" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="duration_days" type="number" min="1" placeholder="দিন" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <button class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900">তৈরি</button>
        </form>
    </div>

    <div class="space-y-4">
        @foreach ($plans as $plan)
            <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
                <form method="POST" action="{{ route('admin.plans.update', $plan) }}" class="grid gap-2 sm:grid-cols-6">
                    @csrf
                    @method('PUT')
                    <input name="name" value="{{ $plan->name }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <input name="price" type="number" step="0.01" min="0" value="{{ $plan->price }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <input name="currency" value="{{ $plan->currency }}" maxlength="3" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <input name="duration_days" type="number" min="1" value="{{ $plan->duration_days }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                    <label class="flex items-center gap-2 text-sm">
                        <input type="checkbox" name="is_active" value="1" @checked($plan->is_active)> সক্রিয়
                    </label>
                    <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">আপডেট</button>
                </form>
            </div>
        @endforeach
    </div>
    <div class="mt-4">{{ $plans->links() }}</div>
@endsection
PHP