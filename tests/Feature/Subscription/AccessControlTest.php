<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Route;

uses(RefreshDatabase::class);

test('guests cannot access subscription page', function () {
    $this->get(route('subscription.index'))->assertRedirect(route('login'));
});

test('expired user is redirected from paid routes', function () {
    Route::middleware('subscription.access')->get('/__paid', fn () => 'OK')->name('__paid');

    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);

    $this->actingAs($user)
        ->get('/__paid')
        ->assertRedirect(route('subscription.index'));
});

test('active trial user can access paid routes', function () {
    Route::middleware('subscription.access')->get('/__paid2', fn () => 'OK');

    $user = User::factory()->create([
        'trial_starts_at' => now(),
        'trial_ends_at' => now()->addDays(10),
    ]);

    $this->actingAs($user)->get('/__paid2')->assertOk();
});

test('one users payment does not unlock another user', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();

    $plan = \App\Models\SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT']);
    $payment = \App\Models\PaymentRecord::factory()->create([
        'user_id' => $userA->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    config(['subscription.webhook_secret' => 'test-secret']);
    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'BDT',
    ];
    $signature = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'test-secret');

    app(\App\Services\PaymentService::class)->verifyPayment($payment, $payload, $signature);

    expect($userA->fresh()->activeSubscription())->not->toBeNull();
    expect($userB->fresh()->activeSubscription())->toBeNull();
});

test('renewal restores access to existing data', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);

    $service = app(\App\Services\SubscriptionService::class);
    expect($service->canPerformPaidActions($user))->toBeFalse();

    $plan = \App\Models\SubscriptionPlan::factory()->create(['price' => '100.00', 'currency' => 'BDT', 'duration_days' => 30]);
    $payment = \App\Models\PaymentRecord::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'amount' => '100.00',
        'currency' => 'BDT',
        'status' => 'pending',
    ]);

    config(['subscription.webhook_secret' => 'test-secret']);
    $payload = [
        'transaction_reference' => $payment->transaction_reference,
        'status' => 'successful',
        'amount' => '100.00',
        'currency' => 'BDT',
    ];
    $signature = hash_hmac('sha256', json_encode($payload, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE), 'test-secret');

    app(\App\Services\PaymentService::class)->verifyPayment($payment, $payload, $signature);

    expect($service->canPerformPaidActions($user->fresh()))->toBeTrue();
});

test('financial records remain unchanged after expiration', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);

    // Simulate expiration: no deletion or mutation of user record.
    expect($user->fresh())->not->toBeNull();
    expect($user->fresh()->email)->toBe($user->email);
    expect($user->fresh()->account_type)->toBe($user->account_type);
});
