<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Appearance;

class AppearanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Appearance::truncate();
        DB::table('appearances')->insert([
            'name' => 'Славянская'
        ]);

        DB::table('appearances')->insert([
            'name' => 'Азиатская'
        ]);

        DB::table('appearances')->insert([
            'name' => 'Африканская'
        ]);

        DB::table('appearances')->insert([
            'name' => 'Кавказская'
        ]);

    }
}
