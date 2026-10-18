<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessMemberController extends Controller
{
    public function store(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorizeWorkspace($request, $workspace);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
        ]);

        $workspace->members()->create([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => true,
            'joined_at' => now()->toDateString(),
        ]);

        return back()->with('status', 'সদস্য যোগ হয়েছে।');
    }

    public function update(Request $request, Workspace $workspace, WorkspaceMember $member): RedirectResponse
    {
        $this->authorizeWorkspace($request, $workspace);
        abort_unless($member->workspace_id === $workspace->id, 404);

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:30'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $member->update([
            'name' => $validated['name'],
            'phone' => $validated['phone'] ?? null,
            'is_active' => (bool) ($validated['is_active'] ?? $member->is_active),
            'left_at' => (! ($validated['is_active'] ?? true)) ? now()->toDateString() : null,
        ]);

        return back()->with('status', 'সদস্য আপডেট হয়েছে।');
    }

    protected function authorizeWorkspace(Request $request, Workspace $workspace): void
    {
        abort_unless($workspace->owner_id === $request->user()->id, 403);
    }
}
