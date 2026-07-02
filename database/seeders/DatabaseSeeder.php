<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        if (app()->isLocal()) {
            User::factory()->create(['name' => 'Rock Code', 'email' => 'dev@rockcode.com.br']);
        }
    }
}
