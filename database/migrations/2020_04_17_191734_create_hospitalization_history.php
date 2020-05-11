<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHospitalizationHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('hospitalization_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('hos_reason',255)->nullable();
            $table->date('hos_date')->nullable();
            $table->string('hos_place',200)->nullable();
            $table->string('hos_phic',10)->nullable();
            $table->string('hos_cost',100)->nullable();
            $table->integer('hos_status')->nullable();
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
        Schema::drop("hospitalization_history");
    }
}
