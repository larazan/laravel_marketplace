<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'first_name' => 'ratri',
            'last_name' => 'wiranti',
            'email' => 'ratri@mail.com',
            'password' => Hash::make('password'),
            'phone' => '08888888888888',
            'address1' => 'Wisma Tengger Kandangan Benowo Surabaya Barat',
            'isAdmin' => 1 // 1 => admin, 0 => user
        ]);
    }
}
