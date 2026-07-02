<?php

use App\Models\User;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertGuest;

test('profile page is displayed', function () {
    $user = User::factory()->create();

    actingAs($user)->get(route('profile.edit'))->assertOk();
});

test('profile information can be updated', function () {
    $user = User::factory()->create();

    actingAs($user)->patch(route('profile.update'), [
        'name' => 'Test User',
        'email' => 'test@example.com',
    ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.edit'));

    $user->refresh();

    expect($user)
        ->name->toBe('Test User')
        ->email->toBe('test@example.com')
        ->email_verified_at->toBeNull();
});

/* @chisel-email-verification */
test('email verification status is unchanged when the email address is unchanged', function () {
    $user = User::factory()->create();

    actingAs($user)->patch(route('profile.update'), [
        'name' => 'Test User',
        'email' => $user->email,
    ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('profile.edit'));

    expect($user->refresh()->email_verified_at)->not->toBeNull();
});
/* @end-chisel-email-verification */

test('user can delete their account', function () {
    $user = User::factory()->create();

    actingAs($user)->delete(route('profile.destroy'), [
        'password' => 'password',
    ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('home'));

    assertGuest();
    expect($user->fresh())->toBeNull();
});

test('correct password must be provided to delete account', function () {
    $user = User::factory()->create();

    actingAs($user)->from(route('profile.edit'))
        ->delete(route('profile.destroy'), [
            'password' => 'wrong-password',
        ])
        ->assertSessionHasErrors('password')
        ->assertRedirect(route('profile.edit'));

    expect($user->fresh())->not->toBeNull();
});
