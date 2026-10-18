<x-layouts.app>
    <div class="mb-4 flex flex-wrap items-center justify-between gap-2">
        <h1 class="text-2xl font-bold text-slate-900">মাসিক রিপোর্ট — {{ $workspace->name }}</h1>
        <a href="{{ route('workspaces.show', $workspace) }}" class="rounded-lg bg-slate-700 px-4 py-2 text-sm font-semibold text-white hover:bg-slate-800">ফিরে যান</a>
    </div>

    <form method="GET" action="{{ route('mess.reports.monthly', $workspace) }}" class="mb-4 flex gap-2">
        <input name="year" type="number" value="{{ $report['year'] }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <input name="month" type="number" min="1" max="12" value="{{ $report['month'] }}" class="rounded-lg border border-slate-300 px-3 py-2 text-sm">
        <button class="rounded-lg bg-slate-800 px-4 py-2 text-sm font-semibold text-white">দেখুন</button>
    </form>

    <div class="mb-4 grid gap-3 sm:grid-cols-4">
        <div class="rounded-xl bg-slate-50 p-4">
            <p class="text-xs text-slate-600">মোট মিল</p>
            <p class="text-xl font-bold text-slate-900">{{ $report['total_meals'] }}</p>
        </div>
        <div class="rounded-xl bg-slate-50 p-4">
            <p class="text-xs text-slate-600">যোগ্য খরচ</p>
            <p class="text-xl font-bold text-slate-900">{{ $report['eligible_total'] }}</p>
        </div>
        <div class="rounded-xl bg-slate-50 p-4">
            <p class="text-xs text-slate-600">মিল রেট</p>
            <p class="text-xl font-bold text-slate-900">{{ $report['meal_rate'] }}</p>
        </div>
        <div class="rounded-xl bg-slate-50 p-4">
            <p class="text-xs text-slate-600">মোট জমা</p>
            <p class="text-xl font-bold text-slate-900">{{ $report['total_deposits'] }}</p>
        </div>
    </div>

    <div class="overflow-x-auto rounded-2xl bg-white shadow-sm ring-1 ring-slate-200">
        <table class="min-w-full text-sm">
            <thead class="bg-slate-50 text-left text-slate-600">
                <tr>
                    <th class="px-4 py-3">সদস্য</th>
                    <th class="px-4 py-3 text-right">মিল</th>
                    <th class="px-4 py-3 text-right">চার্জ</th>
                    <th class="px-4 py-3 text-right">জমা</th>
                    <th class="px-4 py-3 text-right">ব্যালেন্স</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach ($report['members'] as $row)
                    <tr>
                        <td class="px-4 py-3 font-medium">{{ $row['member']->name }}</td>
                        <td class="px-4 py-3 text-right">{{ $row['meals'] }}</td>
                        <td class="px-4 py-3 text-right">{{ $row['charge'] }}</td>
                        <td class="px-4 py-3 text-right">{{ $row['deposits'] }}</td>
                        <td class="px-4 py-3 text-right {{ (float) $row['balance'] < 0 ? 'text-red-600' : 'text-green-600' }}">{{ $row['balance'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-layouts.app>
