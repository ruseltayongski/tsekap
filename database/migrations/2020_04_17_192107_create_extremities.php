<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExtremities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extremities', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('extre_abnormal')->nullable();
            $table->integer('extre_edema')->nullable();
            $table->integer('extre_join')->nullable();
            $table->integer('extre_deformity')->nullable();
            $table->string('extre_deformity_describe',100)->nullable();
            $table->integer('extre_others')->nullable();
            $table->string('extre_others_specify',100)->nullable();
            $table->integer('extre_status')->nullable();
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
        Schema::drop("extremities");
    }
}
