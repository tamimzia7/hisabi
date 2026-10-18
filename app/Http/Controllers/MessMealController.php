<?php

namespace App\Http\Controllers;

use App\Models\MessMeal;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessMealController extends Controller
{
    public function store(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorizeWorkspace($request, $workspace);

        $validated = $request->validate([
            'member_id' => ['required', 'integer', 'exists:workspace_members,id'],
            'meal_date' => ['required', 'date'],
            'breakfast' => ['nullable', 'integer', 'min:0', 'max:10'],
            'lunch' => ['nullable', 'integer', 'min:0', 'max:10'],
            'dinner' => ['nullable', 'integer', 'min:0', 'max:10'],
            'notes' => ['nullable', 'string', 'max:500'],
        ]);

        $member = WorkspaceMember::findOrFail($validated['member_id']);
        abort_unless($member->workspace_id === $workspace->id, 404);

        MessMeal::updateOrCreate(
            ['member_id' => $member->id, 'meal_date' => $validated['meal_date']],
            [
                'workspace_id' => $workspace->id,
                'breakfast' => (int) ($validated['breakfast'] ?? 0),
                'lunch' => (int) ($validated['lunch'] ?? 0),
                'dinner' => (int) ($validated['dinner'] ?? 0),
                'notes' => $validated['notes'] ?? null,
            ]
        );

        return back()->with('status', 'মিল সংরক্ষণ হয়েছে।');
    }

    protected function authorizeWorkspace(Request $request, Workspace $workspace): void
    {
        abort_unless($workspace->owner_id === $request->user()->id, 403);
    }
}
