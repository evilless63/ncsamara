<?php

use Illuminate\Database\Seeder;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $services = App\Service::where('is_category','0');
        $rates = App\Rate::all();

        factory(App\User::class,5)->create()->each(function ($user) use ($rates){

            factory(App\Profile::class, 20)->create([
                'user_id' => $user->id,
            ])->each(function ($profile) use ($rates){
                $profile->rates()->attach(
                    $rates->random(rand(1, 3))->pluck('id')->toArray()
                ); 
            });

        });

    }
}
