<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'type' => ['required', 'in:income,expense'],
        ]);

        $request->user()->categories()->create([
            'name' => $validated['name'],
            'type' => $validated['type'],
            'is_default' => false,
        ]);

        return back()->with('status', 'ক্যাটাগরি যোগ হয়েছে।');
    }

    public function destroy(Request $request, Category $category): RedirectResponse
    {
        abort_unless($category->user_id === $request->user()->id, 403);

        $category->delete();

        return back()->with('status', 'ক্যাটাগরি মুছে ফেলা হয়েছে।');
    }
}
