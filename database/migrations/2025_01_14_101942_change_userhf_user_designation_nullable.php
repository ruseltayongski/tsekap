<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangeUserhfUserDesignationNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement('SET foreign_key_checks = 0');

        Schema::table('user_health_facility', function(Blueprint $table){
            $table->string('user_designation')->nullable()->change();
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

        Schema::table('user_health_facility', function(Blueprint $table){
            $table->string('user_designation')->nullable(false)->change();
        });

        DB::statement('SET foreign_key_checks = 1');
    }
}
