<?php

namespace App\Http\Controllers;

use App\Models\MessExpense;
use App\Models\Workspace;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class MessExpenseController extends Controller
{
    public function store(Request $request, Workspace $workspace): RedirectResponse
    {
        $this->authorizeWorkspace($request, $workspace);

        $validated = $request->validate([
            'expense_date' => ['required', 'date'],
            'category' => ['required', 'string', 'in:market,rent,gas,electricity,water,other'],
            'amount' => ['required', 'numeric', 'min:0.01'],
            'description' => ['nullable', 'string', 'max:500'],
        ]);

        $workspace->messExpenses()->create([
            'expense_date' => $validated['expense_date'],
            'category' => $validated['category'],
            'amount' => $validated['amount'],
            'description' => $validated['description'] ?? null,
        ]);

        return back()->with('status', 'খরচ যোগ হয়েছে।');
    }

    public function destroy(Request $request, Workspace $workspace, MessExpense $expense): RedirectResponse
    {
        $this->authorizeWorkspace($request, $workspace);
        abort_unless($expense->workspace_id === $workspace->id, 404);

        $expense->delete();

        return back()->with('status', 'খরচ মুছে ফেলা হয়েছে।');
    }

    protected function authorizeWorkspace(Request $request, Workspace $workspace): void
    {
        abort_unless($workspace->owner_id === $request->user()->id, 403);
    }
}
