<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
// DB、Hushファセットを使うため追加
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;


class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('admins')->insert([
            [
            'email' => 'admin@gmail.com',
            'password' => Hash::make('123456'),
            ],
        ]);
    }
}
