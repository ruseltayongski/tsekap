<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilityAssignment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('doh_referral.facility_assignment')){
            return true;
        }
        Schema::create('doh_referral.facility_assignment', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('facility_id');
            $table->string('specialization')->nullable();
            $table->string('schedule', 30)->nullable();
            $table->string('fee', 30)->nullable();
            $table->string('contact',20)->nullable();
            $table->string('email',30)->nullable();
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
