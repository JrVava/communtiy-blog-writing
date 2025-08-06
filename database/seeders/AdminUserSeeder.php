<?php

namespace Database\Seeders;

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
        User::create([
            'full_name' => 'admin',
            'email' => 'admin@gmail.com',
            'phone' => '123456',
            'dob' => '23-11-1993',
            'password' => bcrypt('123456'),
            'is_admin' => true,
            'is_approve' => true
        ]);
    }
}
