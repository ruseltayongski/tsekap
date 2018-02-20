<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProfileServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('profileServices')){
            return true;
        }

        Schema::create('profileServices',function(Blueprint $table){
            $table->increments('id');
            $table->date('dateProfile');
            $table->integer('profile_id');
            $table->integer('service_id');
            $table->integer('bracket_id');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
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
        Schema::drop('profileServices');
    }
}
