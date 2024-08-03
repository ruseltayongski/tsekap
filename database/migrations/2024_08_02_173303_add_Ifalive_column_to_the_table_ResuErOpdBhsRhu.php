<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddIfaliveColumnToTheTableResuErOpdBhsRhu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('resuErOpdBhsRhu', function (Blueprint $table) {
            $table->string('Ifalive')->nullable()->after('status_facility');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('resuErOpdBhsRhu', function (Blueprint $table) {
            $table->dropColumn('Vehicular_acc_type');
        });
    }
}
