<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnNameArChestpainFromTableRiskForm extends Migration
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
            $table->string('ar_chestpain',8)->nullable()->after('risk_profile_id'); // Adding bodypartId after the side column
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
            $table->string('ar_chestpain',8)->nullable()->after('risk_profile_id'); // Adding bodypartId after the side column
        });
    }
}
