<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSitioDeleted extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sitio_deleted', function (Blueprint $table) {
            $table->increments('sitio_id');
            $table->integer('sitio_deleted_by')->nullable();
            $table->string('sitio_name',255)->nullable();
            $table->integer('sitio_barangay_id')->nullable();
            $table->integer('sitio_target')->nullable();
            $table->integer('sitio_status')->nullable();
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
        Schema::drop("sitio_deleted");
    }
}
