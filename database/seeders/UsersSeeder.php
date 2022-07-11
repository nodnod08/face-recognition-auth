<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use App\Models\User;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $now = date('Y-m-d H:i:s');
        $password = Hash::make('password');

        User::insert([
            [
                'role_id' => 2,
                'first_name' => 'Dondomie',
                'last_name' => 'Dungca',
                'username' => 'dondon',
                'email' => 'dondomiedungca14@gmail.com',
                'email_verified_at' => $now,
                'password' => $password,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ],
            [
                'role_id' => 1,
                'first_name' => 'Admin',
                'last_name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@gmail.com',
                'email_verified_at' => $now,
                'password' => $password,
                'remember_token' => Str::random(10),
                'created_at' => $now,
                'updated_at' => $now
            ]
        ]);

        User::factory(10)->create();
    }
}
