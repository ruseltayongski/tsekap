<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnOthersAndFacilityIdToTableReportFacility extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resu_Report_facility', function (Blueprint $table) {
            $table->integer('facility_id')->nullable()->after('id');
            $table->string('others')->nullable()->after('facility_id');
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
            $table->dropColumn('facility_id');
            $table->dropColumn('others');
        });
    }
}
