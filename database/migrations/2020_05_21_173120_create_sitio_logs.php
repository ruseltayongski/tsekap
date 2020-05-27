<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitioLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitio_logs', function (Blueprint $table) {
            $table->increments('sitio_logs_id');
            $table->integer('sitio_id')->nullable();
            $table->integer('sitio_logs_by')->nullable();
            $table->string('sitio_name',255)->nullable();
            $table->integer('sitio_barangay_id')->nullable();
            $table->integer('sitio_target')->nullable();
            $table->string('sitio_status',255)->nullable();
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
        Schema::drop("sitio_logs");
    }
}
