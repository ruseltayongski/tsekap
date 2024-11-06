<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropColumnFromRiskForm extends Migration
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
            $table->dropColumn('ar_diffBreat');
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
            $table->string('ar_diffBreat', 8)->nullable()->after('risk_profile_id');
        });
    }
}
