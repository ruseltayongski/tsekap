<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateChestAndLungs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chest_and_lungs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('chest_no_findings')->nullable();
            $table->integer('chest_retractions')->nullable();
            $table->integer('chest_crackles')->nullable();
            $table->integer('chest_wheezes')->nullable();
            $table->integer('chest_breast')->nullable();
            $table->integer('chest_others')->nullable();
            $table->string('chest_others_specify',100)->nullable();
            $table->integer('chest_status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop("chest_and_lungs");
    }
}
