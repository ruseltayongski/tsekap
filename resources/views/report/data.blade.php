<?php
use App\Bracket;
use App\Cases;
use App\Service;
use \App\Http\Controllers\LocationCtrl;
use App\Http\Controllers\UserCtrl;

header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=".$filename.".xls");
header("Pragma: no-cache");
header("Expires: 0");

$table_body = "
    <div class='col-md-12' style='white-space: nowrap; background-color: lightgoldenrodyellow'>
        <h3>TARGET (TOTAL): ".number_format($total_target)."&emsp;&emsp;
        PROFILED (TOTAL): ".number_format($total_profiled)."&emsp;&emsp;
        PERCENTAGE: ".$total_percentage." % </h3>
    </div>
";

$table_body .='
    <div class="col-md-12" style="white-space: nowrap;">
        <h3>PROFILES</h3>
    </div>
    <table cellspacing="1" cellpadding="5" border="1" width="150%">
        <tr style="background-color: lightgreen; text-align: center">
            <th> FAMILY ID </th>
            <th> HEAD </th>
            <th> RELATION TO HEAD </th>
            <th> FIRST NAME </th>
            <th> MIDDLE NAME </th>
            <th> LAST NAME </th>
            <th> SUFFIX </th>
            <th> BIRTHDAY </th>
            <th> SEX </th>
            <th> BARANGAY </th>
            <th> MUNICIPAL / CITY </th>
            <th> PROVINCE </th>
            <th> ENCODED BY </th>
            <th> DATE ENCODED </th>
            <th> UPDATED BY </th>
            <th> DATE UPDATED </th>
        </tr>
    ';

foreach($profile as $row) {
    $table_body .= '
        <tr>
            <td>'.$row->familyID.'</td>
            <td style="text-align:center">'.$row->head.'</td>
            <td style="text-align:center">'.$row->relation.'</td>
            <td>'.$row->fname.'</td>
            <td>'.$row->mname.'</td>
            <td>'.$row->lname.'</td>
            <td>'.$row->suffix.'</td>
            <td style="text-align:center">'.$row->dob.'</td>
            <td style="text-align:center">'.$row->sex.'</td>
            <td style="text-align:center">'.LocationCtrl::getBarangay($row->barangay_id).'</td>
            <td style="text-align:center">'.LocationCtrl::getMuncity($row->muncity_id).'</td>
            <td style="text-align:center">'.LocationCtrl::getProvince($row->province_id).'</td>';

    $encoder = explode('-', $row->familyID);
    $encoded_by = UserCtrl::getUser($encoder[1]);
    $updated_by = UserCtrl::getUser($row->updated_by);
    $encoder_name = isset($encoded_by) ? $encoded_by->fname." ".$encoded_by->lname : "User Deactivated";
    $editor_name= isset($updated_by) ? $updated_by->fname." ".$updated_by->lname : "";
    $date_created = date('M d, Y',strtotime($row->created_at));
    $date_updated = date('M d, Y',strtotime($row->updated_at));
    $date_created = ($date_created != 'Nov 30, -0001') ? $date_created : '';
    $date_updated = ($date_updated != 'Nov 30, -0001') ? $date_updated : '';

    $table_body .= '
            <td style="text-align: center;">'.$encoder_name.'</td>
            <td style="text-align: center;">'.$date_created.'</td>
            <td style="text-align: center;">'.$editor_name.'</td>
            <td style="text-align: center;">'.$date_updated.'</td>
        </tr>
    ';
}

$table_body .= '</table><br><br>';

$table_body .='
    <div class="col-md-12" style="white-space: nowrap;">
        <h3> SERVICES </h3>
    </div>
    <table cellspacing="1" cellpadding="5" border="1" width="150%">
        <tr style="background-color: lightgreen; text-align: center;">
            <th> DATE CREATED </th>
            <th> FIRST NAME </th>
            <th> MIDDLE NAME </th>
            <th> LAST NAME </th>
            <th> SUFFIX </th>
            <th> SERVICE </th>
            <th> BRACKET </th>
            <th> BARANGAY </th>
            <th> MUNICIPAL / CITY </th>
        </tr>
    ';

foreach($profileservices as $row) {
    $table_body .= '
        <tr>
            <td style="text-align: center">'.$row->dateProfile.'</td>
            <td>'.$row->fname.'</td>
            <td>'.$row->mname.'</td>
            <td>'.$row->lname.'</td>
            <td>'.$row->suffix.'</td>
            <td style="text-align:center">'.Service::find($row->service_id)->description.'</td>
            <td style="text-align:center">'.Bracket::find($row->bracket_id)->description.'</td>
            <td style="text-align:center">'.LocationCtrl::getBarangay($row->barangay_id).'</td>
            <td style="text-align:center">'.LocationCtrl::getMuncity($row->muncity_id).'</td>
        </tr>
    ';
}
$table_body .= '</table><br><br>';

$table_body .='
    <div class="col-md-12" style="white-space: nowrap;">
        <h3> CASES </h3>
    </div>
    <table cellspacing="1" cellpadding="5" border="1" width="150%">
        <tr style="background-color: lightgreen; text-align: center">
            <th style="text-align: left"> DATE CREATED </th>
            <th> FIRST NAME </th>
            <th> MIDDLE NAME </th>
            <th> LAST NAME </th>
            <th> SUFFIX </th>
            <th> CASE </th>
            <th> BRACKET </th>
            <th> BARANGAY </th>
            <th> MUNICIPAL / CITY </th>
        </tr>
    ';

foreach($profilecases as $row) {
    $table_body .= '
        <tr>
            <td style="text-align: center">'.$row->dateProfile.'</td>
            <td>'.$row->fname.'</td>
            <td>'.$row->mname.'</td>
            <td>'.$row->lname.'</td>
            <td>'.$row->suffix.'</td>
            <td style="text-align:center">'.Cases::find($row->case_id)->description.'</td>
            <td style="text-align:center">'.Bracket::find($row->bracket_id)->description.'</td>
            <td style="text-align:center">'.LocationCtrl::getBarangay($row->barangay_id).'</td>
            <td style="text-align:center">'.LocationCtrl::getMuncity($row->muncity_id).'</td>
        </tr>
    ';
}
$table_body .= '</table><br><br>';

//$table_body .='
//    <div class="col-md-12" style="white-space: nowrap;">
//        <h3> STATUS </h3>
//    </div>
//    <table cellspacing="1" cellpadding="5" border="1" width="150%">
//        <tr style="background-color: lightgreen">
//            <th> DATE CREATED </th>
//            <th> FIRST NAME </th>
//            <th> MIDDLE NAME </th>
//            <th> LAST NAME </th>
//            <th> SUFFIX </th>
//            <th> STATUS </th>
//            <th> CODE </th>
//            <th> BARANGAY </th>
//            <th> MUNICIPAL / CITY </th>
//        </tr>
//    ';
//
//foreach($status1 as $row) {
//    $code = Service::find($row->service_id);
//    if($code){
//        $code = $code->code;
//    }else{
//        $code=null;
//    }
//    $table_body .= '
//        <tr>
//            <td>'.$row->dateProfile.'</td>
//            <td>'.$row->fname.'</td>
//            <td>'.$row->mname.'</td>
//            <td>'.$row->lname.'</td>
//            <td>'.$row->suffix.'</td>
//            <td>'.$row->status.'</td>
//            <td>'.$code.'</td>
//            <td style="text-align:center">'.LocationCtrl::getBarangay($row->barangay_id).'</td>
//            <td style="text-align:center">'.LocationCtrl::getMuncity($row->muncity_id).'</td>
//        </tr>
//    ';
//}
//
//foreach($status2 as $row){
//    $code = 'case-'.$row->case_id;
//    $table_body .= '
//        <tr>
//            <td>'.$row->dateProfile.'</td>
//            <td>'.$row->fname.'</td>
//            <td>'.$row->mname.'</td>
//            <td>'.$row->lname.'</td>
//            <td>'.$row->suffix.'</td>
//            <td>'.$row->status.'</td>
//            <td>'.$code.'</td>
//            <td style="text-align:center">'.LocationCtrl::getBarangay($row->barangay_id).'</td>
//            <td style="text-align:center"'.LocationCtrl::getMuncity($row->muncity_id).'</td>
//        </tr>
//    ';
//}
//
//$table_body .= '</table><br><br>';

$table_body .='
    <div class="col-md-12" style="white-space: nowrap;">
        <h3> SERVICE OPTION </h3>
    </div>
    <table cellspacing="1" cellpadding="5" border="1" width="150%">
        <tr style="background-color: lightgreen; text-align: center">
            <th style="text-align: left"> DATE CREATED </th>
            <th> FIRST NAME </th>
            <th> MIDDLE NAME </th>
            <th> LAST NAME </th>
            <th> SUFFIX </th>
            <th> OPTION </th>
            <th> STATUS </th>
            <th> BARANGAY </th>
            <th> MUNICIPAL / CITY </th>
        </tr>
    ';

foreach($serviceoption as $row) {
    $table_body .= '
        <tr>
            <td style="text-align: center">'.$row->dateProfile.'</td>
            <td>'.$row->fname.'</td>
            <td>'.$row->mname.'</td>
            <td>'.$row->lname.'</td>
            <td>'.$row->suffix.'</td>
            <td style="text-align: center">'.$row->option.'</td>
            <td style="text-align: center">'.$row->status.'</td>
            <td style="text-align:center">'.LocationCtrl::getBarangay($row->barangay_id).'</td>
            <td style="text-align:center">'.LocationCtrl::getMuncity($row->muncity_id).'</td>
        </tr>
    ';
}
$table_body .= '</table><br><br>';

echo $table_body;