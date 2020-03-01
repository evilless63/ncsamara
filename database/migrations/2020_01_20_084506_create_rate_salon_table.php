<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRateSalonTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salonrate_salon', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('salonrate_id');
            $table->unsignedBigInteger('salon_id');

            $table->unique(['salonrate_id','salon_id']);

            $table->foreign('salonrate_id')->references('id')->on('salonrates')->onDelete('cascade');
            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salonrate_salon');
    }
}
