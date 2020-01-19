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
        $services = App\Service::where('is_category','0')->get();
        $rates = App\Rate::all();
        $hairs = App\Hair::all();
        $appearances = App\Appearance::all();
        $districts = App\District::all();

        factory(App\User::class,5)->create()->each(function ($user){

            factory(App\Profile::class, 20)->create([
                'user_id' => $user->id,
            ]);

        });

        App\Profile::all()->each(function ($profile) use ($rates, $districts, $hairs, $appearances, $services) {
            $profile->rates()->attach(
                $rates->random(rand(1, 3))->first()
            );

            $profile->hairs()->attach(
                $hairs->random(rand(1, 5))->first()
            );

            $profile->appearances()->attach(
                $appearances->random(rand(1, 4))->first()
            );

            $profile->districts()->attach(
                $districts->random(rand(1,8))->first()
            );

            $profile->services()->attach(
                $services->random(5)->pluck('id')->toArray()
            );
        });

    }
}
