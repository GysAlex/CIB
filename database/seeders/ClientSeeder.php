<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clientRole = Role::where('name', 'client')->first();

        if (!$clientRole) {
            $this->command->error("Le rôle 'employee' n'existe pas. Lancez d'abord RoleSeeder !");
            return;
        }


        User::factory(20)->create()->each(fn ($user) => 
            $user->roles()->attach($clientRole)
        );

        $testClient = User::factory()->create([
            'name' => 'Jean Client',
            'email' => 'client@email.com',
            'password' => bcrypt('password'),
        ]);

        $testClient->roles()->attach($clientRole);

        $this->command->info('21 clients créer !');


    }
}
