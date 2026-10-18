<x-layouts.app>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-slate-900">{{ $workspace->name }}</h1>
        <a href="{{ route('mess.reports.monthly', $workspace) }}" class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white hover:bg-blue-700">মাসিক রিপোর্ট</a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-900">{{ session('status') }}</div>
    @endif

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">নতুন সদস্য</h2>
        <form method="POST" action="{{ route('mess.members.store', $workspace) }}" class="grid gap-2 sm:grid-cols-3">
            @csrf
            <input name="name" placeholder="নাম" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="phone" placeholder="ফোন" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <button class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900">যোগ করুন</button>
        </form>
    </div>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">মিল যোগ করুন</h2>
        <form method="POST" action="{{ route('mess.meals.store', $workspace) }}" class="grid gap-2 sm:grid-cols-5">
            @csrf
            <select name="member_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                <option value="">সদস্য</option>
                @foreach ($workspace->members as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                @endforeach
            </select>
            <input name="meal_date" type="date" value="{{ now()->toDateString() }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="breakfast" type="number" min="0" max="10" placeholder="সকাল" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <input name="lunch" type="number" min="0" max="10" placeholder="দুপুর" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <input name="dinner" type="number" min="0" max="10" placeholder="রাত" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <button class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900 sm:col-span-5">মিল সংরক্ষণ</button>
        </form>
    </div>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">বাজার/খরচ যোগ করুন</h2>
        <form method="POST" action="{{ route('mess.expenses.store', $workspace) }}" class="grid gap-2 sm:grid-cols-4">
            @csrf
            <input name="expense_date" type="date" value="{{ now()->toDateString() }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <select name="category" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                <option value="market">বাজার</option>
                <option value="rent">ভাড়া</option>
                <option value="gas">গ্যাস</option>
                <option value="electricity">বিদ্যুৎ</option>
                <option value="water">পানি</option>
                <option value="other">অন্যান্য</option>
            </select>
            <input name="amount" type="number" step="0.01" min="0.01" placeholder="পরিমাণ" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="description" placeholder="বিবরণ" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <button class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900 sm:col-span-4">খরচ যোগ</button>
        </form>
    </div>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">জমা যোগ করুন</h2>
        <form method="POST" action="{{ route('mess.deposits.store', $workspace) }}" class="grid gap-2 sm:grid-cols-4">
            @csrf
            <select name="member_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                <option value="">সদস্য</option>
                @foreach ($workspace->members as $m)
                    <option value="{{ $m->id }}">{{ $m->name }}</option>
                @endforeach
            </select>
            <input name="amount" type="number" step="0.01" min="0.01" placeholder="পরিমাণ" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="deposit_date" type="date" value="{{ now()->toDateString() }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="description" placeholder="বিবরণ" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <button class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900 sm:col-span-4">জমা সংরক্ষণ</button>
        </form>
    </div>

    <div class="rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">সদস্য তালিকা</h2>
        <ul class="divide-y divide-slate-100">
            @foreach ($workspace->members as $member)
                <li class="py-2 text-sm">
                    {{ $member->name }} @if(! $member->is_active) <span class="text-xs text-red-600">(নিষ্ক্রিয়)</span> @endif
                </li>
            @endforeach
        </ul>
    </div>
</x-layouts.app>
