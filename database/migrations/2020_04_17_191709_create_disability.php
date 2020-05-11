<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDisability extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('disability', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('dis_tick',100)->nullable();
            $table->string('dis_with_assistive',10)->nullable();
            $table->string('dis_with_assistive_yes',100)->nullable();
            $table->string('dis_need_assistive',10)->nullable();
            $table->string('dis_need_assistive_yes',100)->nullable();
            $table->integer('dis_status')->nullable();
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
        Schema::drop("disability");
    }
}
