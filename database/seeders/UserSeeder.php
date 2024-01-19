<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => fake()->firstName(),
            'email' => fake()->unique()->safeEmail(),
            'role' => fake()->numberBetween(0, 2),
            'password' => Hash::make(123456789),
            'created_at' => fake()->dateTimeBetween('-2 week', 'now'),
            'updated_at' => fake()->dateTimeBetween('-2 week', 'now'),
            'is_active' => 1,
        ]);
    }
}
