<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ParentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('parents')->insert([
            [
                'id_user' => 8, // Myra Desianti
                'alamat' => 'Dusun Kaum Kaler 03/01',   
            ]
        ]);
    }
}
