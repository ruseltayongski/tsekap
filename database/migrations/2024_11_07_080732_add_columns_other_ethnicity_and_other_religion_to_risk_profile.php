<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnsOtherEthnicityAndOtherReligionToRiskProfile extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_profile', function (Blueprint $table) {
            // Add 'other_ethnicity' column after 'ethnicity'
            $table->string('other_ethnicity', 30)->nullable()->after('ethnicity');
            
            // Add 'other_religion' column after 'religion'
            $table->string('other_religion', 50)->nullable()->after('religion');
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
            // Drop 'other_ethnicity' column
            $table->dropColumn('other_ethnicity');
            
            // Drop 'other_religion' column
            $table->dropColumn('other_religion');
        });
    }
}
