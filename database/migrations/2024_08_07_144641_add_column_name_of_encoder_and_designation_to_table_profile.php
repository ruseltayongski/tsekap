<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnNameOfEncoderAndDesignationToTableProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->string('nameof_encoder')->nullable()->after('Hospital_caseno');
            $table->string('designation')->nullable()->after('nameof_encoder');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('profile', function (Blueprint $table) {
            $table->dropColumn('nameof_encoder');
            $table->dropColumn('designation');
        });
    }
}
