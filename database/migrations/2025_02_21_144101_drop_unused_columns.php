<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class DropUnusedColumns extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            $table->dropColumn([
                'ar_refer_physician_name',
                'ar_refer_reason',
                'ar_refer_facility',
                'fm_side_disorders',
                'fmh_side_copd'
            ]);
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
            $table->string('ar_refer_physician_name')->nullable();
            $table->string('ar_refer_reason')->nullable();
            $table->string('ar_refer_facility')->nullable();
            $table->string('fm_side_disorders')->nullable();
            $table->string('fmh_side_copd')->nullable();
        });
    }
}
