<x-layouts.app>
    <h1 class="mb-4 text-2xl font-bold text-slate-900">নতুন মেস ওয়ার্কস্পেস</h1>

    <form method="POST" action="{{ route('workspaces.store') }}" class="max-w-xl space-y-4 rounded-2xl bg-white p-5 shadow-sm ring-1 ring-slate-200">
        @csrf
        <div>
            <label class="mb-1 block text-sm font-medium text-slate-700">মেসের নাম</label>
            <input name="name" class="w-full rounded-lg border border-slate-300 px-3 py-2 text-base" required>
        </div>

        <div class="space-y-2">
            <p class="text-sm font-medium text-slate-700">মিল রেটে অন্তর্ভুক্ত করবেন?</p>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="include_rent" value="1"> ভাড়া</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="include_gas" value="1"> গ্যাস</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="include_electricity" value="1"> বিদ্যুৎ</label>
            <label class="flex items-center gap-2 text-sm"><input type="checkbox" name="include_water" value="1"> পানি</label>
        </div>

        <button class="w-full rounded-lg bg-yellow-400 px-4 py-3 text-base font-semibold text-slate-900 hover:bg-yellow-500">তৈরি করুন</button>
    </form>
</x-layouts.app>
