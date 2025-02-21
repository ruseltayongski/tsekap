<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class EditRiskFormTableReference extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Manually modify the column type
        DB::statement('ALTER TABLE risk_form MODIFY risk_profile_id INT(10) UNSIGNED NULL');

        Schema::table('risk_form', function (Blueprint $table) {
            // Re-add the foreign key constraint
            $table->foreign('risk_profile_id')
                ->references('id')
                ->on('risk_profile')
                ->onDelete('cascade')
                ->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            // Drop foreign key
            $table->dropForeign(['risk_profile_id']);
        });

        // Revert risk_profile_id back to VARCHAR
        DB::statement('ALTER TABLE risk_form MODIFY risk_profile_id VARCHAR(255) NULL');
    }
}
