<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //スタッフ認証仮データ
        DB::table('staffs')->insert([
            [
                'email' => 'staff1@gmail.com',
                'password' => Hash::make('123456'),
            ],
            [
                'email'=> 'staff2@gmail.com',
                'password' => Hash::make('123456'),
            ],
        ]);

    }
}
