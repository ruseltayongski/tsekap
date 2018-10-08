<?php
session_start();
//$api = json_decode(file_get_contents('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']."/tsekap/vii/patient_api/191042"));
include('database.php');
//$dengvaxiaId = $_SESSION['dengvaxiaId'];
$dengvaxiaId = 191042;

$api = query_dengvaxia($dengvaxiaId);
$bar = barangay($api->barangay_id);
$mun = muncity($api->muncity_id);
$pro = province($api->province_id);
$bar ? $barangay = $bar->description : $barangay = "NO BARANGAY";
$mun ? $muncity = $mun->description : $muncity = "NO MUNICIPALITY";
$pro ? $province = $pro->description : $province = "NO PROVINCE";

$x = 15;
$y = 3;
$con_font_size = 7.5;
$box_content_w = 5;
$box_content_h = 5;
// Logo
$pdf->Image(__DIR__.'/../image/doh.png',30,$y,30);
$pdf->Image(__DIR__.'/../image/logo.png',240,$y,30);

$pdf->SetFont('Arial','B',15);

$box_w = 270;
$y+=3;
$pdf->SetXY(3,$y);
$pdf->Cell(0,0,'DEPARTMENT OF HEALTH',0,0,'C');

$y+=5;
$pdf->SetFont('Arial','B',12);
$pdf->SetXY(3,$y);
$pdf->Cell(0,0,'Epidemiology Bureau',0,0,'C');

$pdf->SetFont('Arial','IB',12);
$y+=13;
$pdf->SetXY(3,$y);
$pdf->Cell(0,0,'Dengvaxia Vaccinate Health Profile',0,0,'C');

$pdf->SetFont('Arial','B',$con_font_size,'B');
$y+=13;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'GENERAL INFORMATION:',0,0,'L');

$y+=2;
$pdf->SetXY($x,$y);
$pdf->Cell($box_w,40,'',1,0,'C');

$pdf->SetFont('Arial','',$con_font_size,'B');
$y+=2;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'Individual Vaccination Card:',0,0,'L');

$pdf->SetFont('Arial','',$con_font_size,'B');
$y+=5;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'Name of Vaccine:',0,0,'L');
$pdf->SetFont('Arial','',$con_font_size,'B');
$pdf->SetXY(40,$y);
$pdf->Cell(0,0,' ____________________________________________     ____________________________________________________________________     ________________________      ________________',0,0,'L');

$pdf->SetFont('Arial','',$con_font_size,'B');
$y+=4;
$pdf->SetXY(40,$y);
$pdf->Cell(0,0,'                                    (Last Name)                                                                                                 (First Name)                                                                          (Middle Name)                (Extension: Sr,Jr, Etc)',0,0,'L');

$y+=5;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'Relationship to Household Head:',0,0,'L');
$pdf->SetXY(55,$y);
$pdf->Cell(0,0,' ___________________________________________   Respondent: ______________________________________________________   Contact No. _____________________________',0,0,'L');

$y+=5;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'Address:',0,0,'L');
$pdf->SetXY(30,$y);
$pdf->Cell(0,0,' ________________________________________   _______________________________   ____________________________   ________________________________   ________________________________',0,0,'L');
$y+=4;
$pdf->SetXY(30,$y);
$pdf->Cell(0,0,'                   (House No. & Street Name)                                          (Sitio/Purok)                                            (Barangay)                                       (Municipality/City)                                             (Province)',0,0,'L');

$y+=5;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'Sex:',0,0,'L');
$pdf->SetXY(43,$y);
$pdf->Cell(0,0,'Male',0,0,'L');
$pdf->SetXY(38,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(63,$y);
$pdf->Cell(0,0,'Female',0,0,'L');
$pdf->SetXY(58,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(77,$y);
$pdf->Cell(0,0,'Age: __________ y/o',0,0,'L');

$pdf->SetXY(108,$y);
$pdf->Cell(0,0,'Religion:',0,0,'L');
$pdf->SetXY(130,$y);
$pdf->Cell(0,0,'RC',0,0,'L');
$pdf->SetXY(125,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(145,$y);
$pdf->Cell(0,0,'Christian',0,0,'L');
$pdf->SetXY(140,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(165,$y);
$pdf->Cell(0,0,'INC',0,0,'L');
$pdf->SetXY(160,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(180,$y);
$pdf->Cell(0,0,'Islam',0,0,'L');
$pdf->SetXY(175,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(197,$y);
$pdf->Cell(0,0,'Jehovah',0,0,'L');
$pdf->SetXY(192,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');

$pdf->SetXY(215,$y);
$pdf->Cell(0,0,'Others,specify:',0,0,'L');

$y+=7;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'Birthdate (mm/dd/yyyy):',0,0,'L');
$pdf->SetXY(75,$y);
$pdf->Cell(0,0,'Birthplace (Mun/City/Prov):',0,0,'L');
$pdf->SetXY(220,$y);
$pdf->Cell(0,0,'Yrs. at Current Address:',0,0,'L');

$pdf->SetFont('Arial','B',$con_font_size,'B');
$y+=6;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'LEVEL OF EDUCATION:',0,0,'L');

$y+=2;
$pdf->SetXY($x,$y);
$pdf->Cell($box_w,10,'',1,0,'C');

$y+=2;
$lvl_edu_x = 15;
$pdf->SetXY($lvl_edu_x,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$pdf->SetFont('Arial','',$con_font_size,'B');
$lvl_edu_x += 5;
$pdf->SetXY($lvl_edu_x,$y);
$pdf->Cell(0,0,'Elementary',0,0,'L');
$lvl_edu_x += 68;
$pdf->SetXY($lvl_edu_x,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$lvl_edu_x += 5;
$pdf->SetXY($lvl_edu_x,$y);
$pdf->Cell(0,0,'Vocational',0,0,'L');

$y+=5;
$lvl_edu_x = 15;
$pdf->SetXY($lvl_edu_x,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$lvl_edu_x += 5;
$pdf->SetXY($lvl_edu_x,$y);
$pdf->Cell(0,0,'High School',0,0,'L');
$lvl_edu_x += 68;
$pdf->SetXY($lvl_edu_x,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$lvl_edu_x += 5;
$pdf->SetXY($lvl_edu_x,$y);
$pdf->Cell(0,0,'No Completed Schooling',0,0,'L');

$pdf->SetFont('Arial','B',$con_font_size,'B');
$y+=7;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'PHIC MEMBERSHIP OF PRINCIPAL (PARENTS):',0,0,'L');

$y+=2;
$pdf->SetXY($x,$y);
$pdf->Cell($box_w,22,'',1,0,'C');

$y+=2;
$pdf->SetFont('Arial','',$con_font_size,'B');
$phic_mem = 16;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Status:',0,0,'L');
$phic_mem += 46;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Type:',0,0,'L');
$phic_mem += 12;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$pdf->SetXY(79,$y);
$pdf->Cell(0,0,'Lifetime:',0,0,'L');
$pdf->SetXY(173,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$pdf->SetXY(178,$y);
$pdf->Cell(0,0,'Employed:',0,0,'L');
$pdf->SetXY(210,$y);
$pdf->Cell(0,0,'Are you aware of your PHIC benefits?',0,0,'L');

$y+=5;
$phic_mem = 15;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Member',0,0,'L');
$phic_mem += 54;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Sponsored:',0,0,'L');
$phic_mem += 99;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Government:',0,0,'L');
$phic_mem += 28;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Yes',0,0,'L');
$phic_mem += 13;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'No',0,0,'L');

$y+=5;
$phic_mem = 15;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Dependent',0,0,'L');
$phic_mem += 59;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'DOH',0,0,'L');
$phic_mem += 10;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'PLGU',0,0,'L');
$phic_mem += 10;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'MLGU',0,0,'L');
$phic_mem += 11;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Private',0,0,'L');
$phic_mem += 48;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Private:',0,0,'L');
$phic_mem += 27;
$pdf->SetXY($phic_mem,$y+2);
$pdf->Cell(0,0,'If yes, specify: _____________________',0,0,'L');

$y+=5;
$phic_mem = 15;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Non-Member',0,0,'L');
$phic_mem += 59;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y+2);
$pdf->Cell(0,0,'Others, specify: __________________',0,0,'L');
$phic_mem += 94;
$pdf->SetXY($phic_mem,$y-2);
$pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
$phic_mem += 5;
$pdf->SetXY($phic_mem,$y);
$pdf->Cell(0,0,'Self-Employed:',0,0,'L');


$pdf->SetFont('Arial','B',$con_font_size,'B');
$y+=8;
$pdf->SetXY($x,$y);
$pdf->Cell(0,0,'FAMILY HISTORY :',0,0,'L');
$pdf->SetFont('Arial','I',$con_font_size,'B');
$pdf->SetXY(40,$y);
$pdf->Cell(0,0,'(Among mother,father, and siblings. Tick all that apply.) :',0,0,'L');

$y+=2;
$pdf->SetXY($x,$y);
$pdf->Cell($box_w,23,'',1,0,'C');
$pdf->SetFont('Arial','',$con_font_size,'B');
$fam_his_x = 15;
$fam_his_y = $y;
$fam_content = [
    [
        'Ailergy, specify:______________________________________',
        'Ashma',
        'Cancer, specify organ: ________________________________',
        'Immune Deficiency Disease, specify:____________________',
    ],
    [
        'Epilepsy/Seizure Disorder,specify:_______________________________',
        'Heart Disease &/or Heart Attack,specify:__________________________',
        '__________________________________________________________',
        'Kidney Disease, specify:______________________________________',
    ],
    [
        'Mental Health Condition',
        'Thyroid Disease',
        'Tuberculosis',
    ]
];

foreach(range(0,3) as $index){
    $pdf->SetXY($fam_his_x,$fam_his_y);
    $pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
    $pdf->SetXY($fam_his_x+5,$fam_his_y+3);
    $pdf->Cell(0,0,$fam_content[0][$index],0,0,'L');

    if($index != 2){
        $pdf->SetXY($fam_his_x+100,$fam_his_y);
        $pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
    }
    $pdf->SetXY($fam_his_x+105,$fam_his_y+3);
    $pdf->Cell(0,0,$fam_content[1][$index],0,0,'L');

    if($index != 3){
        $pdf->SetXY($fam_his_x+215,$fam_his_y);
        $pdf->Cell($box_content_w,$box_content_h,'',1,0,'L');
        $pdf->SetXY($fam_his_x+220,$fam_his_y+3);
        $pdf->Cell(0,0,$fam_content[2][$index],0,0,'L');
    }

    $fam_his_y+=5;
}

$y+=26;
displayCell($pdf,[$x,$y],[0,0],'MEDICAL HISTORY OF VACCINEE',0,'L',$con_font_size,'B');
displayCell($pdf,[60,$y],[0,0],'(Tick all past and present health conditions of the respondent.) :',0,'L',$con_font_size,'I');

$y+=3;
displayCell($pdf,[$x,$y],[$box_w,32],'',1,'C',$con_font_size,'I');

$med_his_y = $y;
$med_his_x = 15;
foreach(range(0,5) as $index){
    displayCell($pdf,[$med_his_x,$med_his_y],[$box_content_h,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$med_his_x+5,$med_his_y+3],[0,0],cellContent()['medical_history'][0][$index],0,'L',$con_font_size,'');

    displayCell($pdf,[$med_his_x+90,$med_his_y],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$med_his_x+95,$med_his_y+3],[0,0],cellContent()['medical_history'][1][$index],0,'L',$con_font_size,'');

    displayCell($pdf,[$med_his_x+190,$med_his_y],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$med_his_x+195,$med_his_y+3],[0,0],cellContent()['medical_history'][2][$index],0,'L',$con_font_size,'');

    $med_his_y+=5;
}

//retrieve
displayCell($pdf,[40,42],['66',5],$api->lname,0,'C',$con_font_size,'B');
displayCell($pdf,[110,42],['100',5],$api->fname,0,'C',$con_font_size,'B');
displayCell($pdf,[213,42],['36',5],$api->mname,0,'C',$con_font_size,'B');
displayCell($pdf,[253,42],['24',5],$api->suffix,0,'C',$con_font_size,'B');
displayCell($pdf,[60,54],['0',0],$api->head,0,'C',$con_font_size,'B');
displayCell($pdf,[140,54],['0',0],$api->gen_res,0,'L',$con_font_size,'B');
displayCell($pdf,[235,54],['0',0],$api->gen_con,0,'L',$con_font_size,'B');
displayCell($pdf,[32,57],['59',5],$api->gen_hou_r,0,'C',$con_font_size,'B');
displayCell($pdf,[93,57],['45',5],$api->gen_sit_r,0,'C',$con_font_size,'B');
displayCell($pdf,[141,57],['45',5],$barangay,0,'C',$con_font_size,'B');
displayCell($pdf,[184,57],['47',5],$muncity,0,'C',$con_font_size,'B');
displayCell($pdf,[233,57],['47',5],$province,0,'C',$con_font_size,'B');
displayCell($pdf,[69,66],['45',5],$api->gen_age,0,'C',$con_font_size,'B');
displayCell($pdf,[46,73.5],['45',5],date('M d, Y',strtotime($api->dob)),0,'L',$con_font_size,'B');
displayCell($pdf,[110,73.5],['110',5],$api->birthplace_p,0,'L',$con_font_size,'B');
displayCell($pdf,[251,73.5],['30',5],$api->gen_yrs_cur,0,'L',$con_font_size,'B');

//check
cellXY($api->sex,$pdf);
cellXY(substr($api->education, 0, 5),$pdf);

if($rel = json_decode($api->gen_reli)){
    cellXY($rel->religion,$pdf);
    displayCell($pdf,[234,67],['45',5],$rel->others,0,'L',$con_font_size,'B');
}
if($phic = json_decode($api->phic_membership)){
    cellXY($phic->status,$pdf);
    cellXY($phic->type,$pdf);
    cellXY($phic->employment,$pdf);
}

$pdf->Output();
//utility section
function displayCell($pdf, $setXY, $cellXY, $text, $border, $position, $fontSize,$fontWeight){
    $pdf->SetFont('Arial',$fontWeight,$fontSize);
    $pdf->SetXY($setXY[0],$setXY[1]);
    $pdf->Cell($cellXY[0],$cellXY[1],$text,$border,0,$position);
}
function displayCheck($pdf,$xy){
    $pdf->SetFont('ZapfDingbats','', 9);
    $pdf->SetXY($xy[0],$xy[1]);
    $pdf->Cell(0, 0, 4, 0, 0);
}
function cellXY($description,$pdf){
    switch ($description){
        case 'Male':
            displayCheck($pdf,['38', '70']);
            return;
        case 'Female':
            displayCheck($pdf,['58', '70']);
            return;
        case 'Eleme':
            displayCheck($pdf,['15', '87']);
            return;
        case 'high_school':
            displayCheck($pdf,['15', '91.5']);
            return;
        case 'vocational':
            displayCheck($pdf,['88', '87']);
            return;
        case 'no_complete_school':
            displayCheck($pdf,['88', '91.5']);
            return;
        case 'RC':
            displayCheck($pdf,['125', 70]);
            return;
        case 'Christian':
            displayCheck($pdf,['140', 70]);
            return;
        case 'INC':
            displayCheck($pdf,['160', 70]);
            return;
        case 'Islam':
            displayCheck($pdf,['175', 70]);
            return;
        case 'Jehovah':
            displayCheck($pdf,['192', 70]);
            return;
        case 'Member':
            displayCheck($pdf,['15', 108]);
            return;
        case 'Dependent':
            displayCheck($pdf,['15', 113]);
            return;
        case 'Non-member':
            displayCheck($pdf,['15', 118]);
            return;
        case 'Lifetime':
            displayCheck($pdf,['74', 102]);
            return;
        case 'Government':
            displayCheck($pdf,['178', 107]);
            return;
        case 'Sponsored By Others - SPECIFY':
            if (strpos($description, 'Sponsored') !== false) {
                displayCheck($pdf,['74', 107]);
                if( explode(' - ',$description)[0] == 'Sponsored By DOH' ){
                    displayCheck($pdf,['79', 112]);
                    return;
                }
                if( explode(' - ',$description)[0] == 'Sponsored By PLGU' ){
                    displayCheck($pdf,['94', 112]);
                    return;
                }
                if( explode(' - ',$description)[0] == 'Sponsored By MLGU' ){
                    displayCheck($pdf,['109', 112]);
                    return;
                }
                if( explode(' - ',$description)[0] == 'Sponsored By Private' ){
                    displayCheck($pdf,['125', 112]);
                    return;
                }
                if( explode(' - ',$description)[0] == 'Sponsored By Others' ){
                    displayCell($pdf,[104,118],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                    displayCheck($pdf,['79', 118]);
                    return;
                }
            }
    }

}

function cellContent(){
    return [
        'medical_history' => [
            [
                'Allergy, specify:_________________________________________',
                'Asthma (Fill-up Bronchia Asthma Section)',
                'Tuberculosis(If yes, fill-up Tuberculosis Section)',
                'Peptic Ulcer Disease',
                'Diabetes Mellitus (Fill-up Diabetes Mellitus Section)',
                'Urinary Tract Infections'
            ],
            [
                'Malaria',
                'Pnuemonia',
                'Epilipsy/Seizure Disorder, specify:_______________________________',
                'Kidney Disease, specify:______________________________________',
                'Immune Deficiency Disease, specify:____________________________',
                'Hepatitis, specify:____________________________________________'
            ],
            [
                'Heart Disease, specify:_______________________________',
                'Poisoning, specify:__________________________________',
                'STIs, specify:_______________________________________',
                'Thyroid Disease ____________________________________',
                'Cancer, specify organ: _______________________________',
                'Others, specify:_____________________________________'
            ]
        ]
    ];
}

?>