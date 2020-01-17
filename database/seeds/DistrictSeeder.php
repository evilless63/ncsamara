<?php

use Illuminate\Database\Seeder;

class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('districts')->insert([
           'name' => 'Куйбышевский'
        ]);

        DB::table('districts')->insert([
            'name' => 'Самарский'
        ]);

        DB::table('districts')->insert([
            'name' => 'Ленинский'
        ]);

        DB::table('districts')->insert([
            'name' => 'Железнодорожный'
        ]);

        DB::table('districts')->insert([
            'name' => 'Октябрьский'
        ]);

        DB::table('districts')->insert([
            'name' => 'Промышленный'
        ]);

        DB::table('districts')->insert([
            'name' => 'Кировский'
        ]);

        DB::table('districts')->insert([
            'name' => 'Красноглинский'
        ]);
    }
}
