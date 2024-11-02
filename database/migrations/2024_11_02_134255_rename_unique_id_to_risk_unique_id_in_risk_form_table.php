<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RenameUniqueIdToRiskUniqueIdInRiskFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            $table->renameColumn('unique_id', 'risk_unique_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            $table->renameColumn('risk_unique_id', 'unique_id');
        });
    }
}
