<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('registration screen can be rendered', function () {
    $this->get(route('register'))->assertOk();
});

test('new users can register with valid account type', function () {
    $response = $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'account_type' => 'personal',
    ]);

    $response->assertRedirect(route('dashboard'));

    $user = User::where('email', 'test@example.com')->first();
    expect($user)->not->toBeNull();
    expect($user->account_type)->toBe('personal');
    expect($user->trial_starts_at)->not->toBeNull();
    expect($user->trial_ends_at)->not->toBeNull();
    expect($user->trial_ends_at->greaterThan(now()))->toBeTrue();
    $this->assertAuthenticatedAs($user);
});

test('registration requires a valid account type', function () {
    $response = $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'test2@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'account_type' => 'invalid',
    ]);

    $response->assertSessionHasErrors('account_type');
    $this->assertGuest();
});

test('registration rejects duplicate email', function () {
    User::factory()->create(['email' => 'dup@example.com']);

    $response = $this->post(route('register'), [
        'name' => 'Test User',
        'email' => 'dup@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123',
        'account_type' => 'business',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest();
});
