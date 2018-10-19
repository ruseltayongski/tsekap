<?php
    $x = 15;
    $GLOBALS['y'] = 3;
    $con_font_size = 7.5;
    $box_content_w = 5;
    $box_content_h = 5;
    $box_w = 270;

    $GLOBALS['y']+=6;
    displayCell($pdf,[$x,$GLOBALS['y']],[0,0],'BRONCHIAL ASTHMA',0,'L',$con_font_size,'B');
    $GLOBALS['y']+=2;
    displayCell($pdf,[$x,$GLOBALS['y']],[$box_w,10],'',1,'C',$con_font_size,'');

    $GLOBALS['y']+=2;
    $lvl_edu_x = 15;
    displayCell($pdf,[$lvl_edu_x,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+5,$GLOBALS['y']],[0,0],'Diagnosed',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+80,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'No. of attacks per week:',0,'C',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+160,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'With Medications?',0,'C',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+180,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+185,$GLOBALS['y']],[0,0],'Yes, specify: ____________________',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    $lvl_edu_x = 15;
    displayCell($pdf,[$lvl_edu_x,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+5,$GLOBALS['y']],[0,0],'Not Diagnosed',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+180,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+185,$GLOBALS['y']],[0,0],'No',0,'L',$con_font_size,'');

    if($bronchial_asthma = json_decode($api->bronchial_asthma)){
        strpos($bronchial_asthma->diagnosed,'Yes') !== false ? displayCheck($pdf, ['15', '13.5']): displayCheck($pdf, ['15', '18.5']);
        displayCell($pdf,[$lvl_edu_x+97,$GLOBALS['y']-7],[$box_content_w,$box_content_h],$bronchial_asthma->no_attacks,'','C',$con_font_size,'B');
        if(strpos($bronchial_asthma->with_medication,'Yes') !== false){
            displayCheck($pdf, ['195', '13.5']);
            if(isset(explode(' - ',$bronchial_asthma->with_medication)[1]))
                displayCell($pdf,[$lvl_edu_x+215,$GLOBALS['y']-8],[$box_content_w,$box_content_h],explode(' - ',$bronchial_asthma->with_medication)[1],'','C',$con_font_size,'B');
        } else {
            displayCheck($pdf, ['195', '18.5']);
        }
    }

    //tuberculosis
    $GLOBALS['y']+=10;
    displayCell($pdf,[$x,$GLOBALS['y']],[0,0],'TUBERCULOSIS',0,'L',$con_font_size,'B');
    $GLOBALS['y']+=2;
    displayCell($pdf,[$x,$GLOBALS['y']],[$box_w,36],'',1,'C',$con_font_size,'');
    $GLOBALS['y']+=2.5;
    displayCell($pdf,[$lvl_edu_x,$GLOBALS['y']],[0,0],'Any of the following?',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+50,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$GLOBALS['y']],[0,0],'Weight Loss',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$GLOBALS['y']],[0,0],'Chest pain',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+120,$GLOBALS['y']],[0,0],'Labs done:',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$GLOBALS['y']],[0,0],'PPD',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$GLOBALS['y']],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    displayCell($pdf,[$lvl_edu_x,$GLOBALS['y']],[0,0],'(Tick all that apply.)',0,'L',$con_font_size,'I');
    displayCell($pdf,[$lvl_edu_x+50,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$GLOBALS['y']],[0,0],'Fever',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$GLOBALS['y']],[0,0],'Back pain',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$GLOBALS['y']],[0,0],'Sputum Exam',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$GLOBALS['y']],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    displayCell($pdf,[$lvl_edu_x+50,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$GLOBALS['y']],[0,0],'Loss of appetite',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$GLOBALS['y']],[0,0],'Neck nodes',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$GLOBALS['y']],[0,0],'CXR',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$GLOBALS['y']],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    displayCell($pdf,[$lvl_edu_x+50,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$GLOBALS['y']],[0,0],'Cough > 2 weeks',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$GLOBALS['y']],[0,0],'GenXpert',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$GLOBALS['y']],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    displayCell($pdf,[$lvl_edu_x,$GLOBALS['y']],[0,0],'Diagnosed with TB this year?',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+60,$GLOBALS['y']],[0,0],'Yes',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+70,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+75,$GLOBALS['y']],[0,0],'No',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$GLOBALS['y']],[0,0],'New, smear positive',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+118,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+123,$GLOBALS['y']],[0,0],'Extrapulmonary, specify:',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+180,$GLOBALS['y']],[0,0],'Medications:',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    displayCell($pdf,[$lvl_edu_x+8,$GLOBALS['y']+3],[0,0],'If Yes, form of TB:   _______________________________',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$GLOBALS['y']],[0,0],'New, smear negative',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+118,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+123,$GLOBALS['y']],[0,0],'Clinically diagnosed',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+190,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+195,$GLOBALS['y']],[0,0],'Cat I',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+205,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+210,$GLOBALS['y']],[0,0],'Cat Ii',0,'L',$con_font_size,'');

    $GLOBALS['y']+=5;
    displayCell($pdf,[$lvl_edu_x+85,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$GLOBALS['y']],[0,0],'Relapse',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+118,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+123,$GLOBALS['y']],[0,0],'TB in Children ',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+190,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+195,$GLOBALS['y']],[0,0],'Cat III',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+205,$GLOBALS['y']-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+210,$GLOBALS['y']],[0,0],'TB in Children',0,'L',$con_font_size,'');

    if($tuberculosis = json_decode($api->tuberculosis)){
        foreach($tuberculosis->Any_Following as $row){
            Any_Following($row,$pdf);
        }
        if(strpos($tuberculosis->Diagnosed,'Yes') !== false){
            displayCheck($pdf, ['70','53']);
            displayCell($pdf,[48,$GLOBALS['y']-5],[15,5],explode(' - ',$tuberculosis->Diagnosed)[1],0,'L',$con_font_size,'B');
        }
        foreach($tuberculosis->Labs_Done as $row){
            Any_Following($row,$pdf);
        }
        foreach($tuberculosis->Medications as $row){
            Any_Following($row,$pdf);
        }
    }

    $GLOBALS['y']+=10;
    displayCell($pdf,[$x,$GLOBALS['y']],[$box_w,36],'',1,'C',$con_font_size,'');
    $GLOBALS['y']+=2;
    displayCell($pdf,[$x,$GLOBALS['y']],[0,0],'DISABILITY',0,'L',$con_font_size,'B');

    $GLOBALS['y']+=50;
    $pdf->SetWidths(array(5,80,45,100));
    $pdf->SetXY($x,$GLOBALS['y']);
    $data = ["box","Psychosocial and Behavioral Conditions","Give description of disability:","_______________________________________________________"];
    $pdf->Row($data,$pdf,1);




?>
