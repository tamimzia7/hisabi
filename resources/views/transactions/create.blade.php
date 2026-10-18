<x-layouts.app>
    <h1 class="mb-4 text-2xl font-bold text-slate-900">নতুন লেনদেন</h1>

    <form method="POST" action="{{ route('transactions.store') }}" class="max-w-xl space-y-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        @csrf

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">ধরন</label>
            <select name="type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
                <option value="income">আয়</option>
                <option value="expense">খরচ</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">পরিমাণ</label>
            <input name="amount" type="number" step="0.01" min="0.01" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">তারিখ</label>
            <input name="transaction_date" type="date" value="{{ now()->toDateString() }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">ক্যাটাগরি</label>
            <select name="category_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base">
                <option value="">নির্বাচন করুন</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">বিবরণ</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base"></textarea>
        </div>

        <button class="w-full rounded-lg bg-green-600 px-4 py-3 text-base font-semibold text-white hover:bg-green-700">সংরক্ষণ করুন</button>
    </form>
</x-layouts.app>
