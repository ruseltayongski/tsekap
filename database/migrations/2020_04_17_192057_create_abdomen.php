<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAbdomen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('abdomen', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('abd_no_findings')->nullable();
            $table->integer('abd_tenderness')->nullable();
            $table->integer('abd_palpable')->nullable();
            $table->string('abd_palpable_specify',100)->nullable();
            $table->integer('abd_others')->nullable();
            $table->string('abd_others_specify',100)->nullable();
            $table->integer('abd_status')->nullable();
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
        Schema::drop("abdomen");
    }
}
