<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProfilePending extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profile_pending', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique_id',255)->nullable();
            $table->string('familyID',255)->nullable();
            $table->string('phicID',100)->nullable();
            $table->string('nhtsID',100)->nullable();
            $table->string('head',100)->nullable();
            $table->string('relation',255)->nullable();
            $table->string('fname',255)->nullable();
            $table->string('mname',255)->nullable();
            $table->string('lname',255)->nullable();
            $table->string('suffix',255)->nullable();
            $table->date('dob')->nullable();
            $table->string('sex',255)->nullable();
            $table->integer('sitio_id')->nullable();
            $table->integer('purok_id')->nullable();
            $table->integer('barangay_id')->nullable();
            $table->integer('muncity_id')->nullable();
            $table->integer('province_id')->nullable();
            $table->integer('income')->nullable();
            $table->integer('unmet')->nullable();
            $table->integer('water')->nullable();
            $table->string('toilet',10)->nullable();
            $table->string('education',20)->nullable();
            $table->string('hypertension',255)->nullable();
            $table->string('diabetic',255)->nullable();
            $table->string('pwd',255)->nullable();
            $table->date('pregnant')->nullable();
            $table->string('dengvaxia',45)->nullable();


            $table->string('status',100)->nullable();
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
        Schema::drop("profile_pending");
    }
}
