<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class UserBarangay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('userbrgy')){
            return true;
        }

        Schema::create('userbrgy',function(Blueprint $table){
            $table->increments('id');
            $table->integer('user_id');
            $table->integer('barangay_id');
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
        Schema::drop('userbrgy');
    }
}
