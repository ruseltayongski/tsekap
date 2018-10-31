<?php
    $x = 15;
    $GLOBALS['y'] = 3;
    $position = "L";
    $pdf->SetLeftMargin($x);

    $description = "";
    $GLOBALS[$description.'_h'] = 0;
    rowCell($pdf,$description,false,array(40),$x,$GLOBALS['y'],
        [
            "PERSONAL/SOCIAL HISTORY"],
        0,'B',$con_font_size,$position);

    $description = "personal";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $GLOBALS['row'] = 1;
    rowCell($pdf,$description,false,array(80,5,50,80,5,15,5,15),$x,$GLOBALS['y'],
        [
            "Smoking: Have you tried smoking?",
            "box",
            "Former Smoker",
            "Alcohol Intake: Have you tried drinking alcohol?",
            "box",
            "Yes",
            "box",
            "No"
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 2;
    rowCell($pdf,$description,false,array(35,5,40,5,50,80,5,15,5,15),$x,$GLOBALS['y'],
        [
            "",
            "box",
            "Never Smoked",
            "box",
            "Secondhand Smoker",
            "In the past 5 months, have you drunk alcohol?",
            "box",
            "Yes",
            "box",
            "No"
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 3;
    rowCell($pdf,$description,false,array(35,5,40,5,50,80),$x,$GLOBALS['y'],
        [
            "",
            "box",
            "Current Smoker",
            "box",
            "Thirdhand Smoker",
            "Substance Abuse:"
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 4;
    rowCell($pdf,$description,false,array(60,60,60,5,75),$x,$GLOBALS['y'],
        [
            "Age started: _________________________",
            "Age quit:  ___________________________",
            "Ever tried any illicit drug/substance?",
            "box",
            "Yes, specify: _____________________________",
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 5;
    rowCell($pdf,$description,false,array(60,120,5,75),$x,$GLOBALS['y'],
        [
            "No. of stick/s per day: __________________",
            "No. of Pack-Years:  ________________________",
            "box",
            "No",
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 6;
    rowCell($pdf,$description,false,array(50,140,5,10,5,10),$x,$GLOBALS['y'],
        [
            "High Fat / High Salt Intake:",
            "Do you eat fast food/street food (e.g. instant noodles, canned goods, fries, fried chicken skin, etc) weekly?",
            "box",
            "Yes",
            "box",
            "No",
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 7;
    rowCell($pdf,$description,false,array(50,60,5,10,5,10),$x,$GLOBALS['y'],
        [
            "Dietary Fiber Intake:",
            "Do you eat 3 servings of vegetable daily?",
            "box",
            "Yes",
            "box",
            "No",
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 8;
    rowCell($pdf,$description,false,array(50,60,5,10,5,10),$x,$GLOBALS['y'],
        [
            "",
            "Do you eat 2-3 servings of fruits daily?",
            "box",
            "Yes",
            "box",
            "No",
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 9;
    rowCell($pdf,$description,false,array(50,110,5,10,5,10),$x,$GLOBALS['y'],
        [
            "Physical Activity:",
            "Does at least 30 minutes per day of moderate- to vigorous-intensity physical activity?",
            "box",
            "Yes",
            "box",
            "No",
        ],
        0,'',$con_font_size,$position);

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);


    $description = "";
    $GLOBALS[$description.'_h'] = 0;
    $GLOBALS['y'] = $temp;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "MENSTRUAL AND GYNECOLOGICAL HISTORY (for female vaccinee only)"],
        0,'B',$con_font_size,$position);

    $description = "menstrual";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];
    $GLOBALS['row'] = 10;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "Age of Menarche: ____________yrs. old"
        ],
        0,'',$con_font_size,$position);

    $GLOBALS['row'] = 11;
    rowCell($pdf,$description,false,array(60,5,5,5,5,5,5,5,5,5,5,70,60),$x,$GLOBALS['y'],
        [
            "Date of Last Menstrual Period:",
            "box",
            "box",
            "/",
            "box",
            "box",
            "/",
            "20",
            "box",
            "box",
            "",
            "Duration (number of days): ______________________",
            "Interval/Cycle: ______________________ days"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['row'] = 12;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "No. of pads per day:"
        ],
        0,'',$con_font_size,$position);
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);

    $description = "";
    $GLOBALS[$description.'_h'] = 0;
    $GLOBALS['y'] = $temp;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "Gyne History:"],
        0,'B',$con_font_size,$position);

    $description = "gyne";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "Abnormal signs and symptoms: (Tick all that apply.)"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['row'] = 13;
    rowCell($pdf,$description,false,array(5,115,5,145),$x,$GLOBALS['y'],
        [
            "box",
            "Abnormal Vaginal/Uterine Bleeding",
            "box",
            "Foul-smelling vaginal discharge"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['row'] = 14;
    rowCell($pdf,$description,false,array(5,115,5,145),$x,$GLOBALS['y'],
        [
            "box",
            "Dysmenorrhea",
            "box",
            "Vaginal Pruritus"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['row'] = 15;
    rowCell($pdf,$description,false,array(5,115,5,145),$x,$GLOBALS['y'],
        [
            "box",
            "Dyspareunia",
            "box",
            "Others, specify:_________________________"
        ],
        0,'',$con_font_size,$position);

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);


    $description = "";
    $GLOBALS[$description.'_h'] = 0;
    $GLOBALS['y'] = $temp;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "VACCINATION HISTORY"],
        0,'B',$con_font_size,$position);

    $description = "vaccination";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];

    $GLOBALS['row'] = 16;
    rowCell($pdf,$description,false,array(38,5,33,5,33,5,33,5,28,5,38,38),$x,$GLOBALS['y'],
        [
            "Vaccine/s received:",
            "box",
            "MR",
            "box",
            "Diphtheria/Tetanus",
            "box",
            "MMR",
            "box",
            "HPV",
            "box",
            "Tetanus Toxoid, No. of Doses:",
            "_____________________"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['y'] += 4;
    $GLOBALS[$description.'_h'] += 4;
    $GLOBALS['row'] = 17;
    $GLOBALS['breaker'] = "dengvaxia_count";
    rowCell($pdf,$description,false,array(5,25,25,5,5,5,5,5,5,5,5,5,10,30,5,20,5,50,5,30),$x,$GLOBALS['y'],
        [
            "box",
            "Dengvaxia 1",
            "Date received: ",
            "box",
            "box",
            "/",
            "box",
            "box",
            "/",
            "20",
            "box",
            "box",
            "",
            "Place Received:",
            "box",
            "School",
            "box",
            "Health Center/Community",
            "box",
            "Priv. MD"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['row'] = 18;
    rowCell($pdf,$description,false,array(5,25,25,5,5,5,5,5,5,5,5,5,10,30,5,20,5,50,5,30),$x,$GLOBALS['y'],
        [
            "box",
            "Dengvaxia 2",
            "Date received: ",
            "box",
            "box",
            "/",
            "box",
            "box",
            "/",
            "20",
            "box",
            "box",
            "",
            "Place Received:",
            "box",
            "School",
            "box",
            "Health Center/Community",
            "box",
            "Priv. MD"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['row'] = 19;
    rowCell($pdf,$description,false,array(5,25,25,5,5,5,5,5,5,5,5,5,10,30,5,20,5,50,5,30),$x,$GLOBALS['y'],
        [
            "box",
            "Dengvaxia 3",
            "Date received: ",
            "box",
            "box",
            "/",
            "box",
            "box",
            "/",
            "20",
            "box",
            "box",
            "",
            "Place Received:",
            "box",
            "School",
            "box",
            "Health Center/Community",
            "box",
            "Priv. MD"
        ],
        0,'',$con_font_size,$position);
    $GLOBALS['breaker'] = "break";

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);

    $GLOBALS['y'] = $temp+4;
    $GLOBALS['row'] = 20;
    rowCell($pdf,$description,false,array(70,5,95,5,95),$x,$GLOBALS['y'],
        [
            "For Adolescent Girls:",
            "box",
            "Given Ferrous sulfate supplementation, Date:",
            "box",
            "Given Iodized Oil Capsule, Date:",
        ],
        1,'',$con_font_size,$position);
    $GLOBALS['row'] = 21;
    rowCell($pdf,$description,false,array(70,5,95,5,95),$x,$GLOBALS['y'],
        [
            "Dewormed?",
            "box",
            "Yes, Date last dewormed:",
            "box",
            "No",
        ],
        1,'',$con_font_size,$position);
    $temp = $GLOBALS['y'];

    $description = "";
    $GLOBALS[$description.'_h'] = 0;
    $GLOBALS['y'] = $temp;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "OTHER PROCEDURES DONE"],
        0,'B',$con_font_size,$position);

    $description = "other";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];

    $GLOBALS['row'] = 22;
    rowCell($pdf,$description,false,array(5,265),$x,$GLOBALS['y'],
        [
            "box",
            "CBC",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,265),$x,$GLOBALS['y'],
        [
            "box",
            "Urinalysis",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,265),$x,$GLOBALS['y'],
        [
            "box",
            "Chest X-ray, Specify Findings (result):",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,110,5,30,5,55),$x,$GLOBALS['y'],
        [
            "box",
            "Enzymes Based Rapid Diagnostic Test for Dengue, Specify result:",
            "box",
            "IgG Positive",
            "box",
            "IgG Positive"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,265),$x,$GLOBALS['y'],
        [
            "box",
            "NS1 Test",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,265),$x,$GLOBALS['y'],
        [
            "box",
            "PCR",
        ],
        0,'',$con_font_size,$position);

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);

    //ANSWER

?>