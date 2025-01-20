<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class AddColumnTypeofpatientToProfileTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        if (!Schema::hasColumn('profile', 'typeofpatient')) {
            Schema::table('profile', function (Blueprint $table) {
                $table->string('typeofpatient')->nullable()->after('Hospital_caseno');
            });
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        if (Schema::hasColumn('profile', 'typeofpatient')) {
            Schema::table('profile', function (Blueprint $table) {
                $table->dropColumn('typeofpatient');
            });
        }
    }
}
