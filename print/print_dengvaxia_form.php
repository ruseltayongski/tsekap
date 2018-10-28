<?php

require('fpdf.php');
session_start();
//$api = json_decode(file_get_contents('http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER['SERVER_PORT']."/tsekap/vii/patient_api/191042"));
include('database.php');
$unique_id = $_SESSION['unique_id'];
//$dengvaxiaId = 15672;

$GLOBALS['api'] = query_dengvaxia($unique_id);
$bar = barangay($GLOBALS['api']->barangay_id);
$mun = muncity($GLOBALS['api']->muncity_id);
$pro = province($GLOBALS['api']->province_id);
$bar ? $barangay = $bar->description : $barangay = "NO BARANGAY";
$mun ? $muncity = $mun->description : $muncity = "NO MUNICIPALITY";
$pro ? $province = $pro->description : $province = "NO PROVINCE";
$GLOBALS['tried_alcohol'] = "false";
$GLOBALS['drunk_in_5mos'] = "false";
$GLOBALS['tried_drugs'] = "false";
$GLOBALS['fat_salt_intake'] = "false";
$GLOBALS['daily_vegetable'] = "false";
$GLOBALS['daily_fruit'] = "false";
$GLOBALS['physical_activity'] = "false";

class PDF_MC_Table extends FPDF
{
    var $widths;
    var $aligns;

    function SetWidths($w)
    {
        //Set the array of column widths
        $this->widths=$w;
    }

    function SetAligns($a)
    {
        //Set the array of column alignments
        $this->aligns=$a;
    }

    function display_check($w,$a){
        $this->SetFont('ZapfDingbats','', 9);
        $this->MultiCell($w,5,4,1,$a);
    }
    function display_text($x,$y,$text){
        $this->SetFont('Arial','B',7.5);
        $this->SetXY($x,$y);
        $this->Cell(20,5,$text,0,0,'L');
    }

    function Row($data,$description,$bigBox,$border,$position)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++) {
            if($data[$i] != 'box'){
                $nb = max($nb, $this->NbLines($this->widths[$i], $data[$i]));
            }
        }
        //Draw the cells of the row
        $h=5*$nb;
        $this->CheckPageBreak($h);
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : $position;
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();

            //Draw the border
            if($border == 1) $this->Rect($x,$y,$w,$h);

            $personal_history = json_decode($GLOBALS['api']->personal_history);
            $gyne_history = json_decode($GLOBALS['api']->mens_gyne_history);
            if($data[$i] == "box"){
                //Print the text
                if(isset($gyne_history->selected_options)){
                    foreach($gyne_history->selected_options as $row){
                        if(strpos($data[$i+1], $row) !== false || strpos($data[$i+1], explode('_',$row)[0]) !== false ){
                            $this->display_check($w,$a);
                        }
                    }
                }
                if($personal_history->tried_drugs != " - "){
                    $tried_drugs = explode(" - ",$personal_history->tried_drugs)[0];
                } else {
                    $tried_drugs = "no_needle";
                }


                if($data[$i+1] == $personal_history->tried_smoking){
                    $this->display_check($w,$a);
                }
                elseif($data[$i+1] == $personal_history->tried_alcohol && $GLOBALS['tried_alcohol'] == "false"){
                    $GLOBALS['tried_alcohol'] = "true";
                    $this->display_check($w,$a);
                }
                elseif($data[$i+1] == $personal_history->drunk_in_5mos && $GLOBALS['drunk_in_5mos'] == "false"){
                    $GLOBALS['drunk_in_5mos'] = "true";
                    $this->display_check($w,$a);
                }
                elseif(strpos($data[$i+1],$tried_drugs) !== false && $GLOBALS['tried_drugs'] == "false"){
                    $GLOBALS['tried_drugs'] = "true";
                    $this->display_check($w,$a);
                    $this->display_text($x+22,$y,explode(" - ",$personal_history->tried_drugs)[1]);
                }
                elseif($data[$i+1] == $personal_history->fat_salt_intake && $GLOBALS['fat_salt_intake'] == "false"){
                    $GLOBALS['fat_salt_intake'] = "true";
                    $this->display_check($w,$a);
                }
                elseif($data[$i+1] == $personal_history->daily_vegetable && $GLOBALS['daily_vegetable'] == "false" && $GLOBALS["row"] == 7){
                    $GLOBALS['daily_vegetable'] = "true";
                    $this->display_check($w,$a);
                }
                elseif($data[$i+1] == $personal_history->daily_fruit && $GLOBALS['daily_fruit'] == "false" && $GLOBALS["row"] == 8){
                    $GLOBALS['daily_fruit'] = "true";
                    $this->display_check($w,$a);
                }
                elseif($data[$i+1] == $personal_history->physical_activity && $GLOBALS['physical_activity'] == "false" && $GLOBALS["row"] == 9){
                    $GLOBALS['physical_activity'] = "true";
                    $this->display_check($w,$a);
                }
                elseif(isset($gyne_history->selected_options->Others) && strpos($data[$i+1], 'Others') !== false){
                    $this->display_check($w,$a);
                    $this->display_text($x+25,$y,$gyne_history->selected_options->Others);
                }
                else {
                    $this->MultiCell($w,5,'',1,$a);
                }
                $this->SetFont('Arial','',7.5);
            } else {
                //Print the text
                $this->SetFont('Arial','',7.5);
                $this->MultiCell($w,5,$data[$i],0,$a);
                if(strpos($data[$i], 'Age started:') !== false){
                    $this->display_text($x+20,$y,$personal_history->smoking_age_started);
                }
                elseif(strpos($data[$i], 'Age quit:') !== false){
                    $this->display_text($x+15,$y,$personal_history->smoking_age_quit);
                }
                elseif(strpos($data[$i], 'No. of stick/s per day:') !== false){
                    $this->display_text($x+28,$y,$personal_history->smoking_no_sticks);
                }
                elseif(strpos($data[$i], 'No. of Pack-Years:') !== false){
                    $this->display_text($x+25,$y,$personal_history->smoking_no_packs);
                }
                elseif(strpos($data[$i], 'Age of Menarche:') !== false && $GLOBALS['row'] == 10){
                    if(isset($gyne_history->age_menarche)){
                        $age_menarche = $gyne_history->age_menarche;
                    } else {
                        $age_menarche = "";
                    }
                    $this->display_text($x+25,$y,$age_menarche);
                }
                elseif(strpos($data[$i], 'Date of Last Menstrual Period:') !== false && $GLOBALS['row'] == 11){
                    if(isset($gyne_history->last_period)){
                        $month = implode('    ',str_split(explode('-',$gyne_history->last_period)[1]));
                        $day = implode('    ',str_split(explode('-',$gyne_history->last_period)[2]));
                        $year = implode('    ',str_split(explode('20',explode('-',$gyne_history->last_period)[0])[1]));
                        $format = $month.'            '.$day.'                    '.$year;
                    } else {
                        $format = "";
                    }
                    $this->display_text($x+61,$y,$format);
                }
                elseif(strpos($data[$i], 'Duration (number of days):') !== false && $GLOBALS['row'] == 11){
                    if(isset($gyne_history->duration)){
                        $duration = $gyne_history->duration;
                    } else {
                        $duration = "";
                    }
                    $this->display_text($x+35,$y,$duration);
                }
                elseif(strpos($data[$i], 'Interval/Cycle:') !== false && $GLOBALS['row'] == 11){
                    if(isset($gyne_history->interval)){
                        $interval = $gyne_history->interval;
                    } else {
                        $interval = "";
                    }
                    $this->display_text($x+20,$y,$interval);
                }
                elseif(strpos($data[$i], 'No. of pads per day:') !== false && $GLOBALS['row'] == 12){
                    if(isset($gyne_history->no_pads)){
                        $no_pads = $gyne_history->no_pads;
                    } else {
                        $no_pads = "";
                    }
                    $this->display_text($x+25,$y,$no_pads);
                }
            }
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }

        $GLOBALS[$description.'_h'] += $h;
        if( isset($GLOBALS[$description.'_h']) && $bigBox){
            $this->Rect(15,$GLOBALS[$description.'_y'],270,$GLOBALS[$description.'_h']-5);
        }

        //Go to the next line
        $GLOBALS['y'] = $y+$h;
        $this->Ln($h);
    }

    function patient_answer($data,$border,$position)
    {
        //Calculate the height of the row
        $nb=0;
        for($i=0;$i<count($data);$i++)
            $nb=max($nb,$this->NbLines($this->widths[$i],$data[$i]));
        $h=5*$nb;
        //Issue a page break first if needed
        $this->CheckPageBreak($h);
        //Draw the cells of the row
        for($i=0;$i<count($data);$i++)
        {
            $w=$this->widths[$i];
            $a=isset($this->aligns[$i]) ? $this->aligns[$i] : $position;
            //Save the current position
            $x=$this->GetX();
            $y=$this->GetY();
            //Draw the border
            if($border == 1) $this->Rect($x,$y,$w,$h);
            //Print the text
            $this->MultiCell($w,5,$data[$i],0,$a);
            //Put the position to the right of the cell
            $this->SetXY($x+$w,$y);
        }
        //Go to the next line
        $this->Ln($h);
    }

    function CheckPageBreak($h)
    {
        //If the height h would cause an overflow, add a new page immediately
        if($this->GetY()+$h>$this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
    }

    function NbLines($w,$txt)
    {
        //Computes the number of lines a MultiCell of width w will take
        $cw=&$this->CurrentFont['cw'];
        if($w==0)
            $w=$this->w-$this->rMargin-$this->x;
        $wmax=($w-2*$this->cMargin)*1000/$this->FontSize;
        $s=str_replace("\r",'',$txt);
        $nb=strlen($s);
        if($nb>0 and $s[$nb-1]=="\n")
            $nb--;
        $sep=-1;
        $i=0;
        $j=0;
        $l=0;
        $nl=1;
        while($i<$nb)
        {
            $c=$s[$i];
            if($c=="\n")
            {
                $i++;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
                continue;
            }
            if($c==' ')
                $sep=$i;
            $l+=$cw[$c];
            if($l>$wmax)
            {
                if($sep==-1)
                {
                    if($i==$j)
                        $i++;
                }
                else
                    $i=$sep+1;
                $sep=-1;
                $j=$i;
                $l=0;
                $nl++;
            }
            else
                $i++;
        }
        return $nl;
    }
}

$pdf=new PDF_MC_Table('L','mm','A4');
include 'dengvaxia_pages/utility_function.php';
$pdf->AddPage();
include 'dengvaxia_pages/page1.php';
$pdf->AddPage();
include 'dengvaxia_pages/page2.php';
$pdf->AddPage();
include 'dengvaxia_pages/page3.php';
$pdf->AddPage();
include 'dengvaxia_pages/page4.php';

$pdf->Output();

?>

