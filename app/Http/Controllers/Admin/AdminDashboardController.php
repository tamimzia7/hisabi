<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PaymentRecord;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\View\View;

class AdminDashboardController extends Controller
{
    public function index(): View
    {
        $now = now();

        $stats = [
            'users_total' => User::count(),
            'personal' => User::where('account_type', 'personal')->count(),
            'mess' => User::where('account_type', 'mess')->count(),
            'business' => User::where('account_type', 'business')->count(),
            'trial_active' => User::where('trial_ends_at', '>', $now)->count(),
            'trial_expired' => User::where('trial_ends_at', '<=', $now)->count(),
            'subscriptions_active' => Subscription::where('status', 'active')->where('ends_at', '>', $now)->count(),
            'subscriptions_expired' => Subscription::where(function ($q) use ($now) {
                $q->where('status', '!=', 'active')->orWhere('ends_at', '<=', $now);
            })->count(),
            'payments_verified' => PaymentRecord::where('status', 'successful')->count(),
            'payments_pending' => PaymentRecord::where('status', 'pending')->count(),
            'revenue' => (string) PaymentRecord::where('status', 'successful')->sum('amount'),
        ];

        $recentUsers = User::latest()->take(10)->get();
        $recentSubscriptions = Subscription::with(['user', 'plan'])->latest()->take(10)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentSubscriptions'));
    }
}
