<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnAntiDiabetesOptionsFromRiskFormTable extends Migration
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
            $table->string('mngm_med_diabetes_options',50)->nullable()->after('mngm_med_diabetes'); // Adding bodypartId after the side column
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
            $table->string('mngm_med_diabetes_options',50)->nullable()->after('mngm_med_diabetes'); // Adding bodypartId after the side column
        });
    }
}
