<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RestoreUserHealthFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET foreign_key_checks = 0');
        
        // Create the new user_health_facility table with InnoDB engine
        Schema::create('user_health_facility', function (Blueprint $table) {
            $table->engine = 'InnoDB';  // Ensure InnoDB engine is used
            $table->increments('id');  // Primary key column
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('facility_id');
            $table->string('user_designation', 255);
            $table->date('assigned_at');
            
            // Foreign keys
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('facility_id')->references('id')->on('facilities')->onDelete('cascade');
            
            $table->timestamps();  // Add created_at and updated_at columns
        });
        
        DB::statement('SET foreign_key_checks = 1');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::statement('SET foreign_key_checks = 0');
        
        // Drop the 'user_health_facility' table if it exists
        Schema::dropIfExists('user_health_facility');
        
        DB::statement('SET foreign_key_checks = 1');
    }
}
