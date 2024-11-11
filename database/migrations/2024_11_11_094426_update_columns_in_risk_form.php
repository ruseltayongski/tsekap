<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UpdateColumnsInRiskForm extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            $table->string('rf_tobbacoUse', 50)->nullable()->change();
            $table->string('rf_bloodPressure', 10)->nullable()->change();
            $table->string('mngm_med_hypertension', 10)->nullable()->change();
            $table->string('mngm_med_diabetes', 10)->nullable()->change();
            $table->string('mngm_med_diabetes_options', 20)->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            $table->string('rf_tobbacoUse')->change();
            $table->string('rf_bloodPressure')->change();
            $table->string('mngm_med_hypertension')->change();
            $table->string('mngm_med_diabetes')->change();
            $table->string('mngm_med_diabetes_options')->change();
        });
    }
}
