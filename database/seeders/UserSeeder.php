<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{

    public function run() : void {
        User::create([
            'name' => 'user',
            'surname' => 'User',
            'email' => 'user@example.com',
            'username' => 'user',
            'password' => Hash::make('string'),
        ]);
    }
}
