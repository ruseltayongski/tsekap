<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityInTsekap extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('facility_add_info')){
            return true;
        }
        Schema::create('facility_add_info', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facility_code');
            $table->string('service_cap')->nullable();
            $table->string('phic_status')->nullable();
            $table->string('sched_day_from')->nullable();
            $table->string('sched_day_to')->nullable();
            $table->time('sched_time_from')->nullable();
            $table->time('sched_time_to')->nullable();
            $table->string('sched_notes')->nullable();
            $table->string('transport')->nullable();
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
    }
}
