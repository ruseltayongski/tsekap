<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnToResuReportFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resu_Report_facility', function (Blueprint $table) {
            //
            $table->renameColumn('others', 'facilityName');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resu_Report_facility', function (Blueprint $table) {
            //
            $table->renameColumn('others', 'facilityName');
        });
    }
}
