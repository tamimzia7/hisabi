<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Subscription;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminSubscriptionController extends Controller
{
    public function index(Request $request): View
    {
        $query = Subscription::with(['user', 'plan'])->latest();

        if ($request->filled('status')) {
            $query->where('status', $request->string('status'));
        }

        $subscriptions = $query->paginate(20)->withQueryString();

        return view('admin.subscriptions.index', compact('subscriptions'));
    }

    public function extend(Request $request, Subscription $subscription): RedirectResponse
    {
        $validated = $request->validate([
            'days' => ['required', 'integer', 'min:1', 'max:3650'],
        ]);

        $base = $subscription->ends_at && $subscription->ends_at->isFuture()
            ? $subscription->ends_at
            : now();

        $subscription->update([
            'status' => 'active',
            'ends_at' => $base->addDays((int) $validated['days']),
        ]);

        AuditLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'subscription.extended',
            'target_type' => Subscription::class,
            'target_id' => $subscription->id,
            'metadata' => ['days' => $validated['days']],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'সাবস্ক্রিপশন বাড়ানো হয়েছে।');
    }
}
