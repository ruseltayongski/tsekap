<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class RenameEthnicityToCitizenship extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the temporary table exists, and drop it if it does
        Schema::dropIfExists('risk_profile_temp');

        // Create the temporary table
        Schema::create('risk_profile_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname');
            $table->string('suffix');
            $table->string('sex');
            $table->date('dob');
            $table->integer('age');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('other_religion');
            $table->string('contact');
            $table->string('province_id');
            $table->string('municipal_id');
            $table->string('barangay_id');
            $table->string('street');
            $table->string('purok');
            $table->string('sitio');
            $table->string('phic_id');
            $table->string('pwd_id');
            $table->string('ethnicity'); // Change this to citizenship
            $table->string('other_ethnicity'); // Change this to other_citizenship
            $table->string('indigenous_person');
            $table->string('employment_status');
            $table->string('facility_id_updated');
            $table->timestamps();
        });

        // Migrate data from the original table to the temporary table
        DB::statement('INSERT INTO risk_profile_temp SELECT * FROM risk_profile');

        // Drop the original risk_profile table
        Schema::dropIfExists('risk_profile');

        // Create the risk_profile table with new column names
        Schema::create('risk_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname');
            $table->string('suffix');
            $table->string('sex');
            $table->date('dob');
            $table->integer('age');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('other_religion');
            $table->string('contact');
            $table->string('province_id');
            $table->string('municipal_id');
            $table->string('barangay_id');
            $table->string('street');
            $table->string('purok');
            $table->string('sitio');
            $table->string('phic_id');
            $table->string('pwd_id');
            $table->string('citizenship'); // Changed to citizenship
            $table->string('other_citizenship'); // Changed to other_citizenship
            $table->string('indigenous_person');
            $table->string('employment_status');
            $table->string('facility_id_updated');
            $table->timestamps();
        });

        // Migrate data from the temporary table to the new table
        DB::statement('INSERT INTO risk_profile SELECT * FROM risk_profile_temp');

        // Drop the temporary table
        Schema::dropIfExists('risk_profile_temp');
    }



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('risk_profile_temp', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname');
            $table->string('suffix');
            $table->string('sex');
            $table->date('dob');
            $table->integer('age');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('other_religion');
            $table->string('contact');
            $table->string('province_id');
            $table->string('municipal_id');
            $table->string('barangay_id');
            $table->string('street');
            $table->string('purok');
            $table->string('sitio');
            $table->string('phic_id');
            $table->string('pwd_id');
            $table->string('citizenship');
            $table->string('other_citizenship');
            $table->string('indigenous_person');
            $table->string('employment_status');
            $table->string('facility_id_updated');
            $table->timestamps();
        });

        DB::statement('insert into risk_profile_temp select * from risk_profile');

        Schema::dropIfExists('risk_profile');

        Schema::create('risk_profile', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('profile_id');
            $table->string('lname');
            $table->string('fname');
            $table->string('mname');
            $table->string('suffix');
            $table->string('sex');
            $table->date('dob');
            $table->integer('age');
            $table->string('civil_status');
            $table->string('religion');
            $table->string('other_religion');
            $table->string('contact');
            $table->string('province_id');
            $table->string('municipal_id');
            $table->string('barangay_id');
            $table->string('street');
            $table->string('purok');
            $table->string('sitio');
            $table->string('phic_id');
            $table->string('pwd_no');
            $table->string('ethnicity');
            $table->string('other_ethnicity');
            $table->string('indigenous_person');
            $table->string('employment_status');
            $table->string('facility_id_updated');
            $table->timestamps();
        });

        DB::statement('INSERT INTO risk_profile SELECT * FROM risk_profile_temp');

        Schema::dropIfExists('risk_profile_temp');
    }
}