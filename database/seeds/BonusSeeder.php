<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BonusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bonuses')->insert([
            'min_sum' => '300',
            'max_sum' => '1500',
            'koef' => '5',
        ]);

        DB::table('bonuses')->insert([
            'min_sum' => '1501',
            'max_sum' => '3000',
            'koef' => '7',
        ]);

        DB::table('bonuses')->insert([
            'min_sum' => '3001',
            'max_sum' => '9999999',
            'koef' => '10',
        ]);
    }
}
