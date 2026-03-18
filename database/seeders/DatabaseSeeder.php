<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory(20)->create();

        // User::factory()->create([
        //     'name' => 'admin',
        //     'email' => 'admin@email.com',
        //     'role' => 'admin',
        //     'password' => bcrypt('password'),
        //     'email_verified_at' => now(),
        //     'remember_token' => Str::random(10),
        // ]);
    }
}
