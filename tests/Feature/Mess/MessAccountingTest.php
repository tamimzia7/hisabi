<?php

use App\Models\User;
use App\Models\Workspace;
use App\Models\WorkspaceMember;
use App\Services\MessAccountingService;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('meal rate and member balances are calculated correctly', function () {
    $user = User::factory()->create();
    $workspace = Workspace::factory()->create(['owner_id' => $user->id, 'type' => 'mess', 'settings' => ['include_rent' => false]]);

    $memberA = WorkspaceMember::factory()->create(['workspace_id' => $workspace->id, 'name' => 'A']);
    $memberB = WorkspaceMember::factory()->create(['workspace_id' => $workspace->id, 'name' => 'B']);

    // meals: A 2, B 2 => total 4
    \App\Models\MessMeal::create(['workspace_id' => $workspace->id, 'member_id' => $memberA->id, 'meal_date' => now()->toDateString(), 'breakfast' => 1, 'lunch' => 1, 'dinner' => 0]);
    \App\Models\MessMeal::create(['workspace_id' => $workspace->id, 'member_id' => $memberB->id, 'meal_date' => now()->toDateString(), 'breakfast' => 1, 'lunch' => 0, 'dinner' => 1]);

    // eligible market expense 400
    \App\Models\MessExpense::create(['workspace_id' => $workspace->id, 'expense_date' => now()->toDateString(), 'category' => 'market', 'amount' => '400.00']);

    // deposits
    \App\Models\MessDeposit::create(['workspace_id' => $workspace->id, 'member_id' => $memberA->id, 'amount' => '200.00', 'deposit_date' => now()->toDateString()]);
    \App\Models\MessDeposit::create(['workspace_id' => $workspace->id, 'member_id' => $memberB->id, 'amount' => '100.00', 'deposit_date' => now()->toDateString()]);

    $report = app(MessAccountingService::class)->monthlyReport($workspace, (int) now()->year, (int) now()->month);

    expect($report['total_meals'])->toBe(4);
    expect($report['eligible_total'])->toBe('400.00');
    expect($report['meal_rate'])->toBe('100.0000');

    $rowA = collect($report['members'])->firstWhere('member.id', $memberA->id);
    $rowB = collect($report['members'])->firstWhere('member.id', $memberB->id);

    expect($rowA['meals'])->toBe(2);
    expect($rowA['charge'])->toBe('200.00');
    expect($rowA['deposits'])->toBe('200.00');
    expect($rowA['balance'])->toBe('0.00');

    expect($rowB['meals'])->toBe(2);
    expect($rowB['charge'])->toBe('200.00');
    expect($rowB['deposits'])->toBe('100.00');
    expect($rowB['balance'])->toBe('-100.00');
});

test('rent excluded from meal rate unless configured', function () {
    $user = User::factory()->create();
    $workspace = Workspace::factory()->create(['owner_id' => $user->id, 'type' => 'mess', 'settings' => ['include_rent' => false]]);

    $member = WorkspaceMember::factory()->create(['workspace_id' => $workspace->id]);
    \App\Models\MessMeal::create(['workspace_id' => $workspace->id, 'member_id' => $member->id, 'meal_date' => now()->toDateString(), 'breakfast' => 1, 'lunch' => 0, 'dinner' => 0]);
    \App\Models\MessExpense::create(['workspace_id' => $workspace->id, 'expense_date' => now()->toDateString(), 'category' => 'market', 'amount' => '100.00']);
    \App\Models\MessExpense::create(['workspace_id' => $workspace->id, 'expense_date' => now()->toDateString(), 'category' => 'rent', 'amount' => '500.00']);

    $report = app(MessAccountingService::class)->monthlyReport($workspace, (int) now()->year, (int) now()->month);

    expect($report['eligible_total'])->toBe('100.00');
    expect($report['meal_rate'])->toBe('100.0000');
});
