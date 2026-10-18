<?php

use App\Models\PaymentRecord;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {
    config(['subscription.webhook_secret' => 'test-secret']);
    config(['subscription.currency' => 'BDT']);
});

test('webhook activates payment with valid signature', function () {
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

    $response = $this->postJson(route('webhooks.payments'), $payload, [
        'X-Subscription-Signature' => $signature,
    ]);

    $response->assertOk()->assertJson(['success' => true]);
    expect($payment->fresh()->status)->toBe('successful');
});

test('webhook rejects invalid signature', function () {
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

    $response = $this->postJson(route('webhooks.payments'), $payload, [
        'X-Subscription-Signature' => 'bad',
    ]);

    $response->assertStatus(422)->assertJson(['success' => false]);
    expect($payment->fresh()->status)->toBe('pending');
});

test('duplicate webhook is idempotent', function () {
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

    $this->postJson(route('webhooks.payments'), $payload, ['X-Subscription-Signature' => $signature])->assertOk();
    $this->postJson(route('webhooks.payments'), $payload, ['X-Subscription-Signature' => $signature])->assertOk();

    expect(Subscription::where('user_id', $user->id)->count())->toBe(1);
});
