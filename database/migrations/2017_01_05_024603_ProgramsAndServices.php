<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ProgramsAndServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('brackets')){

        }else{
            Schema::create('brackets',function(Blueprint $table){
                $table->increments('id');
                $table->string('description');
                $table->timestamps();
            });
        }


        if(Schema::hasTable('services')){

        }else{
            Schema::create('services',function(Blueprint $table){
                $table->increments('id');
                $table->string('code');
                $table->string('description');
                $table->timestamps();
            });
        }


        if(Schema::hasTable('bracketServices')){

        }else{
            Schema::create('bracketServices',function(Blueprint $table){
                $table->increments('id');
                $table->integer('bracket_id');
                $table->integer('service_id');
                $table->timestamps();
            });
        }

    }
    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('brackets');
        Schema::drop('services');
        Schema::drop('bracketServices');
    }
}
