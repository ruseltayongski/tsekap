<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBronchialAsthma extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bronchial_asthma', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('bro_consultation',50)->nullable();
            $table->integer('bro_no_attack_week')->nullable();
            $table->string('bro_medication',10)->nullable();
            $table->string('bro_medication_yes',255)->nullable();
            $table->integer('bro_status')->nullable();
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
        Schema::drop("bronchial_asthma");
    }
}
