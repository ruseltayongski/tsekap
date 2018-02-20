<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class TblProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('profile')){
            return true;
        }
        Schema::create('profile',function(Blueprint $table){
            $table->increments('id');
            $table->integer('familyID');
            $table->string('head');
            $table->string('relation');
            $table->string('fname');
            $table->string('mname');
            $table->string('lname');
            $table->string('suffix');
            $table->date('dob');
            $table->char('sex');
            $table->integer('barangay_id');
            $table->integer('muncity_id');
            $table->integer('province_id');
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
        Schema::drop('profile');
    }
}
