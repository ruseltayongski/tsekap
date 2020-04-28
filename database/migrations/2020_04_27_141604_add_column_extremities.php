<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnExtremities extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('extremities', function (Blueprint $table) {
            $table->integer('extre_enzymes')->nullable();
            $table->string('extre_enzymes_specify',255)->nullable();
            $table->integer('extre_ns')->nullable();
            $table->integer('extre_pcr')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('extremities', function (Blueprint $table) {
            $table->dropColumn(['extre_enzymes']);
            $table->dropColumn(['extre_enzymes_specify']);
            $table->dropColumn(['extre_ns']);
            $table->dropColumn(['extre_pcr']);
        });
    }
}
