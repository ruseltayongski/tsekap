<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateValidCounter extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('servicegroup')){
            return true;
        }

        Schema::create('servicegroup',function(Blueprint $table){
            $table->increments('id');
            $table->date('dateProfile');
            $table->string('profile_id')->unique();
            $table->string('sex');
            $table->integer('group1');
            $table->integer('group2');
            $table->integer('group3');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
            $table->integer('bracket_id');
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
        Schema::drop('servicegroup');
    }
}
