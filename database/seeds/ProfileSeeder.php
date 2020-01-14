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

        factory(App\User::class,5)->create()->each(function ($user){

            factory(App\Profile::class, 20)->create([
                'user_id' => $user->id,
            ]);

        });

    }
}
