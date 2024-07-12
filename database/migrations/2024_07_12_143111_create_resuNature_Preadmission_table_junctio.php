<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuNaturePreadmissionTableJunctio extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('resuNature_injury_Preadmission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Pre_admission_id')->nullable();
            $table->integer('natureInjury_id')->nullable();
            $table->string('subtype', 20)->nullable();
            $table->string('details',255)->nullable();
            $table->string('side', 20)->nullable();
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
        Schema::drop("resuNature_injury_Preadmission");
    }
}
