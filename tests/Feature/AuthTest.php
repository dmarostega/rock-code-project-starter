<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;

it('logs in an existing user', function (): void {
    $user = User::factory()->create([
        'email' => 'cliente@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->post('/login', [
        'email' => 'cliente@example.com',
        'password' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticatedAs($user);
});

it('rejects invalid login credentials', function (): void {
    User::factory()->create([
        'email' => 'cliente@example.com',
        'password' => Hash::make('password'),
    ]);

    $this->from('/login')->post('/login', [
        'email' => 'cliente@example.com',
        'password' => 'senha-incorreta',
    ])->assertRedirect('/login')->assertSessionHasErrors('email');

    $this->assertGuest();
});

it('logs out an authenticated user', function (): void {
    $user = User::factory()->create();

    $this->actingAs($user)->post('/logout')->assertRedirect('/');

    $this->assertGuest();
    $this->get('/dashboard')->assertRedirect('/login');
});

it('registers a new user', function (): void {
    $this->post('/register', [
        'name' => 'Cliente Teste',
        'email' => 'novo@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertRedirect('/dashboard');

    $this->assertAuthenticated();
    $this->assertDatabaseHas('users', [
        'name' => 'Cliente Teste',
        'email' => 'novo@example.com',
    ]);

    $user = User::where('email', 'novo@example.com')->sole();

    expect($user->password)->not->toBe('password')
        ->and(Hash::check('password', $user->password))->toBeTrue();
});

it('blocks guests from the dashboard', function (): void {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('blocks guests from media routes', function (): void {
    $this->post('/media')->assertRedirect('/login');
});
