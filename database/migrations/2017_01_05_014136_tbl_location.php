<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblLocation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('province')){

        }else{
            Schema::create('province',function(Blueprint $table){
                $table->increments('id');
                $table->string('description');
                $table->timestamps();
            });
        }


        if(Schema::hasTable('muncity')){

        }else{
            Schema::create('muncity',function(Blueprint $table){
                $table->increments('id');
                $table->integer('province_id');
                $table->string('description');
                $table->timestamps();
            });
        }


        if(Schema::hasTable('barangay')){

        }else{
            Schema::create('barangay',function(Blueprint $table){
                $table->increments('id');
                $table->integer('province_id');
                $table->integer('muncity_id');
                $table->string('description');
                $table->integer('target');
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
        Schema::drop('province');
        Schema::drop('muncity');
        Schema::drop('barangay');
    }
}
