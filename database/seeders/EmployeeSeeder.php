<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $employeeRole = Role::where('name', 'employee')->first();

        if (!$employeeRole) {
            $this->command->error("Le rôle 'employee' n'existe pas. Lancez d'abord RoleSeeder !");
            return;
        }


        User::factory(20)->create()->each(fn ($user) => 
            $user->roles()->attach($employeeRole)
        );

        $testEmployee = User::factory()->create([
            'name' => 'Jean Employé',
            'email' => 'test@email.com',
            'password' => bcrypt('password'),
        ]);
        
        $testEmployee->roles()->attach($employeeRole);

        $this->command->info('21 employés créer !');
    }
}
