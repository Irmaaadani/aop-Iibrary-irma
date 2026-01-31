<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'role' => 'admin',
                'name' => 'Dani',
                'email' => 'dani@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0821145678888',
                'address' => 'jl. Tipar Cakung',
                'created_at' => now(),
            ],
            [
                'role' => 'librarian',
                'name' => 'novry',
                'email' => 'novry@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0821145678888',
                'address' => 'Jl. dimana hatiku senang',
                'created_at' => now(),
            ],
            [
                'role' => 'member',
                'name' => 'irma',
                'email' => 'irma@gmail.com',
                'password' => Hash::make('123456'),
                'phone' => '0821145670000',
                'address' => 'Jl. S. Bengawan solo',
                'created_at' => now(),
            ],
        ]);
    }
}
