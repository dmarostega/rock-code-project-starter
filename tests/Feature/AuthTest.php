<?php

use App\Http\Middleware\HandleInertiaRequests;
use App\Models\User;
use Illuminate\Http\Request;
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
    ])->assertRedirect('/login')->assertSessionHasErrors([
        'email' => 'As credenciais informadas não conferem.',
    ]);

    $this->assertGuest();
});

it('creates a persistent cookie when remember me is selected', function (): void {
    $user = User::factory()->create([
        'email' => 'cliente@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'cliente@example.com',
        'password' => 'password',
        'remember' => true,
    ]);

    $response->assertRedirect('/dashboard')
        ->assertCookie($this->app['auth']->guard()->getRecallerName());

    $this->assertAuthenticatedAs($user);
});

it('does not create a persistent cookie when remember me is not selected', function (): void {
    User::factory()->create([
        'email' => 'cliente@example.com',
        'password' => Hash::make('password'),
    ]);

    $response = $this->post('/login', [
        'email' => 'cliente@example.com',
        'password' => 'password',
        'remember' => false,
    ]);

    $response->assertRedirect('/dashboard')
        ->assertCookieMissing($this->app['auth']->guard()->getRecallerName());
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

it('blocks registration when public registration is disabled', function (): void {
    config()->set('app_settings.flags.public_registration', false);

    $this->get('/register')->assertNotFound();

    $this->post('/register', [
        'name' => 'Cliente Bloqueado',
        'email' => 'bloqueado@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ])->assertNotFound();

    $this->assertDatabaseMissing('users', ['email' => 'bloqueado@example.com']);
});

it('blocks guests from the dashboard', function (): void {
    $this->get('/dashboard')->assertRedirect('/login');
});

it('blocks guests from the admin dashboard', function (): void {
    $this->get('/admin')->assertRedirect('/login');
});

it('blocks authenticated non-admin users from the admin dashboard', function (): void {
    config()->set('admin.emails', ['admin@example.com']);

    $user = User::factory()->create(['email' => 'member@example.com']);

    $this->actingAs($user)->get('/admin')->assertForbidden();
});

it('allows configured administrators to access the admin dashboard', function (): void {
    config()->set('admin.emails', ['admin@example.com']);

    $user = User::factory()->create(['email' => 'admin@example.com']);

    $this->actingAs($user)->get('/admin')->assertOk();

    $this->assertDatabaseHas('audit_logs', [
        'actor_id' => $user->id,
        'action' => 'admin.accessed',
    ]);
});

it('blocks guests from media routes', function (): void {
    $this->post('/media')->assertRedirect('/login');
});

it('shares an explicit auth user payload with inertia', function (): void {
    $user = User::factory()->create([
        'name' => 'Cliente Seguro',
        'email' => 'seguro@example.com',
        'email_verified_at' => now(),
        'password' => Hash::make('password'),
        'remember_token' => 'sensitive-token',
    ]);

    $request = Request::create('/dashboard');
    $request->setUserResolver(fn (): User => $user);
    $request->setLaravelSession(app('session')->driver());

    $shared = (new HandleInertiaRequests)->share($request);

    expect($shared['auth']['user'])->toBe([
        'id' => $user->id,
        'name' => 'Cliente Seguro',
        'email' => 'seguro@example.com',
    ]);
});
