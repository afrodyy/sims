<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'name' => 'Herdian Afrody',
                'email' => 'herdianafrody@gmail.com',
                'password' => bcrypt('123456'),
                'avatar' => 'assets/assets/img/avatar_user.png'
            ],
        ]);
    }
}
