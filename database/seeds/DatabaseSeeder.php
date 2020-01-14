<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(HairSeeder::class);
        $this->call(AppearanceSeeder::class);
        $this->call(ServiceSeeder::class);
        $this->call(RateSeeder::class);
        $this->call(BonusSeeder::class);
    }
}
