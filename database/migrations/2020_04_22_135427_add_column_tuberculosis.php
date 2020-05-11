<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnTuberculosis extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tuberculosis', function (Blueprint $table) {
            $table->integer('tb_ppd')->nullable();
            $table->string('tb_result_ppd',255)->nullable();
            $table->integer('tb_sputum_exam')->nullable();
            $table->string('tb_result_eputum_exam',255)->nullable();
            $table->integer('tb_cxr')->nullable();
            $table->string('tb_result_cxr',255)->nullable();
            $table->integer('tb_genxpert')->nullable();
            $table->string('tb_result_genxpert',255)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tuberculosis', function (Blueprint $table) {
            $table->dropColumn(['tb_ppd']);
            $table->dropColumn(['tb_result_ppd']);
            $table->dropColumn(['tb_sputum_exam']);
            $table->dropColumn(['tb_result_eputum_exam']);
            $table->dropColumn(['tb_cxr']);
            $table->dropColumn(['tb_result_cxr']);
            $table->dropColumn(['tb_genxpert']);
            $table->dropColumn(['tb_result_genxpert']);
        });
    }
}
