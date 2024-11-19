<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSystolicDiastolicColumnToRiskForm extends Migration
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
            $table->integer('rs_systolic_t1')->nullable()->after('rf_waistCircum');
            $table->integer('rs_diastolic_t1')->nullable()->after('rs_systolic_t1');
            $table->integer('rs_systolic_t2')->nullable()->after('rs_diastolic_t1');
            $table->integer('rs_diastolic_t2')->nullable()->after('rs_systolic_t2');
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
            $table->integer('rs_systolic_t1')->nullable()->after('rf_waistCircum');
            $table->integer('rs_diastolic_t1')->nullable()->after('rs_systolic_t1');
            $table->integer('rs_systolic_t2')->nullable()->after('rs_diastolic_t1');
            $table->integer('rs_diastolic_t2')->nullable()->after('rs_systolic_t2');
        });
    }
}
