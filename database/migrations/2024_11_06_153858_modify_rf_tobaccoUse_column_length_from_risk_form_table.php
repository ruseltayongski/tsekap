<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ModifyRfTobaccoUseColumnLengthFromRiskFormTable extends Migration
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
            $table->string('rf_tobbacoUse', 100)->change(); // Increase the length to 255
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
            $table->string('rf_tobbacoUse', 100)->change(); // Revert to original length if rolling back
        });
    }
}
