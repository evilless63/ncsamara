<?php

use Illuminate\Database\Seeder;

class RateSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rates')->insert([
            'name' => 'Стандарт',
            'description' => 'Стандарт',
            'image' => '',
            'cost' => '100',
        ]);

        DB::table('rates')->insert([
            'name' => 'Премиум',
            'description' => 'Премиум',
            'image' => '',
            'cost' => '200',
        ]);

        DB::table('rates')->insert([
            'name' => 'VIP',
            'description' => 'VIP',
            'image' => '',
            'cost' => '300',
        ]);

    }
}
