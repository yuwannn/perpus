<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'username'=>'yuwan',
            'password'=>Hash::make('123'),
            'email'=>'yuwan@contoh.com',
            'namalengkap'=>'Yuwandri Alfarizi',
            'alamat'=>'Kp. Cikeas Udik'
        ]);
    }
}
