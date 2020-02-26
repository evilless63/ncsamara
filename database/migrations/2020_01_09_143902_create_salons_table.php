<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSalonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('salons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->timestamps();
            $table->text("user_id");
            $table->text("name");
            $table->text("image");
            $table->text("image_prem")->nullable();
            $table->integer('min_price')->nullable();
            $table->string('phone')->nullable();
            $table->boolean("is_approved")->default(false);
            $table->boolean("is_published")->default(false);
            $table->boolean("allowed")->default(false);
            $table->boolean('is_archived')->default(true);
            $table->boolean('on_moderate')->default(false);
            $table->dateTime('last_payment')->nullable();
            $table->dateTime('next_payment')->nullable();
            $table->integer('minutes_to_archive')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('salons');
    }
}
