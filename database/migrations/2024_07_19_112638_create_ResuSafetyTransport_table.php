<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuSafetyTransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('ResuSafetyTransport', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('Transport_safety_id')->nullable();
            $table->integer('safety_id')->nullable();
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
        Schema::drop("ResuSafetyTransport");
    }
}
