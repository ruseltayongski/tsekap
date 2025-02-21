<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddConfirmOfflineEntryColumnsRiskFormAndProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Add offline entry columns to risk_form and risk_profile tables
        Schema::table('risk_form', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_form', 'offline_entry')) {
                $table->boolean('offline_entry')->nullable()->default(false)->after('mngm_remarks');
            }
        });

        Schema::table('risk_profile', function (Blueprint $table) {
            if (!Schema::hasColumn('risk_profile', 'offline_entry')) {
                $table->boolean('offline_entry')->nullable()->default(false)->after('facility_id_updated');;
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop offline entry columns from risk_form and risk_profile tables
        Schema::table('risk_form', function (Blueprint $table) {
            if (Schema::hasColumn('risk_form', 'offline_entry')) {
                $table->dropColumn('offline_entry');
            }
        });

        Schema::table('risk_profile', function (Blueprint $table) {
            if (Schema::hasColumn('risk_profile', 'offline_entry')) {
                $table->dropColumn('offline_entry');
            }
        });
    }
}
