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
            
            $table->integer('min_price')->nullable();
            $table->string('phone')->nullable();

            $table->boolean("is_published")->default(false);
            $table->boolean("was_published")->default(false);
            $table->boolean("allowed")->default(false);
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
