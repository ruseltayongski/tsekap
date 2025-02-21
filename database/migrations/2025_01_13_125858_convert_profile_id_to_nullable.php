<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ConvertProfileIdToNullable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_profile', function(Blueprint $table){
            $table->integer('profile_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_profile', function(Blueprint $table){
            $table->unsignedBigInteger('risk_profile_id')->nullable(false)->change();
        });
    }
}
