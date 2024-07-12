<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuxternalInjuryPreAdmissionTableJunction extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('resuxternal_injury_preAdmission', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Pre_admission_id')->nullable();
            $table->integer('externalinjury_id')->nullable();
            $table->string('subtype', 20)->nullable();
            $table->string('details',255)->nullable();
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
        Schema::drop("resuxternal_injury_preAdmission");
    }
}
