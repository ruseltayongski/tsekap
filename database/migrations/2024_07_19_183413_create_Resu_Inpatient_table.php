<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuInpatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // resuInpatient
        Schema::create('resuInpatient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('hospitalfacility_id')->nullable();
            $table->integer('profile_id')->nullable();
            $table->string('complete_Diagnose')->nullable();
            $table->string('Disposition')->nullable();
            $table->string('Outcome')->nullable();
            $table->string('icd10Code_nature')->nullable();
            $table->string('icd10Code_external')->nullable();
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
        Schema::drop("resuInpatient");
    }
}
