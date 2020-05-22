<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePurokDeleted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('purok_deleted', function (Blueprint $table) {
            $table->increments('purok_id');
            $table->integer('purok_deleted_by')->nullable();
            $table->string('purok_name',255)->nullable();
            $table->integer('purok_barangay_id')->nullable();
            $table->integer('purok_target')->nullable();
            $table->integer('purok_status')->nullable();
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
        Schema::drop("purok_deleted");
    }
}
