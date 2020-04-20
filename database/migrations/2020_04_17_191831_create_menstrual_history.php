<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMenstrualHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menstrual_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('menst_age')->nullable();
            $table->date('menst_date_period')->nullable();
            $table->integer('menst_duration_days')->nullable();
            $table->integer('menst_interval_days')->nullable();
            $table->integer('menst_pads')->nullable();
            $table->integer('menst_status')->nullable();
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
        Schema::drop("menstrual_history");
    }
}
