<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                "user_name" => "Burak Tiryaki",
                "user_email" => "burak@burak.com",
                "user_password" => bcrypt('123456'),
                "user_status" => 1
            ],
            [
                "user_name" => "Max Verstappen",
                "user_email" => "max@burak.com",
                "user_password" => bcrypt('123456'),
                "user_status" => 1
            ],
            [
                "user_name" => "Sebastian Vettel",
                "user_email" => "vettel@burak.com",
                "user_password" => bcrypt('123456'),
                "user_status" => 0
            ]
        ];
        foreach($users as $user)
            User::create($user);

        $user1 = User::where('user_id',1)->first();
        $user1->syncRoles('Admin','Editor');

        $user2 = User::where('user_id',2)->first();
        $user2->syncRoles('Editor');
        
        $user3 = User::where('user_id',3)->first();
        $user3->syncRoles('User');
    }
}
