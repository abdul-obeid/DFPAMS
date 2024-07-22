<?php

namespace Database\Seeders;

use App\Models\Coordinator;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class CoordinatorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $coordinator = Coordinator::create();
        $password = 'Admin';

        $user = $coordinator->user()->create([
            'name' => 'Admin',
            'user_type' => 'coordinator',
            'email' => 'admin@mmu.edu.my',
            'password' => Hash::make($password), // Set a default password
            'is_active' => true,
        ]);

        Log::info('Coordinator created', ['email' => $user->email, 'password' => $password]);
    }
}
