<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateTableNameNullableFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_profile', function (Blueprint $table) {
            $table->string('mname')->nullable()->default('')->change();
            $table->string('suffix')->nullable()->default('')->change();
            $table->string('other_religion')->nullable()->default('')->change();
            $table->string('street')->nullable()->default('')->change();
            $table->string('purok')->nullable()->default('')->change();
            $table->string('sitio')->nullable()->default('')->change();
            $table->string('phic_id')->nullable()->default('')->change();
            $table->string('pwd_id')->nullable()->default('')->change();
            $table->string('other_citizenship')->nullable()->default('')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_profile', function (Blueprint $table) {
            $table->string('mname')->nullable(false)->default(null)->change();
            $table->string('suffix')->nullable(false)->default(null)->change();
            $table->string('other_religion')->nullable(false)->default(null)->change();
            $table->string('street')->nullable(false)->default(null)->change();
            $table->string('purok')->nullable(false)->default(null)->change();
            $table->string('sitio')->nullable(false)->default(null)->change();
            $table->string('phic_id')->nullable(false)->default(null)->change();
            $table->string('pwd_id')->nullable(false)->default(null)->change();
            $table->string('other_citizenship')->nullable(false)->default(null)->change();
        });
    }
}
