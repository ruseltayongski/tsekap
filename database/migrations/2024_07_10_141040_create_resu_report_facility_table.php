<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuReportFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('resu_Report_facility', function (Blueprint $table){
            $table->increments('id');
            $table->string('reportfacility')->nullable();
            $table->string('typeOfdru')->nullable();
            $table->string('Addressfacility')->nullable();
            $table->string('typeofpatient')->nullable();
            $table->timestamps();
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
        Schema::drop("resu_Report_facility");
    }
}
