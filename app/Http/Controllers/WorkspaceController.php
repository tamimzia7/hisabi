<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WorkspaceController extends Controller
{
    public function __construct(private SubscriptionService $subscriptions) {}

    public function index(Request $request): View
    {
        $workspaces = $request->user()->workspaces()->where('type', 'mess')->latest()->get();

        return view('mess.workspaces.index', compact('workspaces'));
    }

    public function create(): View
    {
        return view('mess.workspaces.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'include_rent' => ['nullable', 'boolean'],
            'include_gas' => ['nullable', 'boolean'],
            'include_electricity' => ['nullable', 'boolean'],
            'include_water' => ['nullable', 'boolean'],
        ]);

        $workspace = $request->user()->workspaces()->create([
            'type' => 'mess',
            'name' => $validated['name'],
            'settings' => [
                'include_rent' => (bool) ($validated['include_rent'] ?? false),
                'include_gas' => (bool) ($validated['include_gas'] ?? false),
                'include_electricity' => (bool) ($validated['include_electricity'] ?? false),
                'include_water' => (bool) ($validated['include_water'] ?? false),
            ],
        ]);

        return redirect()->route('mess.workspaces.show', $workspace)
            ->with('status', 'মেস ওয়ার্কস্পেস তৈরি হয়েছে।');
    }

    public function show(Request $request, Workspace $workspace): View
    {
        $this->authorizeWorkspace($request, $workspace);

        $workspace->load(['members', 'messExpenses', 'messDeposits']);

        return view('mess.workspaces.show', compact('workspace'));
    }

    protected function authorizeWorkspace(Request $request, Workspace $workspace): void
    {
        abort_unless($workspace->owner_id === $request->user()->id, 403);
    }
}
