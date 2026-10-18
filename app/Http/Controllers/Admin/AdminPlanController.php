<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\SubscriptionPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPlanController extends Controller
{
    public function index(): View
    {
        $plans = SubscriptionPlan::latest()->paginate(20);

        return view('admin.plans.index', compact('plans'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', 'unique:subscription_plans,slug'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $plan = SubscriptionPlan::create([
            'name' => $validated['name'],
            'slug' => $validated['slug'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'currency' => strtoupper($validated['currency']),
            'duration_days' => $validated['duration_days'],
            'is_active' => (bool) ($validated['is_active'] ?? true),
        ]);

        AuditLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'plan.created',
            'target_type' => SubscriptionPlan::class,
            'target_id' => $plan->id,
            'metadata' => ['name' => $plan->name],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'প্ল্যান তৈরি হয়েছে।');
    }

    public function update(Request $request, SubscriptionPlan $plan): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'currency' => ['required', 'string', 'size:3'],
            'duration_days' => ['required', 'integer', 'min:1'],
            'is_active' => ['nullable', 'boolean'],
        ]);

        $plan->update([
            'name' => $validated['name'],
            'description' => $validated['description'] ?? null,
            'price' => $validated['price'],
            'currency' => strtoupper($validated['currency']),
            'duration_days' => $validated['duration_days'],
            'is_active' => (bool) ($validated['is_active'] ?? false),
        ]);

        AuditLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'plan.updated',
            'target_type' => SubscriptionPlan::class,
            'target_id' => $plan->id,
            'metadata' => ['name' => $plan->name],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'প্ল্যান আপডেট হয়েছে।');
    }
}
