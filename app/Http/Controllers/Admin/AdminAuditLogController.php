<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\View\View;

class AdminAuditLogController extends Controller
{
    public function index(): View
    {
        $logs = AuditLog::with('admin')->latest()->paginate(30);

        return view('admin.audit-logs.index', compact('logs'));
    }
}
