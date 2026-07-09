<?php

use App\Models\User;

it('blocks guests from profile routes', function (): void {
    $this->get('/profile')->assertRedirect('/login');
    $this->patch('/profile', ['name' => 'Visitante'])->assertRedirect('/login');
});

it('shows the profile page to authenticated users', function (): void {
    $this->withoutVite();

    $user = User::factory()->create([
        'name' => 'Cliente Perfil',
        'email' => 'perfil@example.com',
    ]);

    $this->actingAs($user)->get('/profile')->assertOk();
});

it('updates the authenticated user profile', function (): void {
    $user = User::factory()->create([
        'name' => 'Nome Antigo',
        'email' => 'antigo@example.com',
    ]);

    $this->actingAs($user)->patch('/profile', [
        'name' => 'Nome Atualizado',
    ])->assertRedirect('/profile')->assertSessionHas('success');

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Nome Atualizado',
        'email' => 'antigo@example.com',
    ]);
});

it('validates profile data before updating', function (): void {
    $user = User::factory()->create([
        'name' => 'Cliente Valido',
        'email' => 'valido@example.com',
    ]);

    $this->actingAs($user)->from('/profile')->patch('/profile', [
        'name' => '',
    ])->assertRedirect('/profile')->assertSessionHasErrors(['name']);

    $this->assertDatabaseHas('users', [
        'id' => $user->id,
        'name' => 'Cliente Valido',
        'email' => 'valido@example.com',
    ]);
});
