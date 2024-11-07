<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameColumnIfYesToSymptomsFromRiskFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            //
            DB::statement('ALTER TABLE risk_form CHANGE `rs_If YES to any of the symptoms` `rs_if_yes_any_symptoms` VARCHAR(100) NULL');
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
            //
            DB::statement('ALTER TABLE risk_form CHANGE `rs_if_yes_any_symptoms` `rs_If YES to any of the symptoms` VARCHAR(100) NULL');
        });
    }
}
