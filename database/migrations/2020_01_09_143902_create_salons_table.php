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
            $table->text("address");
            $table->text("image");
            $table->string("phone");
            $table->boolean("is_approved")->default(false);
            $table->boolean("is_published")->default(false);
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
