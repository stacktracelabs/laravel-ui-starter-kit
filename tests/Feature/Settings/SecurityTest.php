<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Testing\AssertableInertia as Assert;
use Laravel\Fortify\Features;

use function Pest\Laravel\actingAs;

test('security page is displayed', function () {
    skipUnlessFortifyHas(Features::twoFactorAuthentication());

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);
    /* @chisel-passkeys */
    Features::passkeys([
        'confirmPassword' => true,
    ]);
    /* @end-chisel-passkeys */

    $user = User::factory()->create();

    actingAs($user)
        /* @chisel-password-confirmation */
        ->withSession(['auth.password_confirmed_at' => time()])
        /* @end-chisel-password-confirmation */
        ->get(route('security.edit'))
        ->assertInertia(fn (Assert $page) => $page
            ->component('Settings/Security')
            /* @chisel-passkeys */
            ->where('canManagePasskeys', true)
            ->where('passkeys', [])
            /* @end-chisel-passkeys */
            ->where('canManageTwoFactor', true)
            ->where('twoFactorEnabled', false),
        );
});

/* @chisel-password-confirmation */
test('security page requires password confirmation when enabled', function () {
    skipUnlessFortifyHas(Features::twoFactorAuthentication());

    $user = User::factory()->create();

    Features::twoFactorAuthentication([
        'confirm' => true,
        'confirmPassword' => true,
    ]);

    actingAs($user)->get(route('security.edit'))
        ->assertRedirect(route('password.confirm'));
});
/* @end-chisel-password-confirmation */

test('security page renders without two factor when feature is disabled', function () {
    skipUnlessFortifyHas(Features::twoFactorAuthentication());

    config(['fortify.features' => []]);

    $user = User::factory()->create();

    actingAs($user)
        /* @chisel-password-confirmation */
        ->withSession(['auth.password_confirmed_at' => time()])
        /* @end-chisel-password-confirmation */
        ->get(route('security.edit'))
        ->assertOk()
        ->assertInertia(fn (Assert $page) => $page
            ->component('Settings/Security')
            /* @chisel-passkeys */
            ->where('canManagePasskeys', false)
            ->where('passkeys', [])
            /* @end-chisel-passkeys */
            ->where('canManageTwoFactor', false)
            ->missing('twoFactorEnabled')
            ->missing('requiresConfirmation'),
        );
});

test('password can be updated', function () {
    $user = User::factory()->create();

    actingAs($user)->from(route('security.edit'))
        ->put(route('user-password.update'), [
            'current_password' => 'password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertSessionHasNoErrors()
        ->assertRedirect(route('security.edit'));

    expect(Hash::check('new-password', $user->refresh()->password))->toBeTrue();
});

test('correct password must be provided to update password', function () {
    $user = User::factory()->create();

    actingAs($user)->from(route('security.edit'))
        ->put(route('user-password.update'), [
            'current_password' => 'wrong-password',
            'password' => 'new-password',
            'password_confirmation' => 'new-password',
        ])
        ->assertSessionHasErrors('current_password')
        ->assertRedirect(route('security.edit'));
});
