<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnIfYesToSymptomsFromRiskFormTable extends Migration
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
            $table->string('rs_If YES to any of the symptoms',100)->nullable()->after('rs_respiratory'); 
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
            $table->string('rs_If YES to any of the symptoms',100)->nullable()->after('rs_respiratory'); 
        });
    }
}
