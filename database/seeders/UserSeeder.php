<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        User::create([
            'name'=> 'Admin',
            'email'=> 'admin@gmail.com',
            'password'=> Hash::make('123456'),
            'role'=> 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'=> 'Client Test',
            'email'=> 'client@gmail.com',
            'password'=> Hash::make('12345'),
            'role'=> 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'=> 'Hoàn Vũ Lê',
            'email'=> 'hoanvule73@gmail.com',
            'password'=> Hash::make('123456'), // Bạn có thể đổi sau
            'role'=> 'admin',
            'email_verified_at' => now(),
        ]);
    }
}
