<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResuPreadmissionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('resuPre_admission', function (Blueprint $table){
            $table->increments('id');
            $table->Integer('profile_id')->nullable();
            $table->Integer('POIProvince_id',)->nullable();
            $table->Integer('POImuncity_id',)->nullable();
            $table->Integer('POIBarangay_id',)->nullable();
            $table->string('POIPurok', 255)->nullable();
            $table->date('dateInjury')->nullable();
            $table->time('timeInjury')->nullable();
            $table->date('dateConsult')->nullable();
            $table->time('timeConsult')->nullable();
            $table->string('injury_intent', 100)->nullable();
            $table->string('first_aid', 10)->nullable();
            $table->string('what', 100)->nullable();
            $table->string('bywhom', 100)->nullable();
            $table->string('multipleInjury', 10)->nullable();
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
        //
    }
}
