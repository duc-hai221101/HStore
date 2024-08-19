<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('roles')->insert([
            ['name'=>'admin','display_name'=>'Admin he thong'],
            ['name'=>'guest','display_name'=>'Khach hang'],
            ['name'=>'dev','display_name'=>'dev he thong'],
            ['name'=>'content','display_name'=>'Quan ly content'],

        ]);
    }
}
