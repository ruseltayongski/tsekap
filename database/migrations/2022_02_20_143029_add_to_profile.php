<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddToProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->string('birth_place')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('religion')->nullable();
            $table->string('other_religion')->nullable();
            $table->string('contact')->nullable();
            $table->float('height')->nullable();
            $table->float('weight')->nullable();
            $table->string('cancer')->nullable();
            $table->string('cancer_type')->nullable();
            $table->string('mental_med')->nullable();
            $table->string('tbdots_med')->nullable();
            $table->string('cvd_med')->nullable();
            $table->string('covid_status')->nullable();
            $table->string('menarche')->nullable();
            $table->integer('menarche_age')->nullable();
            $table->string('newborn_screen')->nullable();
            $table->string('newborn_text')->nullable();
            $table->string('deceased')->nullable();
            $table->date('deceased_date')->nullable();
            $table->string('pwd_desc')->nullable();
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
