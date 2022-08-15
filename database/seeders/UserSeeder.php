<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Rahul',
            'email' => 'rahullodhi3636@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 0,
        ]);

        User::create([
            'name' => 'aspire',
            'email' => 'aspire@gmail.com',
            'password' => bcrypt('12345678'),
            'role' => 1
        ]);
    }
}
