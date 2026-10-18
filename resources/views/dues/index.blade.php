<x-layouts.app>
    <h1 class="mb-4 text-2xl font-bold text-slate-900">বাকি হিসাব</h1>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <div class="mb-4 grid gap-3 sm:grid-cols-2">
        <div class="rounded-xl bg-green-50 p-4">
            <p class="text-xs text-green-700">পাব (receivable)</p>
            <p class="text-xl font-bold text-green-900">{{ $receivableTotal }}</p>
        </div>
        <div class="rounded-xl bg-red-50 p-4">
            <p class="text-xs text-red-700">দেব (payable)</p>
            <p class="text-xl font-bold text-red-900">{{ $payableTotal }}</p>
        </div>
    </div>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">নতুন কন্টাক্ট</h2>
        <form method="POST" action="{{ route('contacts.store') }}" class="grid gap-2 sm:grid-cols-3">
            @csrf
            <input name="name" placeholder="নাম" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="phone" placeholder="ফোন" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <select name="type" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                <option value="customer">কাস্টমার</option>
                <option value="supplier">সাপ্লায়ার</option>
            </select>
            <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white sm:col-span-3">যোগ করুন</button>
        </form>
    </div>

    <div class="mb-6 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        <h2 class="mb-3 text-lg font-semibold">নতুন বাকি</h2>
        <form method="POST" action="{{ route('dues.store') }}" class="grid gap-2 sm:grid-cols-4">
            @csrf
            <select name="contact_id" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                <option value="">কন্টাক্ট</option>
                @foreach ($contacts as $c)
                    <option value="{{ $c->id }}">{{ $c->name }}</option>
                @endforeach
            </select>
            <select name="type" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                <option value="receivable">পাব</option>
                <option value="payable">দেব</option>
            </select>
            <input name="amount" type="number" step="0.01" min="0.01" placeholder="পরিমাণ" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
            <input name="due_date" type="date" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
            <button class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white sm:col-span-4">বাকি যোগ করুন</button>
        </form>
    </div>

    @foreach ($contacts as $contact)
        <div class="mb-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
            <h3 class="text-lg font-semibold text-slate-900">{{ $contact->name }} <span class="text-xs text-slate-500">({{ $contact->type }})</span></h3>
            @foreach ($contact->dues as $due)
                <div class="mt-3 rounded-lg border border-slate-100 p-3">
                    <div class="flex flex-wrap items-center justify-between gap-2">
                        <span class="text-sm font-medium">
                            {{ $due->type === 'receivable' ? 'পাব' : 'দেব' }} — {{ $due->amount }}
                            (বাকি: {{ $due->outstanding() }})
                        </span>
                        <span class="text-xs text-slate-500">{{ $due->status }}</span>
                    </div>
                    <form method="POST" action="{{ route('dues.payments.store', $due) }}" class="mt-2 grid gap-2 sm:grid-cols-3">
                        @csrf
                        <input name="amount" type="number" step="0.01" min="0.01" placeholder="পেমেন্ট" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                        <input name="payment_date" type="date" value="{{ now()->toDateString() }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm" required>
                        <button class="rounded-lg bg-blue-600 px-4 py-2 text-sm font-semibold text-white">পেমেন্ট যোগ</button>
                    </form>
                </div>
            @endforeach
        </div>
    @endforeach
</x-layouts.app>
