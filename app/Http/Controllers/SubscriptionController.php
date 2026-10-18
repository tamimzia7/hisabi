<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionPlan;
use App\Services\PaymentService;
use App\Services\SubscriptionService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SubscriptionController extends Controller
{
    public function __construct(
        private SubscriptionService $subscriptions,
        private PaymentService $payments,
    ) {}

    public function index(Request $request): View
    {
        $user = $request->user();

        return view('subscription.index', [
            'user' => $user,
            'status' => $this->subscriptions->status($user),
            'endsAt' => $this->subscriptions->endsAt($user),
            'daysRemaining' => $this->subscriptions->daysRemaining($user),
            'plans' => SubscriptionPlan::where('is_active', true)->orderBy('price')->get(),
            'currentSubscription' => $this->subscriptions->currentSubscription($user),
            'paymentHistory' => $user->paymentRecords()->latest()->get(),
        ]);
    }

    public function checkout(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'plan_id' => ['required', 'integer', 'exists:subscription_plans,id'],
        ]);

        $plan = SubscriptionPlan::where('is_active', true)->findOrFail($validated['plan_id']);
        $payment = $this->payments->initiate($request->user(), $plan);

        return redirect()->route('subscription.index')
            ->with('status', 'পেমেন্ট রেকর্ড তৈরি হয়েছে (রেফারেন্স: '.$payment->transaction_reference.')। পেমেন্ট সম্পন্ন করতে গেটওয়ে কনফিগার করুন।');
    }
}
