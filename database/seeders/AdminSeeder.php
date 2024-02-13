<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            "admin_name" => "Burak Tiryaki",
            "admin_email" => "burak@burak.com",
            "admin_password" => bcrypt('123456'),
        ];
        Admin::create($data);
    }
}
