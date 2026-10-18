<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Models\WorkspaceMember;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MessDepositController extends Controller
{
    public function store(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorizeWorkspace($request, $workspace);

        $validated = $request->validate([
            'member_id' => ['required', 'integer', 'exists:workspace_members,id'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'deposit_date' => ['required', 'date'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $member = WorkspaceMember::findOrFail($validated['member_id']);
        abort_unless($member->workspace_id === $workspace->id, 404);

        $workspace->messDeposits()->create([
            'member_id' => $member->id,
            'amount' => $validated['amount'],
            'deposit_date' => $validated['deposit_date'],
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('status', 'জমা সংরক্ষণ হয়েছে।');
    }

    protected function authorizeWorkspace(Request $request, Workspace $workspace): void
    {
        abort_unless($workspace->owner_id === $request->user()->id, 403);
    }
}
