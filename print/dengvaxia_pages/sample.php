<?php

$dis_y = 0;
$cell_x = 30;
$cell_y = 5;
foreach(range(0,36) as $row){
    $dis_x = 0;
    foreach(range(0,9) as $column){
        displayCell($pdf,[$dis_x,$dis_y],[$cell_x,$cell_y],'d-x:'.$dis_x.' '.'d-y:'.$dis_y.' '.'c-x:'.$cell_x.' '.'c-y:'.$cell_y,1,'C',6,'');
        $dis_x+=30;
    }
    $dis_y += 5;
}


function displayCell($pdf, $setXY, $cellXY, $text, $border, $position, $fontSize,$fontWeight){
    $pdf->SetFont('Arial',$fontWeight,$fontSize);
    $pdf->SetXY($setXY[0],$setXY[1]);
    $pdf->Cell($cellXY[0],$cellXY[1],$text,$border,0,$position);
}

?>