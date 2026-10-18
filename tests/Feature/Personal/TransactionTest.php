<?php

use App\Models\Transaction;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('user can create an income transaction', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user)->post(route('transactions.store'), [
        'type' => 'income',
        'amount' => '1500.00',
        'transaction_date' => now()->toDateString(),
        'description' => 'বেতন',
    ]);

    $response->assertRedirect(route('transactions.index'));
    $this->assertDatabaseHas('transactions', [
        'user_id' => $user->id,
        'type' => 'income',
        'amount' => '1500.00',
    ]);
});

test('transaction totals are correct', function () {
    $user = User::factory()->create();
    Transaction::factory()->create(['user_id' => $user->id, 'type' => 'income', 'amount' => '1000.00']);
    Transaction::factory()->create(['user_id' => $user->id, 'type' => 'expense', 'amount' => '300.00']);

    $response = $this->actingAs($user)->get(route('transactions.index'));

    $response->assertOk();
    $response->assertSee('1000.00');
    $response->assertSee('300.00');
});

test('user cannot edit another users transaction', function () {
    $user = User::factory()->create();
    $other = User::factory()->create();
    $tx = Transaction::factory()->create(['user_id' => $other->id]);

    $this->actingAs($user)
        ->get(route('transactions.edit', $tx))
        ->assertForbidden();
});

test('expired user cannot create transaction', function () {
    $user = User::factory()->create([
        'trial_starts_at' => now()->subDays(40),
        'trial_ends_at' => now()->subDays(10),
    ]);

    $this->actingAs($user)
        ->post(route('transactions.store'), [
            'type' => 'income',
            'amount' => '100.00',
            'transaction_date' => now()->toDateString(),
        ])
        ->assertRedirect(route('subscription.index'));
});
