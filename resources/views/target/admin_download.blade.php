<?php
header("Content-Type: application/xls");
header("Content-Disposition: attachment; filename=".$filename.".xls");
header("Pragma: no-cache");
header("Expires: 0");

$prov_percentage = ($prov_profiled / $prov_target) * 100;

$table_body ='
    <div class="col-md-12" style="white-space: nowrap;">
        <h3>Summary of Target and Profiled Population</h3>
    </div>
    <table cellspacing="1" cellpadding="5" border="1" width="150%">
        <tr>
            <td style="background-color: aquamarine"> Province </td>
            <td style="background-color: aquamarine"> Target </td>
            <td style="background-color: aquamarine"> Profiled </td>
            <td style="background-color: aquamarine"> Percentage </td>
        </tr>
        <tr class="col-md-3">
            <td> '.$prov_desc.'</td>
            <td> '.number_format($prov_target).'</td>
            <td> '.number_format($prov_profiled).'</td>
            <td> '.number_format($prov_percentage, 1).' % </td>
    </table><br>
    ';

$table_body .= '
    <table cellspacing="1" cellpadding="5" border="1">
        <tr>
            <td style="background-color: darkseagreen"> Municipality </td>
            <td style="background-color: darkseagreen"> Target </td>
            <td style="background-color: darkseagreen"> Profiled </td>
            <td style="background-color: darkseagreen"> Percentage </td>
        </tr>';
foreach($muncity_list as $mun) {
    $table_body .= '<tr>
            <td> '.$mun[1].'</td>
            <td> '.number_format($mun[2]).'</td>
            <td> '.number_format($mun[3]).'</td>';
    $mun_percentage = ($mun[3] / $mun[2]) * 100;
    $table_body .= '
            <td> '.number_format($mun_percentage, 1).' % </td>
        </tr>';
}
$table_body .= '</table><br>';

if(count($barangay_list) > 0) {
    $table_body .= '
    <table cellspacing="1" cellpadding="5" border="1">
        <tr>
            <td style="background-color: lightblue"> Barangay </td>
            <td style="background-color: lightblue"> Target </td>
            <td style="background-color: lightblue"> Profiled </td>
            <td style="background-color: lightblue"> Percentage </td>
        </tr>';
    foreach($barangay_list as $bar) {
        $table_body .= '<tr>
            <td> '.$bar[1].'</td>
            <td> '.number_format($bar[2]).'</td>
            <td> '.number_format($bar[3]).'</td>';
        $bar_percentage = ($bar[3] / $bar[2]) * 100;
        $table_body .= '
            <td> '.number_format($bar_percentage, 1).' % </td>
        </tr>';
    }
    $table_body .= '</table><br>';
}

echo $table_body;