<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnNameFromTableName extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resu_patient_profile_injury', function (Blueprint $table) {
            $table->dropColumn('typeofpatient');
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
            $table->dropColumn('typeofpatient');
        });
    }
}
