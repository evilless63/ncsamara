<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Hair;

class HairSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Hair::truncate();
        DB::table('hairs')->insert([
            'name' => 'Брюнетки'
        ]);

        DB::table('hairs')->insert([
            'name' => 'Блондинки'
        ]);

        DB::table('hairs')->insert([
            'name' => 'Рыжие'
        ]);

        DB::table('hairs')->insert([
            'name' => 'Шатенки'
        ]);

        DB::table('hairs')->insert([
            'name' => 'Русые'
        ]);
    }
}
