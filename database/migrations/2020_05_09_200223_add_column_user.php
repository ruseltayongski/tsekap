<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('email',100)->nullable();
            $table->string('contact_no',100)->nullable();
            $table->string('type_rdu',255)->nullable();
            $table->string('pin',100)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['email']);
            $table->dropColumn(['contact_no']);
            $table->dropColumn(['type_rdu']);
            $table->dropColumn(['pin']);
        });
    }
}
