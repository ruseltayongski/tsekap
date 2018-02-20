<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ServiceOption extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('serviceoption')){
            return true;
        }

        Schema::create('serviceoption',function(Blueprint $table){
            $table->increments('id');
            $table->date('dateProfile');
            $table->integer('profile_id');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
            $table->string('option');
            $table->integer('status');
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
        Schema::drop('serviceoption');
    }
}
