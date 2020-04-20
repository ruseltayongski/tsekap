<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHeart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('heart', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('heart_no_findings')->nullable();
            $table->integer('heart_pulse')->nullable();
            $table->integer('heart_cyanosis')->nullable();
            $table->integer('heart_murmur')->nullable();
            $table->string('heart_murmur_specify',100)->nullable();
            $table->integer('heart_others')->nullable();
            $table->string('heart_others_specify',100)->nullable();
            $table->integer('heart_status')->nullable();
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
        Schema::drop("heart");
    }
}
