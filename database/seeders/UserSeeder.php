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
            'password'=> Hash::make('123456'), 
            'role'=> 'admin',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'=> 'Đức Anh Nguyễn',
            'email'=> 'anp93005@gmail.com',
            'password'=> Hash::make('123456'),
            'role'=> 'user',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'=> 'Phan Đức Tú',
            'email'=> 'tubun2@gmail.com',
            'password'=> Hash::make('123456'),
            'role'=> 'staff',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'=> 'Lê Văn Hùng',
            'email'=> 'hung.bodybuilding@extrafit.vn',
            'password'=> Hash::make('123456'),
            'role'=> 'trainer',
            'email_verified_at' => now(),
        ]);

        User::create([
            'name'=> 'Phạm Thu Hà',
            'email'=> 'ha.yoga@extrafit.vn',
            'password'=> Hash::make('123456'),
            'role'=> 'trainer',
            'email_verified_at' => now(),
        ]);
    }
}
