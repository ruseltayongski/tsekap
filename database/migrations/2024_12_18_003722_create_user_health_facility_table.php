<?php

use Illuminate\Database\Migrations\Migration;

class CreateUserHealthFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_health_facility', function($table) {
            $table->integer('user_id')->unsigned();
            $table->integer('facility_id')->unsigned();
            $table->string('user_designation')->nullable();
            $table->timestamp('assigned_at')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->primary(['user_id', 'facility_id']);

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('user_health_facility');
    }
}
