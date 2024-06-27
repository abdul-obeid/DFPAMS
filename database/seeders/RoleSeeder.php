<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Define the roles to be added
        $roles = [
            ['role_name' => 'Admin', 'role_enabled' => true],
            ['role_name' => 'Coordinator', 'role_enabled' => true],
            ['role_name' => 'Student', 'role_enabled' => true],
            ['role_name' => 'Supervisor', 'role_enabled' => true],
        ];

        // Insert the roles into the database
        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}
