<?php

use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use App\Services\SubscriptionService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('active trial is reported as trial', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now(),
        'trial_ends_at' => now()->addDays(10),
    ]);

    $service = app(SubscriptionService::class);

    expect($service->status($user))->toBe('trial');
    expect($service->isActive($user))->toBeTrue();
    expect($service->canPerformPaidActions($user))->toBeTrue();
});

test('expired trial without subscription is expired', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);

    $service = app(SubscriptionService::class);

    expect($service->status($user))->toBe('expired');
    expect($service->isActive($user))->toBeFalse();
    expect($service->canPerformPaidActions($user))->toBeFalse();
});

test('active paid subscription grants access', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);
    $plan = SubscriptionPlan::factory()->create();

    Subscription::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'status' => 'active',
        'starts_at' => now(),
        'ends_at' => now()->addDays(30),
    ]);

    $service = app(SubscriptionService::class);

    expect($service->status($user))->toBe('active');
    expect($service->isActive($user))->toBeTrue();
    expect($service->canPerformPaidActions($user))->toBeTrue();
});

test('expired paid subscription restricts paid actions', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);
    $plan = SubscriptionPlan::factory()->create();

    Subscription::factory()->create([
        'user_id' => $user->id,
        'subscription_plan_id' => $plan->id,
        'status' => 'active',
        'starts_at' => now()->subDays(40),
        'ends_at' => now()->subDays(10),
    ]);

    $service = app(SubscriptionService::class);

    expect($service->status($user))->toBe('expired');
    expect($service->canPerformPaidActions($user))->toBeFalse();
});
