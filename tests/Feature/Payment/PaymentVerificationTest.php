<?php

use App\Models\PaymentRecord;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\PaymentService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    config(['subscription.webhook_secret' => 'test-secret']);
    config(['subscription.currency' => 'BDT']);
});

test('valid payment verification activates subscription', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);
    $plan = SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT', 'duration_days' => 30]);

    $payment = PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'BDT',
    ];
    $signature = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'test-secret');

    $result = app(PaymentService::class)->verifyPayment($payment, $payload, $signature);

    expect($result)->toBeTrue();
    expect($payment->fresh()->status)->toBe('successful');
    expect($user->fresh()->activeSubscription())->not->toBeNull();
    expect($user->fresh()->activeSubscription()->ends_at->greaterThan(now()))->toBeTrue();
});

test('invalid signature is rejected', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT']);
    $payment = PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'BDT',
    ];

    $result = app(PaymentService::class)->verifyPayment($payment, $payload, 'wrong-signature');

    expect($result)->toBeFalse();
    expect($payment->fresh()->status)->toBe('pending');
});

test('amount mismatch is rejected', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT']);
    $payment = PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '50.00',
        'currency' => 'BDT',
    ];
    $signature = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'test-secret');

    $result = app(PaymentService::class)->verifyPayment($payment, $payload, $signature);

    expect($result)->toBeFalse();
    expect($payment->fresh()->status)->toBe('pending');
});

test('currency mismatch is rejected', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT']);
    $payment = PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'USD',
    ];
    $signature = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'test-secret');

    $result = app(PaymentService::class)->verifyPayment($payment, $payload, $signature);

    expect($result)->toBeFalse();
    expect($payment->fresh()->status)->toBe('pending');
});

test('duplicate verification is idempotent', function () {
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT', 'duration_days' => 30]);
    $payment = PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'BDT',
    ];
    $signature = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'test-secret');

    $service = app(PaymentService::class);
    expect($service->verifyPayment($payment, $payload, $signature))->toBeTrue();
    expect($service->verifyPayment($payment->fresh(), $payload, $signature))->toBeTrue();

    expect(Subscription::where('user_id', $user->id)->count())->toBe(1);
});

test('payment without configured secret is not verified', function () {
    config(['subscription.webhook_secret' => null]);
    $user = User::factory()->create();
    $plan = SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT']);
    $payment = PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'BDT',
    ];

    $result = app(PaymentService::class)->verifyPayment($payment, $payload, null);

    expect($result)->toBeFalse();
});
