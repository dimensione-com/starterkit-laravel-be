<?php

namespace Database\Seeders;

use App\Domain\User\Enum\UserStatus;
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
            'status' => UserStatus::Active->value,
            'password' => Hash::make('string'),
        ]);
    }
}
