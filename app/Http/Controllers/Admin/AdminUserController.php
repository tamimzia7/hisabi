<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    public function index(Request $request): View
    {
        $query = User::query()->latest();

        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', '%'.$search.'%')
                    ->orWhere('email', 'like', '%'.$search.'%');
            });
        }

        if ($request->filled('account_type')) {
            $query->where('account_type', $request->string('account_type'));
        }

        if ($request->filled('trial_status')) {
            if ($request->string('trial_status') === 'active') {
                $query->where('trial_ends_at', '>', now());
            } else {
                $query->where('trial_ends_at', '<=', now());
            }
        }

        if ($request->filled('subscription_status')) {
            // placeholder filter handled in view via relation; keep simple
        }

        $users = $query->paginate(20)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    public function show(User $user): View
    {
        $user->load(['subscriptions.plan', 'paymentRecords']);

        return view('admin.users.show', compact('user'));
    }

    public function suspend(Request $request, User $user): RedirectResponse
    {
        if ($user->isAdmin()) {
            return back()->with('error', 'অ্যাডমিন অ্যাকাউন্ট সাসপেন্ড করা যাবে না।');
        }

        $user->update(['suspended_at' => now()]);

        AuditLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'user.suspended',
            'target_type' => User::class,
            'target_id' => $user->id,
            'metadata' => ['email' => $user->email],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'ব্যবহারকারী সাসপেন্ড করা হয়েছে।');
    }

    public function reactivate(Request $request, User $user): RedirectResponse
    {
        $user->update(['suspended_at' => null]);

        AuditLog::create([
            'admin_user_id' => $request->user()->id,
            'action' => 'user.reactivated',
            'target_type' => User::class,
            'target_id' => $user->id,
            'metadata' => ['email' => $user->email],
            'ip_address' => $request->ip(),
        ]);

        return back()->with('status', 'ব্যবহারকারী পুনরায় সক্রিয় করা হয়েছে।');
    }
}
