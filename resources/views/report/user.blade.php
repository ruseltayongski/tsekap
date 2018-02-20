<?php
$user = Auth::user();
use App\FamilyProfile;
use App\UserBrgy;
$username = 'LoginAccount-' .$user->username;
$filename = "Content-Disposition: attachment; filename=$username.DOH7";
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header($filename);

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
//fputcsv($output, array('Column 1', 'Column 2', 'Column 3'));
$user = Auth::user();
fputcsv($output, array('ACCOUNT'));
fputcsv($output, array($user->fname,$user->mname,$user->lname,$user->muncity,$user->province,$user->username,$user->username,sha1('jim-' .$user->user_priv),$user->id));

if($user->user_priv==2)
{
    $userBrgy = UserBrgy::where('user_id',$user->id)->get();
    fputcsv($output, array('BARANGAY'));
    foreach($userBrgy as $u)
    {
        fputcsv($output, array($u->barangay_id));
    }
}
