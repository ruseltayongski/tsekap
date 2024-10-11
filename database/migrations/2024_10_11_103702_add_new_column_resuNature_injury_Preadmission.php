<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewColumnResuNatureInjuryPreadmission extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::table('resuNature_injury_Preadmission', function (Blueprint $table) {
            $table->integer('bodypartId')->nullable()->after('side'); // Adding bodypartId after the side column
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
        Schema::table('resuNature_injury_Preadmission', function (Blueprint $table) {
            $table->dropColumn('bodypartId'); // Dropping the bodypartId column on rollback
        });
    }
}
