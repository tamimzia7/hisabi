<?php

use App\Models\MessExpense;
use App\Models\User;
use App\Models\Workspace;
use App\Services\MessAccountingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('zero meals does not divide by zero', function () {
    $user = User::factory()->create();
    $workspace = Workspace::factory()->create(['owner_id' => $user->id, 'type' => 'mess', 'settings' => []]);
    MessExpense::create(['workspace_id' => $workspace->id, 'expense_date' => now()->toDateString(), 'category' => 'market', 'amount' => '100.00']);

    $report = app(MessAccountingService::class)->monthlyReport($workspace, (int) now()->year, (int) now()->month);

    expect($report['total_meals'])->toBe(0);
    expect($report['meal_rate'])->toBe('0.0000');
});

test('user cannot view another users workspace', function () {
    $owner = User::factory()->create();
    $other = User::factory()->create();
    $workspace = Workspace::factory()->create(['owner_id' => $owner->id, 'type' => 'mess']);

    $this->actingAs($other)
        ->get(route('workspaces.show', $workspace))
        ->assertForbidden();
});

test('expired user cannot create mess workspace', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);

    $this->actingAs($user)
        ->post(route('workspaces.store'), ['name' => 'Test Mess'])
        ->assertRedirect(route('subscription.index'));
});
