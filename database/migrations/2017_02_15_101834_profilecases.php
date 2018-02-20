<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Profilecases extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('profilecases')){
            return true;
        }

        Schema::create('profilecases',function(Blueprint $table){
            $table->increments('id');
            $table->date('dateProfile');
            $table->integer('profile_id');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
            $table->integer('bracket_id');
            $table->integer('case_id');
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
        Schema::drop('profilecases');
    }
}
