<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToProfileIclinicsys extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->string('household_num');
            $table->string('philhealth_categ');
            $table->string('4ps_num');
            $table->string('health_group');
            $table->string('fam_plan');
            $table->string('fam_plan_method');
            $table->string('fam_plan_other_method');
            $table->string('fam_plan_status');
            $table->string('fam_plan_other_status');
            $table->string('other_med_history');
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
    }
}
