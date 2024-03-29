<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHairProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hair_profile', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('hair_id');
            $table->unsignedBigInteger('profile_id');
            $table->timestamps();

            $table->unique(['hair_id','profile_id']);


            $table->foreign('hair_id')->references('id')->on('hairs')->onDelete('cascade');
            $table->foreign('profile_id')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('hair_profile');
    }
}
