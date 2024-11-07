<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnRsRespiratoryFromRiskFormTable extends Migration
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
            //
            DB::statement('ALTER TABLE risk_form CHANGE `rs_respiratory` `rs_Chronic_Respiratory_Disease` VARCHAR(100) NULL');
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
            //
            DB::statement('ALTER TABLE risk_form CHANGE `rs_respiratory` `rs_Chronic_Respiratory_Disease` VARCHAR(100) NULL');
        });
    }
}
