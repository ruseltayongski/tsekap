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

    rowCell($pdf,$description,false,array(60,60,60,5,75),$x,$GLOBALS['y'],
        [
            "Age started: _________________________",
            "Age quit:  ___________________________",
            "Ever tried any illicit drug/substance?",
            "box",
            "Yes, specify: _____________________________",
        ],
        0,'',$con_font_size,$position);

    rowCell($pdf,$description,false,array(60,120,5,75),$x,$GLOBALS['y'],
        [
            "No. of stick/s per day: __________________",
            "No. of Pack-Years:  ________________________",
            "box",
            "No",
        ],
        0,'',$con_font_size,$position);

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
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS['personal_y'],
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

    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "Age of Menarche: ____________yrs. old"
        ],
        0,'',$con_font_size,$position);

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
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "No. of pads per day:"
        ],
        0,'',$con_font_size,$position);

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS['personal_y'],
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
    rowCell($pdf,$description,false,array(5,135,5,125),$x,$GLOBALS['y'],
        [
            "box",
            "Abnormal signs and symptoms: (Tick all that apply.)",
            "box",
            "Foul-smelling vaginal discharge"
        ],
        0,'',$con_font_size,$position);

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS['personal_y'],
        [""],
        0,'',$con_font_size,$position);
?>