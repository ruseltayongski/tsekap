<?php

use Illuminate\Database\Seeder;

class caseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('cases')->insert(['description' => 'Other Acute Upper Respiratory Infection']);
        DB::table('cases')->insert(['description' => 'Essential (Primary) Hypertension']);
        DB::table('cases')->insert(['description' => 'Fever of Unknown Origin']);
        DB::table('cases')->insert(['description' => 'Other Injuries of Specified, Unspecified and Multiple Body Regions']);
        DB::table('cases')->insert(['description' => 'Bronchitis, Emphysema and Other Chronic Obstructive Pulmonary Diseases']);
        DB::table('cases')->insert(['description' => 'Diarrhea and Gastroenteritis of Presumed Infectious Origin']);
        DB::table('cases')->insert(['description' => 'Dermatoses']);
        DB::table('cases')->insert(['description' => 'Pneumonia']);
        DB::table('cases')->insert(['description' => 'Infections of the Genitourinary System']);
        DB::table('cases')->insert(['description' => 'Animal Bite']);
        DB::table('cases')->insert(['description' => 'Others']);
    }
}
