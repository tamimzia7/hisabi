<?php

namespace App\Http\Controllers;

use App\Models\Workspace;
use App\Services\MessAccountingService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MessReportController extends Controller
{
    public function __construct(private MessAccountingService $accounting) {}

    public function monthly(Request $request, Workspace $workspace): View
    {
        $this->authorizeWorkspace($request, $workspace);

        $year = (int) $request->query('year', now()->year);
        $month = (int) $request->query('month', now()->month);

        $report = $this->accounting->monthlyReport($workspace, $year, $month);

        return view('mess.reports.monthly', compact('workspace', 'report'));
    }

    protected function authorizeWorkspace(Request $request, Workspace $workspace): void
    {
        abort_unless($workspace->owner_id === $request->user()->id, 403);
    }
}
