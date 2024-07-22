<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuErOpdBhsRhuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resuErOpdBhsRhu', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospitalfacility_id')->nullable();
            $table->integer('profile_id')->nullable();
            $table->boolean('transferred_facility')->nullable();
            $table->boolean('referred_facility')->nullable();
            $table->string('originating_hospital',255)->nullable();
            $table->string('status_facility', 20)->nullable();
            $table->string('mode_transport_facility')->nullable();
            $table->string('other_details', 255)->nullable();
            $table->string('initial_impression', 255)->nullable();
            $table->string('icd10Code_nature', 255)->nullable();
            $table->string('icd10Code_external', 255)->nullable();
            $table->string('disposition')->nullable();
            $table->string('details', 200)->nullable();
            $table->string('outcome')->nullable();
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
        Schema::drop("resuErOpdBhsRhu");
    }
}
