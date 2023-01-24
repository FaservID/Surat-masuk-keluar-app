<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CreateUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@faserv.com',
                'type' => 1,
                'profile_picture' => 'avatar.png',
                'phone_number' => '6282178527777',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'kabid',
                'email' => 'kabid@faserv.com',
                'type' => 2,
                'profile_picture' => 'avatar.png',
                'phone_number' => '6282178527777',
                'password' => bcrypt('123456'),
            ],
            [
                'name' => 'staff',
                'email' => 'staff@faserv.com',
                'type' => 0,
                'profile_picture' => 'avatar.png',
                'phone_number' => '6282178527777',
                'password' => bcrypt('123456'),
            ],
        ];

        foreach ($users as $key => $user) {
            User::create($user);
        }
    }
}
