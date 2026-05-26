<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminUser = User::create([
            'name' => 'Administateur',
            'email' => 'leseulguide@cib-construction.com',
            'password' => Hash::make('password-cib')
        ]);

        $role = Role::where('name', 'admin')->get();

        $adminUser->roles()->attach($role);
    }
}
