<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Log;

class FixDataTypeSizesRiskFormTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            Schema::table('risk_form', function (Blueprint $table) {
                // Check if the column 'rf_tobbaco_use' exists before renaming it
                if (Schema::hasColumn('risk_form', 'rf_tobbaco_use')) {
                    // Rename the column 'rf_tobbaco_use' to 'rf_tobacco_use'
                    $table->renameColumn('rf_tobbaco_use', 'rf_tobacco_use');
                }
    
                // Adjust the size of 'rf_tobacco_use' to varchar(8)
                if (Schema::hasColumn('risk_form', 'rf_tobacco_use')) {
                    $table->string('rf_tobacco_use', 8)->change();
                }
    
                // Define the columns that should be varchar(8)
                $varchar8Columns = [
                    'rf_alcohol_intake',
                    'rf_alcohol_binge_drinker',
                    'rf_physical_activity',
                    'rf_nutrition_dietary',
                ];
    
                // Define the columns that should be varchar(20)
                $varchar20Columns = [
                    'fmh_hypertension',
                    'fmh_stroke',
                    'fmh_heart_disease',
                    'fmh_diabetes_mellitus',
                    'fmh_asthma',
                    'fmh_cancer',
                    'fmh_kidney_disease',
                    'fmh_first_degree_relative',
                    'fmh_having_tuberculosis_5_years',
                    'fmh_mn_and_s_disorder',
                    'fmh_copd',
                ];
    
                // Adjust the size of varchar(8) columns if they exist
                foreach ($varchar8Columns as $column) {
                    if (Schema::hasColumn('risk_form', $column)) {
                        $table->string($column, 8)->change();
                    }
                }
    
                // Adjust the size of varchar(20) columns if they exist
                foreach ($varchar20Columns as $column) {
                    if (Schema::hasColumn('risk_form', $column)) {
                        $table->string($column, 20)->change();
                    }
                }
            });
        } catch (Exception $e) {
            Log::error('Failed to adjust column sizes in risk_form table: ' . $e->getMessage());
            throw $e; // Rethrow the exception to halt the migration
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        try {
            Schema::table('risk_form', function (Blueprint $table) {
                // Check if the renamed column exists and rename it back to the original name
                if (Schema::hasColumn('risk_form', 'rf_tobacco_use')) {
                    $table->renameColumn('rf_tobacco_use', 'rf_tobbaco_use');
                }

                // Reverse varchar(8) columns
                $varchar8Columns = [
                    'rf_alcohol_intake',
                    'rf_alcohol_binge_drinker',
                    'rf_physical_activity',
                    'rf_nutrition_dietary',
                ];

                // Reverse varchar(20) columns
                $varchar20Columns = [
                    'fmh_hypertension',
                    'fmh_stroke',
                    'fmh_heart_disease',
                    'fmh_diabetes_mellitus',
                    'fmh_asthma',
                    'fmh_cancer',
                    'fmh_kidney_disease',
                    'fmh_first_degree_relative',
                    'fmh_having_tuberculosis_5_years',
                    'fmh_mn_and_s_disorder',
                    'fmh_copd',
                ];

                // Adjust the varchar(8) columns back to varchar(255) if they exist
                foreach ($varchar8Columns as $column) {
                    if (Schema::hasColumn('risk_form', $column)) {
                        $table->string($column, 255)->change(); // Change to default length
                    }
                }

                // Adjust the varchar(20) columns back to varchar(255) if they exist
                foreach ($varchar20Columns as $column) {
                    if (Schema::hasColumn('risk_form', $column)) {
                        $table->string($column, 255)->change(); // Change to default length
                    }
                }
            });
        } catch (\Exception $e) {
            Log::error('Failed to reverse column size changes in risk_form table: ' . $e->getMessage());
            throw $e; // Rethrow the exception to halt the migration
        }
    }
}
