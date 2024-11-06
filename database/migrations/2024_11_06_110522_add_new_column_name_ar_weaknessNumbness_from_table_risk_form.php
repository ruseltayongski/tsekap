<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnNameArWeaknessNumbnessFromTableRiskForm extends Migration
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
            $table->string('ar_weaknessNumbness',8)->nullable()->after('ar_facialAsymmetry'); // Adding bodypartId after the side column
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
            $table->string('ar_weaknessNumbness',8)->nullable()->after('ar_facialAsymmetry'); // Adding bodypartId after the side column
        });
    }
}
