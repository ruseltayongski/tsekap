<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePertinentExamination extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pertinent_examination', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('per_orriented_time')->nullable();
            $table->integer('per_conscious')->nullable();
            $table->integer('per_ambulatory')->nullable();
            $table->integer('per_others')->nullable();
            $table->string('per_others_specify',50)->nullable();
            $table->string('per_bp',50)->nullable();
            $table->string('per_hr',50)->nullable();
            $table->string('per_rr',50)->nullable();
            $table->string('per_temp',50)->nullable();
            $table->string('per_blood_type',50)->nullable();
            $table->string('per_weight',50)->nullable();
            $table->string('per_height',50)->nullable();
            $table->string('per_waist',50)->nullable();
            $table->string('per_hip',50)->nullable();
            $table->string('per_ratio',50)->nullable();
            $table->integer('per_skin_good')->nullable();
            $table->integer('per_skin_pailor')->nullable();
            $table->integer('per_skin_jaundice')->nullable();
            $table->integer('per_skin_rashes')->nullable();
            $table->integer('per_skin_lession')->nullable();
            $table->string('per_skin_lession_specify',100)->nullable();
            $table->string('per_skin_others',50)->nullable();
            $table->integer('per_status')->nullable();
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
        Schema::drop("pertinent_examination");
    }
}
