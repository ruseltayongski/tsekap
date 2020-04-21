<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateGeneralInfomation extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('general_information', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->string('dengvaxia_recipient_no',100)->nullable();
            $table->integer('respondent')->nullable();
            $table->string('contact_no',50)->nullable();
            $table->string('street_name',121)->nullable();
            $table->string('sitio',121)->nullable();
            $table->string('religion',100)->nullable();
            $table->string('religion_others',100)->nullable();
            $table->string('birth_place',255)->nullable();
            $table->integer('yrs_current_address')->nullable();
            $table->integer('status')->nullable();
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
        Schema::drop("general_information");
    }
}
