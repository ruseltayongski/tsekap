<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTuberculosis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tuberculosis', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('tb_diagnosed',10)->nullable();
            $table->string('tb_diagnosed_yes',100)->nullable();
            $table->integer('tb_cat1')->nullable();
            $table->integer('tb_cat2')->nullable();
            $table->integer('tb_cat3')->nullable();
            $table->integer('tb_cat4')->nullable();
            $table->integer('tb_status')->nullable();
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
        Schema::drop("tuberculosis");
    }
}
