<x-layouts.app>
    <h1 class="mb-4 text-2xl font-bold text-slate-900">লেনদেন এডিট</h1>

    <form method="POST" action="{{ route('transactions.update', $transaction) }}" class="max-w-xl space-y-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        @csrf
        @method('PUT')

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">ধরন</label>
            <select name="type" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
                <option value="income" @selected($transaction->type==='income')>আয়</option>
                <option value="expense" @selected($transaction->type==='expense')>খরচ</option>
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">পরিমাণ</label>
            <input name="amount" type="number" step="0.01" min="0.01" value="{{ $transaction->amount }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">তারিখ</label>
            <input name="transaction_date" type="date" value="{{ $transaction->transaction_date->toDateString() }}" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">ক্যাটাগরি</label>
            <select name="category_id" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base">
                <option value="">নির্বাচন করুন</option>
                @foreach ($categories as $cat)
                    <option value="{{ $cat->id }}" @selected($transaction->category_id==$cat->id)>{{ $cat->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">বিবরণ</label>
            <textarea name="description" rows="3" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base">{{ $transaction->description }}</textarea>
        </div>

        <button class="w-full rounded-lg bg-yellow-400 px-4 py-3 text-base font-semibold text-slate-900 hover:bg-yellow-500">আপডেট করুন</button>
    </form>
</x-layouts.app>
