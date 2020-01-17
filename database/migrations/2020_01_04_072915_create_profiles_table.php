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
            $table->text('address');
            $table->integer('address_x');
            $table->integer('address_y');
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

            $table->boolean('is_published')->default(false);
            $table->boolean('apartments')->default(false);
            $table->boolean('check_out')->default(false);
            $table->boolean('verified')->default(false);
            $table->dateTime('last_payment')->nullable();
            $table->dateTime('next_payment')->nullable();
            $table->integer('minutes_to_archive')->nullable();
            $table->boolean('is_archived')->default(true);
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
