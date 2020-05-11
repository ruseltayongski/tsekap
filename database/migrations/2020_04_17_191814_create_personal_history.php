<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonalHistory extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personal_history', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('per_smoking',50)->nullable();
            $table->integer('per_age_started')->nullable();
            $table->integer('per_age_quit')->nullable();
            $table->integer('per_stick_day')->nullable();
            $table->integer('per_pack_years')->nullable();
            $table->string('per_high_fat',10)->nullable();
            $table->string('per_fiber_vegetable',10)->nullable();
            $table->string('per_fiber_fruits',10)->nullable();
            $table->string('per_physical_activity',10)->nullable();
            $table->string('per_alcohol',10)->nullable();
            $table->string('per_drugs',10)->nullable();
            $table->string('per_drugs_yes',200)->nullable();
            $table->integer('per_status')->nullable();
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
        Schema::drop("personal_history");
    }
}
