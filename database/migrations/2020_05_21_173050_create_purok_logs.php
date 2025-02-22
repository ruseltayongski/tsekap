<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurokLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if(Schema::hasTable('purok_logs')){
            return true;
        }
        Schema::create('purok_logs', function (Blueprint $table) {
            $table->increments('purok_logs_id');
            $table->integer('purok_id')->nullable();
            $table->integer('purok_logs_by')->nullable();
            $table->string('purok_name',255)->nullable();
            $table->integer('purok_barangay_id')->nullable();
            $table->integer('purok_target')->nullable();
            $table->string('purok_status',255)->nullable();
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
        Schema::drop("purok_logs");
    }
}
