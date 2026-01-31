<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->insert([
            [
                'name' => 'Science Fiction',
                'created_at' => now(),
            ],
            [
                'name' => 'Romance',
                'created_at' => now(),
            ],
            [
                'name' => 'Mystery',
                'created_at' => now(),
            ],
            [
                'name' => 'Fantasy',
                'created_at' => now(),
            ],
            [
                'name' => 'Non-Fiction',
                'created_at' => now(),
            ],
        ]);
    }
}
