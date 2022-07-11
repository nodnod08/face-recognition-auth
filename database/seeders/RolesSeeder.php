<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\Role;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    
        $now = date('Y-m-d H:i:s');

        Role::insert(
            [
                [
                    'name' => 'Administrator',
                    'created_at' => $now,
                    'updated_at' => $now
                ],
                [
                    'name' => 'Simple User',
                    'created_at' => $now,
                    'updated_at' => $now
                ]
            ]
        );
    }
}
