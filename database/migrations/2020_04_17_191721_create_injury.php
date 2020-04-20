<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInjury extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('injury', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('inj_vehicular')->nullable();
            $table->integer('inj_burns')->nullable();
            $table->integer('inj_drowning')->nullable();
            $table->integer('inj_fall')->nullable();
            $table->string('inj_medications',255)->nullable();
            $table->integer('inj_status')->nullable();
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
        Schema::drop("injury");
    }
}
