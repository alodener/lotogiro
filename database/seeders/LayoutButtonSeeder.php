<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class LayoutButtonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {   
        DB::table('layout_button')->insert([
            'first_text'  => 'first_text',
            'second_text' => '💥',
            'link'        => '#ff0000',
            'cor'         => '1',
            'visivel'     => '1',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);


        DB::table('layout_button')->insert([
            'first_text'  => 'first_text',
            'second_text' => '💥',
            'link'        => '#ff0000',
            'cor'         => '1',
            'visivel'     => '1',
            'created_at'  => now(),
            'updated_at'  => now(),
        ]);
     
    }
}
