<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAvailableServices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('available_services')){
            return true;
        }
        Schema::create('available_services', function (Blueprint $table) {
            $table->increments('id');
            $table->string('facility_code');
            $table->string('service')->nullable();
            $table->string('costing')->nullable();
            $table->string('type', 30)->nullable();
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
        //
    }
}
