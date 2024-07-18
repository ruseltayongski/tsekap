<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResutransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('Resutransport', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Pre_admission_id')->nullable();
            $table->integer('transport_id')->nullable();
            $table->integer('external_prea_id')->nullable();
            $table->string('PatientVehicle')->nullble();
            $table->string('PvOther_detail', 200)->nullable();
            $table->string('positionPatient')->nullable();
            $table->string('ppother_detail', 200)->nullable();
            $table->string('pofOccurence')->nullable();
            $table->string('workplace_specify', 200)->nullable();
            $table->string('pofOccure_others', 200)->nullable();
            $table->string('activity_patient')->nullable();
            $table->string('AP_others')->nullable();
            $table->string('risk_factors')->nullable();
            $table->string('rf_others', 200)->nullable();
            $table->string('safety')->nullable();
            $table->string('safety_others', 200)->nullable();
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
        Schema::drop("Resutransport");
    }
}
