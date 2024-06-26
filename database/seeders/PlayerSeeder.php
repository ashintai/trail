<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class PlayerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('players') ->insert([
            [
                'name' => '山田太郎',
                'email' => 'taro@gmail.com',
                'password' => Hash::make('123456'),
                'category_id' => 1,
                'zekken' => '123',
                'park_id' => 1,
                'bus' => null,
            ],
            [
                'name' => '鈴木次郎',
                'email' => 'jiro@gmail.com',
                'password' => Hash::make('123456'),
                'category_id' => 2,
                'zekken' => '234',
                'park_id' => null,
                'bus' => 1,
            ],
            [
                'name' => '佐藤三郎',
                'email' => 'subro@gmail.com',
                'password' => Hash::make('123456'),
                'category_id' => 3,
                'zekken' => '345',
                'park_id' => 2,
                'bus' => null,
            ],
            [
                'name' => '佐藤四郎',
                'email' => 'subro@gmail.com',
                'password' => Hash::make('123456'),
                'category_id' => 4,
                'zekken' => '456',
                'park_id' => null,
                'bus' => 1,
            ],
        ]);
    }
}
