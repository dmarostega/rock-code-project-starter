<?php

use App\Models\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;

const PASSWORD_RESET_STATUS = 'Se houver uma conta associada a este e-mail, você receberá instruções para redefinir sua senha.';

it('renders the password reset request page', function (): void {
    $this->get('/forgot-password')
        ->assertOk()
        ->assertInertia(fn ($page) => $page->component('auth/ForgotPassword'));
});

it('renders the password reset page with token and email', function (): void {
    $this->get('/reset-password/token-de-teste?email=cliente%40example.com')
        ->assertOk()
        ->assertInertia(fn ($page) => $page
            ->component('auth/ResetPassword')
            ->where('token', 'token-de-teste')
            ->where('email', 'cliente@example.com'));
});

it('sends a password reset link notification', function (): void {
    Notification::fake();
    $user = User::factory()->create(['email' => 'cliente@example.com']);

    $this->post('/forgot-password', [
        'email' => 'cliente@example.com',
    ])->assertSessionHas('status', PASSWORD_RESET_STATUS);

    Notification::assertSentTo($user, ResetPassword::class);
});

it('does not reveal whether a password reset email is registered', function (): void {
    Notification::fake();

    $this->post('/forgot-password', [
        'email' => 'nao-cadastrado@example.com',
    ])->assertSessionHas('status', PASSWORD_RESET_STATUS);

    Notification::assertNothingSent();
});

it('resets the password with a valid token', function (): void {
    Notification::fake();
    $user = User::factory()->create([
        'email' => 'cliente@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->post('/forgot-password', [
        'email' => 'cliente@example.com',
    ])->assertSessionHas('status', PASSWORD_RESET_STATUS);

    $token = null;
    Notification::assertSentTo(
        $user,
        ResetPassword::class,
        function (ResetPassword $notification) use (&$token): bool {
            $token = $notification->token;

            return true;
        },
    );

    $this->post('/reset-password', [
        'token' => $token,
        'email' => 'cliente@example.com',
        'password' => 'nova-senha-segura',
        'password_confirmation' => 'nova-senha-segura',
    ])->assertSessionHas('status');

    expect(Hash::check('nova-senha-segura', $user->fresh()->password))->toBeTrue();
});

it('rejects an invalid password reset token', function (): void {
    $user = User::factory()->create([
        'email' => 'cliente@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->from('/reset-password/token-invalido')->post('/reset-password', [
        'token' => 'token-invalido',
        'email' => 'cliente@example.com',
        'password' => 'nova-senha-segura',
        'password_confirmation' => 'nova-senha-segura',
    ])->assertRedirect('/reset-password/token-invalido')->assertSessionHasErrors('email');

    expect(Hash::check('password', $user->fresh()->password))->toBeTrue();
});
