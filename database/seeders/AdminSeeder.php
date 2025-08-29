<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name'       => 'Souta Izumi',
                'phone'      => '6289656698186',
                'role'       => 'admin',
                'password'   => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name'       => 'Mikazuki Arion',
                'phone'      => '6283179277828',
                'role'       => 'admin',
                'password'   => Hash::make('123456'),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
