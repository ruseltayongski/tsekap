<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableRiskProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_profile', function (Blueprint $table) {
            $table->increments('id'); // Primary key with auto-increment
            $table->integer('profile_id')->nullable(); // Foreign key, nullable
            $table->string('lname', 50); // Last name
            $table->string('fname', 50); // First name
            $table->string('mname', 50)->nullable(); // Middle name, nullable
            $table->string('suffix', 5)->nullable(); // Suffix, nullable
            $table->string('sex', 7); // Sex
            $table->timestamp('dob'); // Date of birth
            $table->integer('age'); // Age
            $table->string('civil_status', 30); // Civil status
            $table->string('religion', 30); // Religion
            $table->string('other_religion', 50)->nullable();;
            $table->string('contact');
            $table->integer('province_id'); // Province ID
            $table->integer('municipal_id'); // Municipal ID
            $table->integer('barangay_id'); // Barangay ID
            $table->string('street', 50)->nullable(); // Street, nullable
            $table->string('purok', 50)->nullable(); // Purok, nullable
            $table->string('sitio', 50)->nullable(); // Sitio, nullable
            $table->integer('phic_id')->nullable(); // PHIC ID, nullable
            $table->integer('pwd_id')->nullable(); // PWD ID, nullable
            $table->string('ethnicity', 30); // Ethnicity    
            $table->string('other_ethnicity', 30)->nullable();
            $table->string('indigenous_person', 5); // Indigenous person
            $table->string('employment_status', 20); // Employment status
            $table->integer('facility_id_updated');
            // Optional timestamps for created_at and updated_at columns
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
        Schema::drop('risk_profile');
    }
}
