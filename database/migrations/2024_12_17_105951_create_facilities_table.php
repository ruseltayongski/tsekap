<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFacilitiesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->increments('id'); // id int(10) unsigned NO PRI auto_increment
            $table->string('facility_code', 100)->nullable(); // facility_code varchar(100) YES
            $table->string('name'); // name varchar(255) NO
            $table->string('latitude')->nullable(); // latitude varchar(255) YES
            $table->string('longitude')->nullable(); // longitude varchar(255) YES
            $table->string('abbr'); // abbr varchar(255) NO
            $table->string('address'); // address varchar(255) NO
            $table->integer('brgy'); // brgy int(11) NO
            $table->integer('muncity'); // muncity int(11) NO
            $table->integer('province'); // province int(11) NO
            $table->string('contact'); // contact varchar(255) NO
            $table->string('email'); // email varchar(255) NO
            $table->integer('status'); // status int(11) NO
            $table->string('picture')->nullable(); // picture varchar(255) YES
            $table->string('chief_hospital', 100)->nullable(); // chief_hospital varchar(100) YES
            $table->string('level')->nullable(); // level varchar(255) YES
            $table->string('hospital_type', 45)->nullable(); // hospital_type varchar(45) YES
            $table->integer('tricity_id')->nullable(); // tricity_id int(11) YES
            $table->string('referral_used', 45)->nullable(); // referral_used varchar(45) YES
            $table->timestamps(); // created_at timestamp YES, updated_at timestamp YES 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Drop if exists
        Schema::dropIfExists('facilities');
    }
}
