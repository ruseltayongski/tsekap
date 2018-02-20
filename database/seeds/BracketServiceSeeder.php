<?php

use Illuminate\Database\Seeder;

class BracketServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('services')->insert([ 'id' => '1', 'code' => 'BP', 'description' => 'Blood Pressure' ]);
        DB::table('services')->insert([ 'id' => '2', 'code' => 'WM', 'description' => 'Weight Measurement' ]);
        DB::table('services')->insert([ 'id' => '3', 'code' => 'HM', 'description' => 'Height Measurement' ]);
        DB::table('services')->insert([ 'id' => '4', 'code' => 'BT', 'description' => 'Blood Typing' ]);
        DB::table('services')->insert([ 'id' => '5', 'code' => 'CBC', 'description' => 'Complete Blood Count' ]);
        DB::table('services')->insert([ 'id' => '6', 'code' => 'URI', 'description' => 'Urinalysis' ]);
        DB::table('services')->insert([ 'id' => '7', 'code' => 'FBS', 'description' => 'Fasting Blood Sugar' ]);
        DB::table('services')->insert([ 'id' => '8', 'code' => 'SE', 'description' => 'Stool Examination' ]);
        DB::table('services')->insert([ 'id' => '9', 'code' => 'EE', 'description' => 'Eye Exam' ]);
        DB::table('services')->insert([ 'id' => '10', 'code' => 'ERE', 'description' => 'Ear Exam' ]);
        DB::table('services')->insert([ 'id' => '11', 'code' => 'PE', 'description' => 'Physical Exam' ]);
        DB::table('services')->insert([ 'id' => '12', 'code' => 'OS', 'description' => 'Oral Services' ]);
        DB::table('services')->insert([ 'id' => '13', 'code' => 'HEPS', 'description' => 'Health Education and Promotion Services' ]);
        DB::table('services')->insert([ 'id' => '15', 'code' => 'WUN', 'description' => 'With Unmet Need' ]);
        DB::table('services')->insert([ 'id' => '16', 'code' => 'CNL', 'description' => 'Counseling' ]);
        DB::table('services')->insert([ 'id' => '17', 'code' => 'CMD', 'description' => 'Commodities' ]);
        DB::table('services')->insert([ 'id' => '18', 'code' => 'OB', 'description' => 'Obese' ]);
        DB::table('services')->insert([ 'id' => '21', 'code' => 'SC', 'description' => 'Screening' ]);
        DB::table('services')->insert([ 'id' => '22', 'code' => 'CNS', 'description' => 'Drug Counseling' ]);
        DB::table('services')->insert([ 'id' => '23', 'code' => 'DT', 'description' => 'Drug Testing' ]);
        DB::table('services')->insert([ 'id' => '24', 'code' => 'RR', 'description' => 'Referral' ]);
        DB::table('services')->insert([ 'id' => '25', 'code' => 'BST', 'description' => 'Blood Sugar Test' ]);

        DB::table('brackets')->insert([ 'id' => '1', 'description' => 'New Born 0-28 Days' ]);
        DB::table('brackets')->insert([ 'id' => '2', 'description' => 'Infant 29 Days - 11 Months' ]);
        DB::table('brackets')->insert([ 'id' => '3', 'description' => 'Child 1-5 Years Old' ]);
        DB::table('brackets')->insert([ 'id' => '4', 'description' => 'Child 6-9 Years Old' ]);
        DB::table('brackets')->insert([ 'id' => '5', 'description' => 'Adolescent 10-19 Years Old' ]);
        DB::table('brackets')->insert([ 'id' => '6', 'description' => 'Adult 20-49 Years Old' ]);
        DB::table('brackets')->insert([ 'id' => '7', 'description' => 'Adult 50-59 Years Old' ]);
        DB::table('brackets')->insert([ 'id' => '8', 'description' => 'Adult 60 Years Above' ]);

        DB::table('bracketservices')->insert([ 'id' => '8', 'bracket_id' => '5', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '9', 'bracket_id' => '5', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '16', 'bracket_id' => '2', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '17', 'bracket_id' => '2', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '19', 'bracket_id' => '1', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '20', 'bracket_id' => '1', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '21', 'bracket_id' => '3', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '22', 'bracket_id' => '1', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '23', 'bracket_id' => '3', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '26', 'bracket_id' => '4', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '27', 'bracket_id' => '4', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '31', 'bracket_id' => '1', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '32', 'bracket_id' => '1', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '33', 'bracket_id' => '1', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '34', 'bracket_id' => '1', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '35', 'bracket_id' => '2', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '36', 'bracket_id' => '2', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '37', 'bracket_id' => '2', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '38', 'bracket_id' => '2', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '39', 'bracket_id' => '2', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '40', 'bracket_id' => '2', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '41', 'bracket_id' => '2', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '42', 'bracket_id' => '3', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '43', 'bracket_id' => '3', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '44', 'bracket_id' => '3', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '45', 'bracket_id' => '3', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '46', 'bracket_id' => '3', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '47', 'bracket_id' => '3', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '48', 'bracket_id' => '3', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '49', 'bracket_id' => '3', 'service_id' => '12' ]);
        DB::table('bracketservices')->insert([ 'id' => '50', 'bracket_id' => '3', 'service_id' => '13' ]);
        DB::table('bracketservices')->insert([ 'id' => '51', 'bracket_id' => '4', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '52', 'bracket_id' => '4', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '53', 'bracket_id' => '4', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '54', 'bracket_id' => '4', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '55', 'bracket_id' => '4', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '56', 'bracket_id' => '4', 'service_id' => '12' ]);
        DB::table('bracketservices')->insert([ 'id' => '57', 'bracket_id' => '4', 'service_id' => '13' ]);
        DB::table('bracketservices')->insert([ 'id' => '58', 'bracket_id' => '5', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '59', 'bracket_id' => '5', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '60', 'bracket_id' => '5', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '61', 'bracket_id' => '5', 'service_id' => '1' ]);
        DB::table('bracketservices')->insert([ 'id' => '62', 'bracket_id' => '5', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '63', 'bracket_id' => '5', 'service_id' => '7' ]);
        DB::table('bracketservices')->insert([ 'id' => '64', 'bracket_id' => '5', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '65', 'bracket_id' => '5', 'service_id' => '15' ]);
        DB::table('bracketservices')->insert([ 'id' => '66', 'bracket_id' => '5', 'service_id' => '16' ]);
        DB::table('bracketservices')->insert([ 'id' => '67', 'bracket_id' => '5', 'service_id' => '17' ]);
        DB::table('bracketservices')->insert([ 'id' => '68', 'bracket_id' => '5', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '69', 'bracket_id' => '5', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '70', 'bracket_id' => '5', 'service_id' => '13' ]);
        DB::table('bracketservices')->insert([ 'id' => '72', 'bracket_id' => '6', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '73', 'bracket_id' => '6', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '74', 'bracket_id' => '6', 'service_id' => '1' ]);
        DB::table('bracketservices')->insert([ 'id' => '75', 'bracket_id' => '6', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '76', 'bracket_id' => '6', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '77', 'bracket_id' => '6', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '78', 'bracket_id' => '6', 'service_id' => '7' ]);
        DB::table('bracketservices')->insert([ 'id' => '79', 'bracket_id' => '6', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '80', 'bracket_id' => '6', 'service_id' => '15' ]);
        DB::table('bracketservices')->insert([ 'id' => '81', 'bracket_id' => '6', 'service_id' => '16' ]);
        DB::table('bracketservices')->insert([ 'id' => '82', 'bracket_id' => '6', 'service_id' => '17' ]);
        DB::table('bracketservices')->insert([ 'id' => '83', 'bracket_id' => '6', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '84', 'bracket_id' => '6', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '85', 'bracket_id' => '6', 'service_id' => '12' ]);
        DB::table('bracketservices')->insert([ 'id' => '86', 'bracket_id' => '6', 'service_id' => '13' ]);
        DB::table('bracketservices')->insert([ 'id' => '87', 'bracket_id' => '7', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '88', 'bracket_id' => '7', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '89', 'bracket_id' => '7', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '90', 'bracket_id' => '7', 'service_id' => '1' ]);
        DB::table('bracketservices')->insert([ 'id' => '91', 'bracket_id' => '7', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '92', 'bracket_id' => '7', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '94', 'bracket_id' => '7', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '95', 'bracket_id' => '7', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '96', 'bracket_id' => '7', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '97', 'bracket_id' => '7', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '98', 'bracket_id' => '7', 'service_id' => '12' ]);
        DB::table('bracketservices')->insert([ 'id' => '99', 'bracket_id' => '8', 'service_id' => '11' ]);
        DB::table('bracketservices')->insert([ 'id' => '100', 'bracket_id' => '8', 'service_id' => '3' ]);
        DB::table('bracketservices')->insert([ 'id' => '101', 'bracket_id' => '7', 'service_id' => '13' ]);
        DB::table('bracketservices')->insert([ 'id' => '102', 'bracket_id' => '8', 'service_id' => '2' ]);
        DB::table('bracketservices')->insert([ 'id' => '103', 'bracket_id' => '8', 'service_id' => '1' ]);
        DB::table('bracketservices')->insert([ 'id' => '104', 'bracket_id' => '8', 'service_id' => '5' ]);
        DB::table('bracketservices')->insert([ 'id' => '105', 'bracket_id' => '8', 'service_id' => '4' ]);
        DB::table('bracketservices')->insert([ 'id' => '107', 'bracket_id' => '8', 'service_id' => '6' ]);
        DB::table('bracketservices')->insert([ 'id' => '108', 'bracket_id' => '8', 'service_id' => '8' ]);
        DB::table('bracketservices')->insert([ 'id' => '109', 'bracket_id' => '8', 'service_id' => '9' ]);
        DB::table('bracketservices')->insert([ 'id' => '110', 'bracket_id' => '8', 'service_id' => '10' ]);
        DB::table('bracketservices')->insert([ 'id' => '111', 'bracket_id' => '8', 'service_id' => '12' ]);
        DB::table('bracketservices')->insert([ 'id' => '112', 'bracket_id' => '5', 'service_id' => '21' ]);
        DB::table('bracketservices')->insert([ 'id' => '113', 'bracket_id' => '5', 'service_id' => '22' ]);
        DB::table('bracketservices')->insert([ 'id' => '114', 'bracket_id' => '5', 'service_id' => '23' ]);
        DB::table('bracketservices')->insert([ 'id' => '115', 'bracket_id' => '5', 'service_id' => '24' ]);
        DB::table('bracketservices')->insert([ 'id' => '116', 'bracket_id' => '6', 'service_id' => '21' ]);
        DB::table('bracketservices')->insert([ 'id' => '117', 'bracket_id' => '6', 'service_id' => '22' ]);
        DB::table('bracketservices')->insert([ 'id' => '118', 'bracket_id' => '6', 'service_id' => '23' ]);
        DB::table('bracketservices')->insert([ 'id' => '119', 'bracket_id' => '6', 'service_id' => '24' ]);
        DB::table('bracketservices')->insert([ 'id' => '120', 'bracket_id' => '7', 'service_id' => '21' ]);
        DB::table('bracketservices')->insert([ 'id' => '121', 'bracket_id' => '7', 'service_id' => '22' ]);
        DB::table('bracketservices')->insert([ 'id' => '122', 'bracket_id' => '7', 'service_id' => '23' ]);
        DB::table('bracketservices')->insert([ 'id' => '123', 'bracket_id' => '7', 'service_id' => '24' ]);
        DB::table('bracketservices')->insert([ 'id' => '124', 'bracket_id' => '8', 'service_id' => '21' ]);
        DB::table('bracketservices')->insert([ 'id' => '125', 'bracket_id' => '8', 'service_id' => '22' ]);
        DB::table('bracketservices')->insert([ 'id' => '126', 'bracket_id' => '8', 'service_id' => '23' ]);
        DB::table('bracketservices')->insert([ 'id' => '127', 'bracket_id' => '8', 'service_id' => '24' ]);
        DB::table('bracketservices')->insert([ 'id' => '128', 'bracket_id' => '8', 'service_id' => '25' ]);
        DB::table('bracketservices')->insert([ 'id' => '129', 'bracket_id' => '7', 'service_id' => '25' ]);
        DB::table('bracketservices')->insert([ 'id' => '130', 'bracket_id' => '6', 'service_id' => '11' ]);
    }
}
