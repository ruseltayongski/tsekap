<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class FemaleStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('femalestatus')){
            return true;
        }

        Schema::create('femalestatus',function(Blueprint $table){
            $table->increments('id');
            $table->date('dateProfile');
            $table->integer('profile_id');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
            $table->string('status');
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
        Schema::drop('femalestatus');
    }
}
