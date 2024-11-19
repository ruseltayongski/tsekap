<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnToResuPatientProfileInjuryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resu_patient_profile_injury', function (Blueprint $table) {
            //
            $table->string('typeofpatient')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resu_patient_profile_injury', function (Blueprint $table) {
            //
            $table->string('typeofpatient')->nullable();
        });
    }
}
