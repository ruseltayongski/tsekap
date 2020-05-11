<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBherds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bherds_patient', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id')->nullable();
            $table->integer('encoded_by')->nullable();
            $table->date('date_of_arrival')->nullable();
            $table->date('end_of_quarantine')->nullable();
            $table->string('patient_code',255)->nullable();
            $table->string('nationality',100)->nullable();
            $table->string('purok',255)->nullable();
            $table->string('sitio',255)->nullable();
            $table->string('contact_no',100)->nullable();
            $table->string('travel_history',255)->nullable();
            $table->string('passport_number',255)->nullable();
            $table->string('flight_number',255)->nullable();
            $table->string('type_quarantine',255)->nullable();
            $table->string('place_quarantine',255)->nullable();
            $table->string('sign_symptoms',255)->nullable();
            $table->string('remarks',255)->nullable();
            $table->string('latitude',255)->nullable();
            $table->string('longitude',255)->nullable();

            //FOR REPORTS
            $table->time('start_time')->nullable();
            $table->time('completion_time')->nullable();
            $table->string('email',100)->nullable();
            $table->string('icd_10',255)->nullable();
            $table->string('admitted',100)->nullable();
            $table->date('date_admission')->nullable();
            $table->date('date_onset')->nullable();
            $table->string('name_coordinator',255)->nullable();
            $table->string('dsc_contact_number',100)->nullable();
            $table->string('cat1',255)->nullable();
            $table->date('cat_date')->nullable();
            $table->string('admitting_diagnosis',255)->nullable();
            $table->string('with_fever',255)->nullable();
            $table->string('with_colds',255)->nullable();
            $table->string('with_cough',255)->nullable();
            $table->string('with_sore_throat',255)->nullable();
            $table->string('with_diarrhea',255)->nullable();
            $table->string('with_difficult_breathing',255)->nullable();
            $table->string('parent_name',255)->nullable();
            $table->string('number_person_living',255)->nullable();
            $table->date('outcome_date_died')->nullable();

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
        Schema::drop("bherds_patient");
    }
}
