<?php

namespace App\Services;

use App\Models\PaymentRecord;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PaymentService
{
    public function __construct(private SubscriptionService $subscriptions) {}

    public function initiate(User $user, SubscriptionPlan $plan): PaymentRecord
    {
        return PaymentRecord::create([
            'user_id' => $user->id,
            'subscription_plan_id' => $plan->id,
            'provider' => config('subscription.provider', 'pending'),
            'transaction_reference' => 'HSB-'.Str::upper(Str::random(16)),
            'amount' => $plan->price,
            'currency' => $plan->currency,
            'status' => 'pending',
        ]);
    }

    public function verifyPayment(PaymentRecord $payment, array $payload, ?string $signature = null): bool
    {
        // Idempotent: already successful payments are not processed again.
        if ($payment->isSuccessful()) {
            return true;
        }

        $secret = config('subscription.webhook_secret');

        // Never trust an unverified callback when a secret is configured.
        if ($secret) {
            $expected = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), $secret);
            if (! $signature || ! hash_equals($expected, $signature)) {
                return false;
            }
        } else {
            // Without a configured secret we cannot trust any callback.
            return false;
        }

        $reference = $payload['transaction_reference'] ?? null;
        $status = strtolower((string) ($payload['status'] ?? ''));
        $amount = $payload['amount'] ?? null;
        $currency = $payload['currency'] ?? null;

        if ($reference !== $payment->transaction_reference) {
            return false;
        }

        if (! in_array($status, ['success', 'successful', 'completed'], true)) {
            if (in_array($status, ['failed', 'cancelled', 'canceled'], true)) {
                $payment->update(['status' => $status === 'completed' ? 'failed' : $status]);
            }
            return false;
        }

        if ($amount === null || bccomp((string) $payment->amount, (string) $amount, 2) !== 0) {
            return false;
        }

        if ($currency !== $payment->currency) {
            return false;
        }

        return DB::transaction(function () use ($payment, $payload) {
            $payment->update([
                'status' => 'successful',
                'verified_at' => now(),
                'metadata' => $this->safeMetadata($payload),
            ]);

            $plan = $payment->plan;
            $duration = $plan?->duration_days ?? 30;

            $subscription = Subscription::create([
                'user_id' => $payment->user_id,
                'subscription_plan_id' => $payment->subscription_plan_id,
                'payment_record_id' => $payment->id,
                'status' => 'active',
                'starts_at' => now(),
                'ends_at' => now()->addDays($duration),
            ]);

            $payment->update(['metadata' => array_merge($payment->metadata ?? [], ['subscription_id' => $subscription->id])]);

            return true;
        });
    }

    public function handleWebhook(Request $request): bool
    {
        $payload = $request->json()->all();
        if (empty($payload)) {
            $payload = $request->all();
        }

        $reference = $payload['transaction_reference'] ?? null;
        if (! $reference) {
            return false;
        }

        $payment = PaymentRecord::where('transaction_reference', $reference)->first();
        if (! $payment) {
            return false;
        }

        $signature = $request->header('X-Subscription-Signature')
            ?: $request->header('X-Webhook-Signature');

        return $this->verifyPayment($payment, $payload, $signature);
    }

    private function safeMetadata(array $payload): array
    {
        unset($payload['card_number'], $payload['cvv'], $payload['password'], $payload['secret']);

        return $payload;
    }
}
