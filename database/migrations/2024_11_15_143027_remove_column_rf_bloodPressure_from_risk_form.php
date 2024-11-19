<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RemoveColumnRfBloodPressureFromRiskForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('risk_form', function (Blueprint $table) {
            $table->dropColumn('rf_bloodPressure');
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
        Schema::table('risk_form', function (Blueprint $table) {
            $table->dropColumn('rf_bloodPressure');
        });
    }
}
