<?php
    $x = 15;
    $GLOBALS['y'] = 3;
    $con_font_size = 7.5;
    $box_content_w = 5;
    $box_content_h = 5;
    $box_w = 270;
    $position = "L";
    $dif = 13;
    $pdf->SetLeftMargin($x);

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
        strpos($bronchial_asthma->diagnosed,'Yes') !== false ? displayCheck($pdf, [15,7]): displayCheck($pdf, [15,7]);
        displayCell($pdf,[$lvl_edu_x+97,12-7],[$box_content_w,$box_content_h],$bronchial_asthma->no_attacks,'','C',$con_font_size,'B');
        if(strpos($bronchial_asthma->with_medication,'Yes') !== false){
            displayCheck($pdf, ['195', 13.5-$dif]);
            if(isset(explode(' - ',$bronchial_asthma->with_medication)[1]))
                displayCell($pdf,[$lvl_edu_x+215,10-$dif],[$box_content_w,$box_content_h],explode(' - ',$bronchial_asthma->with_medication)[1],'','C',$con_font_size,'B');
        } else {
            displayCheck($pdf, ['195', '18.5'-$dif]);
        }
    }

    //tuberculosis
    $GLOBALS['y']+=5;
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
            Any_Following($row,$pdf,$dif);
        }
        if(strpos($tuberculosis->Diagnosed,'Yes') !== false){
            displayCheck($pdf, ['70','51'-$dif]);
            displayCell($pdf,[48,$GLOBALS['y']-5],[15,5],explode(' - ',$tuberculosis->Diagnosed)[1],0,'L',$con_font_size,'B');
        }
        else
            displayCheck($pdf, ['85','51'-$dif]);
        foreach($tuberculosis->Labs_Done as $row){
            Any_Following($row,$pdf,$dif);
        }
        foreach($tuberculosis->Medications as $row){
            Any_Following($row,$pdf,$dif);
        }
    }

    $GLOBALS['y']+=3;
    $description = "disability";
    $GLOBALS['disability_y'] = $GLOBALS['y'];
    $GLOBALS['disability_h'] = 0;

    rowCell($pdf,$description,false,array(40),$x,$GLOBALS['y'],
        [
            "DISABILITY"],
        0,'B',$con_font_size,$position);

    $disability_desc_y = $GLOBALS['y'];
    rowCell($pdf,$description,false,array(5,90,45,100),$x,$GLOBALS['y'],
        [
            "box",
            "Psychosocial and Behavioral Conditions",
            "Give description of disability:"
            ,"_______________________________________________________"],
    0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(5,90,45,100),$x,$GLOBALS['y'],
        [
            "box",
            "Learning or Intellectual Disability",
            "",
            "_______________________________________________________"],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(5,90,45,100),$x,$GLOBALS['y'],
        [
            "box",
            "Mental Conditions",
            "",
            ""],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(5,80,5,51,5,85,5,8),$x,$GLOBALS['y'],
        [
            "box",
            "Visual or Seeing Impairment",
            "box",
            "With assistive device/s?",
            "box",
            "Yes, specify:___________________________________________",
            "box",
            "No"],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(5,80,5,51,5,85,5,8),$x,$GLOBALS['y'],
        [
            "box",
            "Hearing Impairment",
            "box",
            "Need for assistive device/s?",
            "box",
            "Yes, specify:___________________________________________",
            "box",
            "No"],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(5,80),$x,$GLOBALS['y'],
        [
            "box",
            "Speech Impairment"],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(5,80),$x,$GLOBALS['y'],
        [
            "box",
            "Musculo-Skeletal or Injury Impairments"],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,true,array(270),$x,$GLOBALS['y'],
        [""],
        0,'',$con_font_size,$position);

    $description = "injury";
    $GLOBALS['injury_y'] = $GLOBALS['y']-5;
    $GLOBALS['injury_h'] = 0;
    rowCell($pdf,$description,false,array(135,135),$x,$GLOBALS['y']-5,
        [
            "INJURY","MEDICATIONS (List all current medicines and food supplements being taken) :"],
        0,'B',$con_font_size,$position);

    $injury_med_y = $GLOBALS['y'];
    rowCell($pdf,$description,false,array(5,130,135),$x,$GLOBALS['y'],
        [
            "box",
            "Vehicular Accident/Traffic-Related Injuries",
            "_________________________________________________________________________________________"],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,130,135),$x,$GLOBALS['y'],
        [
            "box",
            "Burns",
            "_________________________________________________________________________________________"],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,130,135),$x,$GLOBALS['y'],
        [
            "box",
            "Drowning",
            "_________________________________________________________________________________________"],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,130,135),$x,$GLOBALS['y'],
        [
            "box",
            "Fall",
            "_________________________________________________________________________________________"],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS['y'],
        [""],
        0,'',$con_font_size,$position);

    if($disability_injury = json_decode($api->disability_injury)){
        foreach($disability_injury->selected_options as $row){
            disability_injured($row,$pdf,$dif);
        }
        patientAnswer($pdf,[$disability_injury->description],array(82),155,$disability_desc_y,0,'B',$con_font_size,$position);
        patientAnswer($pdf,[$disability_injury->medication],array(135),150,$injury_med_y,0,'B',$con_font_size,$position);
        if(strpos($disability_injury->with_assistive,'Yes') !== false){
            displayCheck($pdf, ['100','90'-$dif]);
            displayCheck($pdf, ['156','90'-$dif]);
            displayCell($pdf,[177,90-$dif],[0,0],explode(' - ',$disability_injury->with_assistive)[1],0,'L',$con_font_size,'B');
        } else {
            displayCheck($pdf, ['246','90'-$dif]);
        }
        if(strpos($disability_injury->need_assistive,'Yes') !== false){
            displayCheck($pdf, ['100','95'-$dif]);
            displayCheck($pdf, ['156','95'-$dif]);
            displayCell($pdf,[177,95-$dif],[0,0],explode(' - ',$disability_injury->need_assistive)[1],0,'L',$con_font_size,'B');
        } else {
            displayCheck($pdf, ['246','95'-$dif]);
        }
    }

    $GLOBALS['y']-=5;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "HOSPITALIZATION HISTORY (List all past and current hospitalization/s.)"],
        0,'B',$con_font_size,$position);

    $description = "hospitalization";
    $GLOBALS['hospitalization_y'] = $GLOBALS['y'];
    $GLOBALS['hospitalization_h'] = 0;
    rowCell($pdf,$description,false,array(70,5,13,5,177),$x,$GLOBALS['y'],
        [
            "Were you previously hospitalized?",
            "box",
            "Yes",
            "box",
            "No"
        ],
        0,'',$con_font_size,$position);
    $position = 'C';
    rowCell($pdf,$description,false,array(63,49,54,45,59),$x,$GLOBALS['y'],
        [
            "Reason/Diagnosis",
            "Date Hospitalized",
            "Place Hospitalized",
            "PhilHealth used? Y/N",
            "Cost/s not covered by PhilHealth?"
        ],
        1,'',$con_font_size,$position);
    for($i=1;$i<=5;$i++)
    rowCell($pdf,$description,false,array(5,58,49,54,45,59),$x,$GLOBALS['y'],
        [$i, "", "", "", "", ""],
        1,'',$con_font_size,$position);
    $position = "L";
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        ["(Please use another sheet if needed.)"],
        1,'',$con_font_size,$position);

    rowCell($pdf,$description,true,array(270),$x,$GLOBALS['y'],
        [""],
        0,'',$con_font_size,$position);


    $GLOBALS['y'] -= 5;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "PAST SURGICAL HISTORY (Tick all operations, both minor and major, underwent by the vaccinee.)"],
        0,'B',$con_font_size,$position);
    $description = "surgical";
    $GLOBALS['surgical_y'] = $GLOBALS['y'];
    $GLOBALS['surgical_h'] = 0;
    foreach(range(0,3) as $index)
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        ["Operations"],
        1,'',$con_font_size,$position);



?>
