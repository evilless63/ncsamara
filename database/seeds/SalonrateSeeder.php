<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SalonrateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('salonrates')->insert([
            'name' => 'Стандарт',
            'description' => 'Стандарт',
            'cost' => '100',
        ]);

        DB::table('salonrates')->insert([
            'name' => 'Премиум',
            'description' => 'Премиум',
            'cost' => '200',
        ]);

    }
}
