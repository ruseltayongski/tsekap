<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlterSafetyColumnInResutransportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('Resutransport', function (Blueprint $table) {
            $table->text('safety')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('Resutransport', function (Blueprint $table) {
            $table->string('safety')->change();
        });
    }
}
