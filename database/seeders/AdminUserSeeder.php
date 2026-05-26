<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'Administateur',
            'email' => 'leseulguide@cib-constuction.com',
            'password' => bcrypt('cib-manager')
        ]);

        $role = Role::where('name', 'admin')->get();

        $adminUser->roles()->attach($role);
    }
}
