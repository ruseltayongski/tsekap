<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

class RemoveColumnsFromRiskForm extends Migration
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
                $columnsToDrop = [
                    'fmh_side_hypertension',
                    'fmh_side_stroke',
                    'fmh_side_heart_disease',
                    'fmh_side_diabetes_mellitus',
                    'fmh_side_asthma',
                    'fmh_side_cancer',
                    'fmh_side_kidney_disease',
                    'fmh_side_coronary_disease',
                    'fmh_side_tuberculosis',
                    'fmh_side_disorders',
                ];

                foreach ($columnsToDrop as $column) {
                    if (Schema::hasColumn('risk_form', $column)) {
                        $table->dropColumn($column);
                    }
                }
            });
        } catch (Exception $e) {
            Log::error('Failed to drop columns from risk_form table: ' . $e->getMessage());
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
                $columnsToAdd = [
                    'fmh_side_hypertension' => 'fmh_hypertension',
                    'fmh_side_stroke' => 'fmh_stroke',
                    'fmh_side_heart_disease' => 'fmh_heart_disease',
                    'fmh_side_diabetes_mellitus' => 'fmh_diabetes_mellitus',
                    'fmh_side_asthma' => 'fmh_asthma',
                    'fmh_side_cancer' => 'fmh_cancer',
                    'fmh_side_kidney_disease' => 'fmh_kidney_disease',
                    'fmh_side_coronary_disease' => 'fmh_first_degree_relative',
                    'fmh_side_tuberculosis' => 'fmh_having_tuberculosis_5_years',
                    'fmh_side_disorders' => 'fmh_mn_and_s_disorder',
                ];

                foreach ($columnsToAdd as $column => $afterColumn) {
                    if (!Schema::hasColumn('risk_form', $column)) {
                        $table->string($column)->after($afterColumn);
                    }
                }
            });
        } catch (Exception $e) {
            Log::error('Failed to add columns back to risk_form table: ' . $e->getMessage());
            throw $e; // Rethrow the exception to halt the rollback
        }
    }
}

