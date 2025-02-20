<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

use Carbon\Carbon;

class CreateTableNewAgeBrackets extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // You may recreate the table here if needed
        Schema::create('new_age_brackets', function (Blueprint $table) {
            $table->integer('age_id')->autoIncrement();
            $table->string('range');
            $table->string('description')->nullable();
            $table->timestamps();
        });

        DB::table('new_age_brackets')->insert([
            ['range' => '20-29 years old', 'description' => 'Young Adult', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['range' => '30-39 years old', 'description' => 'Young Adult', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['range' => '40-49 years old', 'description' => 'Middle-aged Adult', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['range' => '50-59 years old', 'description' => 'Middle-aged Adult', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
            ['range' => '60+ years old', 'description' => 'Senior Citizen', 'created_at' => Carbon::now(), 'updated_at' => Carbon::now()],
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('new_age_brackets');
    }
}
