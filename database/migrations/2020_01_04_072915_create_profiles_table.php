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
            $table->string('working_hours');

            $table->integer('boobs');
            $table->integer('age');
            $table->integer('weight');
            $table->integer('height');

            $table->integer('one_hour');
            $table->integer('two_hour');
            $table->integer('all_night');

            $table->boolean('is_published')->default(false);
            $table->boolean('apartments')->default(false);
            $table->boolean('check_out')->default(false);
            $table->boolean('verified')->default(false);
            $table->date('last_payment')->nullable();
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
