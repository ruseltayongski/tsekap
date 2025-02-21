<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewFhColumnsToRiskAssessment extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('risk_form', function (Blueprint $table) {
            $table->string('fm_sideHypertension')->nullable()->after('fm_hypertension');
            $table->string('fm_sideStroke')->nullable()->after('fm_stroke');
            $table->string('fm_sideHeartDisease')->nullable()->after('fm_heartDisease');
            $table->string('fm_sideDiabetesMellitus')->nullable()->after('fm_diabetesMel');
            $table->string('fm_sideAsthma')->nullable()->after('fm_asthma');
            $table->string('fm_sideCancer')->nullable()->after('fm_cancer');
            $table->string('fm_sideKidneyDisease')->nullable()->after('fm_kidneyDisease');
            $table->string('fm_sideCoronaryDisease')->nullable()->after('fm_firstDegreRelative');
            $table->string('fm_sideTuberculosis')->nullable()->after('fm_havingTB5years');
            $table->string('fm_sideDisorders')->nullable()->after('fm_MNandSDisorder');
            $table->string('fm_sideCOPD')->nullable()->after('fm_COPD');
            // Add additional columns as needed
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
            $table->dropColumn([
                'fm_sideHypertension',
                'fm_sideStroke', 
                'fm_sideHeartDisease',
                'fm_sideDiabetesMellitus',
                'fm_sideAsthma',
                'fm_sideCancer',
                'fm_sideKidneyDisease',
                'fm_sideCoronaryDisease',
                'fm_sideTuberculosis',
                'fm_sideDisorders',
                'fm_sideCOPD'
            ]);
        });
    }
}
