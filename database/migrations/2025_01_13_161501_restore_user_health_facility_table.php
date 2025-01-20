<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class RestoreUserHealthFacilityTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasTable('user_health_facility')) {
            DB::statement('SET foreign_key_checks = 0');

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
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasTable('user_health_facility')) {
            DB::statement('SET foreign_key_checks = 0');
            Schema::dropIfExists('user_health_facility');
            DB::statement('SET foreign_key_checks = 1');
        }
    }
}
