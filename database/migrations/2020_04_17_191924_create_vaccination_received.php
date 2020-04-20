<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVaccinationReceived extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vaccination_received', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('vacc_rec_mr')->nullable();
            $table->integer('vacc_rec_diphtheria')->nullable();
            $table->integer('vacc_rec_mmr')->nullable();
            $table->integer('vacc_rec_hpv')->nullable();
            $table->integer('vacc_rec_tetanus')->nullable();
            $table->integer('vacc_rec_doses')->nullable();
            $table->integer('vacc_rec_status')->nullable();
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
        Schema::drop("vaccination_received");
    }
}
