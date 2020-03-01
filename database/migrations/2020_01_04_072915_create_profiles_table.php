<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('phone');
            $table->text('about');
            $table->text('address')->nullable();
            $table->string('address_x')->nullable();
            $table->string('address_y')->nullable();
            $table->integer('working_hours_from')->nullable();
            $table->integer('working_hours_to')->nullable();
            $table->boolean('working_24_hours')->nullable();
            $table->string('verificate_image')->nullable();
            $table->string('main_image')->nullable();

            $table->integer('boobs');
            $table->integer('age');
            $table->integer('weight');
            $table->integer('height');

            $table->integer('one_hour');
            $table->integer('two_hour');
            $table->integer('euro_hour')->nullable();
            $table->integer('all_night');

            $table->boolean('apartments')->default(false);
            $table->boolean('check_out')->default(false);
            $table->boolean('check_out_rooms')->default(false);
            $table->boolean('check_out_hotels')->default(false);
            $table->boolean('check_out_saunas')->default(false);
            $table->boolean('check_out_offices')->default(false);
            $table->boolean('verified')->default(false);

            $table->boolean('is_published')->default(false);
            $table->boolean('was_published')->default(false);
            // $table->boolean('on_moderate')->default(true);
            $table->boolean('allowed')->default(false);
            
            $table->unsignedInteger('profile_balance')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profiles');
    }
}
