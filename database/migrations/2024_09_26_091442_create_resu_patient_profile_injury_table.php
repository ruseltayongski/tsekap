<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuPatientProfileInjuryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resu_patient_profile_injury', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id',255)->nullable();
            $table->string('phicID',100)->nullable();
            $table->string('fname',255)->nullable();
            $table->string('mname',255)->nullable();
            $table->string('lname',255)->nullable();
            $table->string('suffix',255)->nullable();
            $table->date('dob')->nullable();
            $table->string('sex',255)->nullable();
            $table->integer('barangay_id')->nullable();
            $table->integer('muncity_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('report_facilityId')->nullable();
            $table->string('Hospital_caseNo')->nullable();
            $table->string('type_of_patient')->nullable();
            $table->string('name_of_encoder')->nullable();
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
        Schema::drop('resu_patient_profile_injury');
    }
}
