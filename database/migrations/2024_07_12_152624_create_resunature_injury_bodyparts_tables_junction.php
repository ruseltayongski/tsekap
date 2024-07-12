<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResunatureInjuryBodypartsTablesJunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('resunature_injury_bodyparts', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('preadmission_id')->nullable();
            $table->integer('nature_injury_id')->nullable();
            $table->integer('bodyparts_id')->nullable();
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
        //
        Schema::drop("resunature_injury_bodyparts");
    }
}
