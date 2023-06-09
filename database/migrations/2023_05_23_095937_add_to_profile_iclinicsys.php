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
            $table->string('household_num',30);
            $table->string('philhealth_categ', 15);
            $table->string('fourps_num', 30);
            $table->string('health_group', 20);
            $table->string('fam_plan', 10);
            $table->string('fam_plan_method', 20);
            $table->string('fam_plan_other_method');
            $table->string('fam_plan_status', 25);
            $table->string('fam_plan_other_status');
            $table->text('other_med_history');
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
