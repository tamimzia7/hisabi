<x-layouts.app>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-slate-900">লেনদেন</h1>
        <a href="{{ route('transactions.create') }}" class="rounded-lg bg-yellow-400 px-4 py-2 text-sm font-semibold text-slate-900 hover:bg-yellow-500">নতুন লেনদেন</a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-900">{{ session('status') }}</div>
    @endif

    <div class="mb-4 grid gap-3 sm:grid-cols-3">
        <div class="rounded-xl bg-green-50 p-4">
            <p class="text-xs text-green-900">মোট আয়</p>
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

    <form method="GET" action="{{ route('transactions.index') }}" class="mb-4 grid gap-2 sm:grid-cols-4">
        <select name="type" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">সব ধরন</option>
            <option value="income" @selected(request('type')==='income')>আয়</option>
            <option value="expense" @selected(request('type')==='expense')>খরচ</option>
        </select>
        <select name="category_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <option value="">সব ক্যাটাগরি</option>
            @foreach ($categories as $cat)
                <option value="{{ $cat->id }}" @selected(request('category_id')==$cat->id)>{{ $cat->name }}</option>
            @endforeach
        </select>
        <input type="date" name="from" value="{{ request('from') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <input type="date" name="to" value="{{ request('to') }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">ফিল্টার</button>
    </form>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3">তারিখ</th>
                    <th class="px-4 py-3">ধরন</th>
                    <th class="px-4 py-3">ক্যাটাগরি</th>
                    <th class="px-4 py-3">বিবরণ</th>
                    <th class="px-4 py-3 text-right">পরিমাণ</th>
                    <th class="px-4 py-3">কার্যক্রম</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @forelse ($transactions as $tx)
                    <tr>
                        <td class="px-4 py-3">{{ $tx->transaction_date->format('d M Y') }}</td>
                        <td class="px-4 py-3">
                            @if ($tx->type === 'income')
                                <span class="text-green-900 font-medium">আয়</span>
                            @else
                                <span class="text-red-700 font-medium">খরচ</span>
                            @endif
                        </td>
                        <td class="px-4 py-3">{{ $tx->category?->name ?? '-' }}</td>
                        <td class="px-4 py-3">{{ $tx->description ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-medium">{{ $tx->amount }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('transactions.edit', $tx) }}" class="text-blue-600 hover:underline">এডিট</a>
                            <form method="POST" action="{{ route('transactions.destroy', $tx) }}" class="inline" onsubmit="return confirm('মুছে ফেলবেন?')">
                                @csrf
                                @method('DELETE')
                                <button class="ml-2 text-red-600 hover:underline">মুছুন</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-4 py-6 text-center text-slate-500">কোনো লেনদেন নেই।</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $transactions->links() }}
    </div>
</x-layouts.app>
