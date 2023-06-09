<?php
use \App\Http\Controllers\LocationCtrl;
use App\Http\Controllers\UserCtrl;
use \App\Http\Controllers\ParameterCtrl;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename.".xls");
header("Pragma: no-cache");
header("Expires: 0");

$table_body .='
    <table border="1px solid black">
        <tr style="background-color: #ffe598; text-align: center">
            <th rowspan="2">Date of Visit <br>(yyyy-mm-dd)</th>
            <th rowspan="2">HouseHold No.<br>(yyyymm-Facility Code-No.)</th>
            <th rowspan="2">Barangay</th>
            <th rowspan="2">No. of Family/ies in the HH</th>
            <th colspan="3">Name of Household Members</th>
            <th rowspan="2">Relationship to the HH Head</th>
            <th rowspan="2">If Other; <br> Please Specify</th>
            <th>Date of Birth</th>
            <th rowspan="2">Age in Years and Months</th>
            <th rowspan="2">Sex</th>
            <th rowspan="2">Civil Status</th>
            <th rowspan="2">Educational Attainment</th>
            <th rowspan="2">Religion</th>
            <th>Ethnicity</th>
            <th>4Ps Member</th>
            <td rowspan="2">If yes; <br>Indicate 4Ps Number</td>
            <th rowspan="2">Philhealth Category</th>
            <th rowspan="2">Philhealth Number</th>
            <th rowspan="2">Medical History</th>
            <td rowspan="2">If others; <br> Please Specify</td>
            <th rowspan="2">Classification by Age/Health Risk Group</th>
            <th rowspan="2">If Pregnant; Last Menstrual Period (LMP)</th>
            <th colspan="4">If Women of Reproductive Age (WRA)</th>
            <th rowspan="2">Type of Water Source</th>
            <th rowspan="2">Type of Toilet Facility</th>
        </tr>
        <tr style="background-color: #ffe598; text-align: center">
            <td>Last Name</td>
            <td>First Name</td>
            <td>Middle Name</td>
            <td>yyyy-mm-dd</td>
            <td>IP or Non-IP</td>
            <td>Yes or No</td>
            <td>Using any FP methods?</td>
            <td>FP Methods Used</td>
            <td>If others; Please Specify</td>
            <td>FP Status</td>
        </tr>
    ';


foreach($profile as $row) {
    $age = ParameterCtrl::getAge($row->dob);
    $month = ParameterCtrl::getAgeMonth($row->dob);
    $rel = ParameterCtrl::getRelation($row->relation, $row->member_others);
    $table_body .= '
        <tr style="text-align: center;">
            <td></td>
            <td>'.$row->household_num.'</td>
            <td>'.$row->barangay.'</td>
            <td></td>
            <td>'.$row->lname.'</td>
            <td>'.$row->fname.'</td>
            <td>'.$row->mname.'</td>
            <td>'.$rel['relation'].'</td>
            <td>'.$rel['other'].'</td>
            <td>'.$row->birthdate.'</td>
            <td>'.$age.' Years, '.$month.' Months</td>
            <td>'.$row->sex.'</td>';

    $ip = (isset($rel->ip) && $rel->ip=='yes')?'IP':"Non-IP";
    $four_ps = (isset($rel->ip) && $rel->ip=='yes')?'Yes':'No';
    $fourps_num = ($four_ps == 'Yes') ? $row->fourps_num : '';
    $phil_num = (isset($row->phicID)) ? $row->phicID : "";

    $table_body .= '
            <td>'.ParameterCtrl::getCivilStatus($row->civil_status).'</td>
            <td>'.ParameterCtrl::getEducation($row->education).'</td>
            <td>'.ParameterCtrl::getReligion($row->religion, $row->other_religion).'</td>
            <td>'.$ip.'</td>
            <td>'.$four_ps.'</td>
            <td>'.$fourps_num.'</td>
            <td>'.ParameterCtrl::getPhilhealthCateg($row->philhealth_categ).'</td>
            <td>'.$phil_num.'</td>';

    $med = '';
    $other_medi = "";
    $other_med = isset($row->other_med_history) ? $row->other_med_history : '';
    if(count($row->medication) > 0) {
        foreach($row->medication as $medi) {
            if($medi->description == 'Hypertension')
                $med .= "HPN ";
            else if($medi->description == 'Diabetic')
                $med .= "DM ";
            else if($medi->description == 'TB Medication')
                $med .= 'TB ';
            else {
                $med .= 'Others, Pls Specify';
                $other_med .= $medi->description.", ";
            }
        }
    }

    $pregnant = (isset($row->pregnant) && $row->pregnant != '0000-00-00') ? $row->pregnant : '';
    $fp_method = ($row->fam_plan_method == 'other') ? "Others (Pls. Specify)" : $row->fam_plan_method;
    $fp_status = ($row->fam_plan_status == 'other') ? $row->fam_plan_other_status : $row->fam_plan_status;
    $wt = ParameterCtrl::getWaterAndToilet($row->familyID);

    $table_body .= '
            <td>'.$med.'</td>
            <td>'.$other_medi." ".$other_med.'</td>
            <td>'.ParameterCtrl::getHealthRisk($row->health_group).'</td>
            <td>'.$pregnant.'</td>
            <td>'.ucfirst($row->fam_plan).'</td>
            <td>'.$fp_method.'</td>
            <td>'.$row->fam_plan_other_method.'</td>
            <td>'.$fp_status.'</td>
            <td>'.$wt['water'].'</td>
            <td>'.$wt['toilet'].'</td>';
}
$table_body .= '</table><br><br>';

echo $table_body;