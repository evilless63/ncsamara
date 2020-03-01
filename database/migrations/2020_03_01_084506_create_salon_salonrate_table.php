<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalonSalonrateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salon_salonrate', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();

            $table->unsignedBigInteger('salon_id');
            $table->unsignedBigInteger('salonrate_id'); 

            $table->unique(['salon_id','salonrate_id']);

            $table->foreign('salon_id')->references('id')->on('salons')->onDelete('cascade');
            $table->foreign('salonrate_id')->references('id')->on('salonrates')->onDelete('cascade');         
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
