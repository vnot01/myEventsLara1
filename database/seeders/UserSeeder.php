<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        DB::table('users')->insert([
            [
                'name'=>'Administrator',
                'email'=>'admin@gmail.com',
                'password'=>Hash::make('f3rifeb'),
            ],
            [
                'name'=>'Sponsor',
                'email'=>'sponsor@gmail.com',
                'password'=>Hash::make('f3rifeb')
            ],
            [
                'name'=>'User',
                'email'=>'user@gmail.com',
                'password'=>Hash::make('f3rifeb')
            ]
        ]);
    }
}
