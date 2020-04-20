<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class PhicMembership extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phic_membership', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('phic_status',100)->nullable();
            $table->string('phic_type',100)->nullable();
            $table->string('phic_sponsored',100)->nullable();
            $table->string('phic_sponsored_others',100)->nullable();
            $table->string('phic_employed',100)->nullable();
            $table->string('phic_benefits',10)->nullable();
            $table->string('phic_benefits_yes',100)->nullable();
            $table->integer('phic_status1')->nullable();
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
        Schema::drop("phic_membership");
    }
}
