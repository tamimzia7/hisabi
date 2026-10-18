<?php

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

test('guests cannot access admin dashboard', function () {
    $this->get(route('admin.dashboard'))->assertRedirect(route('login'));
});

test('ordinary users cannot access admin dashboard', function () {
    $user = User::factory()->create(['is_admin' => false]);

    $this->actingAs($user)->get(route('admin.dashboard'))->assertForbidden();
});

test('admin users can access admin dashboard', function () {
    $admin = User::factory()->create(['is_admin' => true]);

    $this->actingAs($admin)->get(route('admin.dashboard'))->assertOk();
});

test('ordinary users cannot suspend users', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $target = User::factory()->create();

    $this->actingAs(User::factory()->create(['is_admin' => false]))
        ->post(route('admin.users.suspend', $target))
        ->assertForbidden();

    expect($target->fresh()->isSuspended())->toBeFalse();
});

test('admin can suspend and reactivate user', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    $target = User::factory()->create(['is_admin' => false]);

    $this->actingAs($admin)->post(route('admin.users.suspend', $target))->assertRedirect();
    expect($target->fresh()->isSuspended())->toBeTrue();

    $this->actingAs($admin)->post(route('admin.users.reactivate', $target))->assertRedirect();
    expect($target->fresh()->isSuspended())->toBeFalse();
});

test('admin dashboard shows real user counts', function () {
    $admin = User::factory()->create(['is_admin' => true]);
    User::factory()->count(3)->create(['account_type' => 'personal']);

    $response = $this->actingAs($admin)->get(route('admin.dashboard'));

    $response->assertOk();
    $response->assertSee('মোট ব্যবহারকারী');
});
