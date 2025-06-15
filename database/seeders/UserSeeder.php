<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User; // Import Model User
use App\Enums\UserRoleEnum; // Import UserRoleEnum

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat beberapa user pasien dummy
        User::factory()->count(10)->create([
            'role' => UserRoleEnum::Pasien, // Pastikan role-nya pasien
        ]);
    }
}