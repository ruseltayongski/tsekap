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
    displayCell($pdf,[$lvl_edu_x+5,$y],[0,0],'Diagnosed',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+80,$y-2],[$box_content_w,$box_content_h],'No. of attacks per week:',0,'C',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+160,$y-2],[$box_content_w,$box_content_h],'With Medications?',0,'C',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+180,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+185,$y],[0,0],'Yes, specify: ____________________',0,'L',$con_font_size,'');

    $y+=5;
    $lvl_edu_x = 15;
    displayCell($pdf,[$lvl_edu_x,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+5,$y],[0,0],'Not Diagnosed',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+180,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+185,$y],[0,0],'No',0,'L',$con_font_size,'');

    if($bronchial_asthma = json_decode($api->bronchial_asthma)){
        strpos($bronchial_asthma->diagnosed,'Yes') !== false ? displayCheck($pdf, ['15', '13.5']): displayCheck($pdf, ['15', '18.5']);
        displayCell($pdf,[$lvl_edu_x+97,$y-7],[$box_content_w,$box_content_h],$bronchial_asthma->no_attacks,'','C',$con_font_size,'B');
        if(strpos($bronchial_asthma->with_medication,'Yes') !== false){
            displayCheck($pdf, ['195', '13.5']);
            if(isset(explode(' - ',$bronchial_asthma->with_medication)[1]))
                displayCell($pdf,[$lvl_edu_x+215,$y-8],[$box_content_w,$box_content_h],explode(' - ',$bronchial_asthma->with_medication)[1],'','C',$con_font_size,'B');
        } else {
            displayCheck($pdf, ['195', '18.5']);
        }
    }

    //tuberculosis
    $y+=10;
    displayCell($pdf,[$x,$y],[0,0],'TUBERCULOSIS',0,'L',$con_font_size,'B');
    $y+=2;
    displayCell($pdf,[$x,$y],[$box_w,36],'',1,'C',$con_font_size,'');
    $y+=2.5;
    displayCell($pdf,[$lvl_edu_x,$y],[0,0],'Any of the following?',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+50,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$y],[0,0],'Weight Loss',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$y],[0,0],'Chest pain',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+120,$y],[0,0],'Labs done:',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$y],[0,0],'PPD',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$y],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $y+=5;
    displayCell($pdf,[$lvl_edu_x,$y],[0,0],'(Tick all that apply.)',0,'L',$con_font_size,'I');
    displayCell($pdf,[$lvl_edu_x+50,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$y],[0,0],'Fever',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$y],[0,0],'Back pain',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$y],[0,0],'Sputum Exam',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$y],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $y+=5;
    displayCell($pdf,[$lvl_edu_x+50,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$y],[0,0],'Loss of appetite',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$y],[0,0],'Neck nodes',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$y],[0,0],'CXR',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$y],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $y+=5;
    displayCell($pdf,[$lvl_edu_x+50,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$y],[0,0],'Cough > 2 weeks',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+137,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+142,$y],[0,0],'GenXpert',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+163,$y],[0,0],'Result:  ___________________________________________________________',0,'L',$con_font_size,'');

    $y+=5;
    displayCell($pdf,[$lvl_edu_x,$y],[0,0],'Diagnosed with TB this year?',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+55,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+60,$y],[0,0],'Yes',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+70,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+75,$y],[0,0],'No',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$y],[0,0],'New, smear positive',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+118,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+123,$y],[0,0],'Extrapulmonary, specify:',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+180,$y],[0,0],'Medications:',0,'L',$con_font_size,'');

    $y+=5;
    displayCell($pdf,[$lvl_edu_x+8,$y+3],[0,0],'If Yes, form of TB:   _______________________________',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+85,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$y],[0,0],'New, smear negative',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+118,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+123,$y],[0,0],'Clinically diagnosed',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+190,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+195,$y],[0,0],'Cat I',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+205,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+210,$y],[0,0],'Cat Ii',0,'L',$con_font_size,'');

    $y+=5;
    displayCell($pdf,[$lvl_edu_x+85,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+90,$y],[0,0],'Relapse',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+118,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+123,$y],[0,0],'TB in Children ',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+190,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+195,$y],[0,0],'Cat III',0,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+205,$y-2],[$box_content_w,$box_content_h],'',1,'L',$con_font_size,'');
    displayCell($pdf,[$lvl_edu_x+210,$y],[0,0],'TB in Children',0,'L',$con_font_size,'');

    if($tuberculosis = json_decode($api->tuberculosis)){
        foreach($tuberculosis->Any_Following as $row){
            Any_Following($row,$pdf);
        }
        if(strpos($tuberculosis->Diagnosed,'Yes') !== false){
            displayCheck($pdf, ['70','53']);
            displayCell($pdf,[48,$y-5],[15,5],explode(' - ',$tuberculosis->Diagnosed)[1],0,'L',$con_font_size,'B');
        }
        foreach($tuberculosis->Labs_Done as $row){
            Any_Following($row,$pdf);
        }
    }

    function Any_Following($description,$pdf){
        switch ($description) {
            case strpos($description,'Weight_Loss - ') !== false:
                displayCheck($pdf, ['65','33']);
                return;
            case strpos($description,'Chest_Pain - ') !== false:
                displayCheck($pdf, ['100','33']);
                return;
            case strpos($description,'Fever - ') !== false:
                displayCheck($pdf, ['65','38']);
                return;
            case strpos($description,'Back_Pain - ') !== false:
                displayCheck($pdf, ['100','38']);
                return;
            case strpos($description,'Loss_Appetite - ') !== false:
                displayCheck($pdf, ['65','43']);
                return;
            case strpos($description,'Neck_Nodes - ') !== false:
                displayCheck($pdf, ['100','43']);
                return;
            case strpos($description,'Cough - ') !== false:
                displayCheck($pdf, ['65','48']);
                return;
            case strpos($description,'New_smear_positive - ') !== false:
                displayCheck($pdf, ['100','53']);
                return;
            case strpos($description,'New_smear_negative - ') !== false:
                displayCheck($pdf, ['100','58']);
                return;
            case strpos($description,'Relapse - ') !== false:
                displayCheck($pdf, ['100','63']);
                return;
            case strpos($description,'Extrapulmonary - ') !== false:
                displayCheck($pdf, ['133','53']);
                displayCell($pdf,[167,50],[15,5],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Clinically_Diagnosed - ') !== false:
                displayCheck($pdf, ['133','58']);
                return;
            case strpos($description,'TB_in_children - ') !== false:
                displayCheck($pdf, ['133','63']);
                return;
            case strpos($description,'PPD - ') !== false:
                displayCheck($pdf, ['152','33']);
                return;
            case strpos($description,'Sputum_Exam - ') !== false:
                displayCheck($pdf, ['152','38']);
                return;
            case strpos($description,'CXR - ') !== false:
                displayCheck($pdf, ['152','43']);
                return;
            case strpos($description,'Genxpert - ') !== false:
                displayCheck($pdf, ['152','48']);
                return;
        }
    }

?>
