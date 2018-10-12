<?php
    $x = 15;
    $y = 3;
    $con_font_size = 7.5;
    $box_content_w = 5;
    $box_content_h = 5;
    $box_w = 270;

    $y+=6;
    displayCell($pdf,[$x,$y],[0,0],'BRONCHIAL ASTHMA',0,'L',$con_font_size,'B');
    $y+=2;
    displayCell($pdf,[$x,$y],[$box_w,10],'',1,'C',$con_font_size,'');
    $y+=2;
    $lvl_edu_x = 15;
    displayCell($pdf,[$lvl_edu_x,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');

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

    cellXY($api->sex,$pdf);

?>
