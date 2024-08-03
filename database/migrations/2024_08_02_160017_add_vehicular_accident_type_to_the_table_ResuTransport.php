<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddVehicularAccidentTypeToTheTableResuTransport extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Resutransport', function (Blueprint $table) {
            $table->string('Vehicular_acc_type')->nullable()->after('transport_accident_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Resutransport', function (Blueprint $table) {
            $table->dropColumn('Vehicular_acc_type');
        });
    }
}
