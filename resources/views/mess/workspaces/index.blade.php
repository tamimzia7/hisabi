<x-layouts.app>
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-2xl font-bold text-slate-900">মেস ওয়ার্কস্পেস</h1>
        <a href="{{ route('workspaces.create') }}" class="rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white hover:bg-green-700">নতুন মেস</a>
    </div>

    @if (session('status'))
        <div class="mb-4 rounded-lg bg-green-50 p-3 text-sm text-green-700">{{ session('status') }}</div>
    @endif

    <div class="grid gap-3">
        @forelse ($workspaces as $ws)
            <a href="{{ route('workspaces.show', $ws) }}" class="block rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200 hover:ring-green-300">
                <h2 class="text-lg font-semibold text-slate-900">{{ $ws->name }}</h2>
                <p class="text-sm text-slate-600">সদস্য: {{ $ws->members()->count() }}</p>
            </a>
        @empty
            <p class="text-slate-500">কোনো মেস ওয়ার্কস্পেস নেই।</p>
        @endforelse
    </div>
</x-layouts.app>
