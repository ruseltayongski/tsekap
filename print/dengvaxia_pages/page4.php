<?php
    $x = 15;
    $GLOBALS['y'] = 3;
    $position = "L";
    $pdf->SetLeftMargin($x);

    $description = "";
    $GLOBALS[$description.'_h'] = 0;
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "REVIEW OF SYSTEMS: (Tick all that apply.)"],
        0,'B',$con_font_size,$position);

    $description = "review_system";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "box",
            "Jaundice",
            "box",
            "Seizures",
            "box",
            "Murmur",
            "box",
            "Polydypsia",
            "box",
            "Joint pain"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "box",
            "Pallor",
            "box",
            "Easy Fatigability",
            "box",
            "Breast pain",
            "box",
            "Polyuria",
            "box",
            "Muscle wasting"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "box",
            "Rashes",
            "box",
            "Cough/Colds",
            "box",
            "Nausea and/or vomiting",
            "box",
            "Vaginal bleeding",
            "box",
            "Muscle weakness"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "box",
            "Severe/Recurrent Headache",
            "box",
            "Dyspnea",
            "box",
            "Severe/Recurrent abdominal pain ",
            "box",
            "Foul Smelling Vaginal",
            "box",
            "Weight Loss"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "box",
            "Severe/Recurrent Dizziness",
            "box",
            "Orthopnea",
            "box",
            "Recurrent Constipation",
            "box",
            "Urethral discharge",
            "box",
            "Others, specify:"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49,54),$x,$GLOBALS['y'],
        [
            "box",
            "Blurring of vision",
            "box",
            "Chest pain",
            "box",
            "Diarrhea",
            "box",
            "Dysuria",
            "________________"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "box",
            "Hearing loss",
            "box",
            "Palpitations",
            "box",
            "Polyphagia",
            "box",
            "Leg pain",
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
            "PERTINENT PHYSICAL EXAMINATION"],
        0,'B',$con_font_size,$position);

    $description = "skin";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,false,array(54,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "General Status:",
            "box",
            "Oriented to Time, Place, and Date",
            "box",
            "Conscious",
            "box",
            "Ambulatory",
            "box",
            "Others, specify:"
        ],
        1,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(270),$x,$GLOBALS['y'],
        [
            "Vital Signs:"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(54,54,54,54,54),$x,$GLOBALS['y'],
        [
            "BP:________________",
            "HR:__________ /min.",
            "RR:__________ /min.",
            "Temp:__________ /Degree Celsius.",
            "Blood Type:________________"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,45,45,45,45,45),$x,$GLOBALS['y'],
        [
            "Weight (kg):_____________",
            "Height (m)::_____________",
            "BMI:_____________",
            "Waist (cm):_____________",
            "Hip (cm):_____________",
            "W/H Ratio:_____________",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,5,40,5,40,5,40,5,40,5,40),$x,$GLOBALS['y'],
            [
                "SKIN:",
                "box",
                "Good Skin Turgor",
                "box",
                "Pallor",
                "box",
                "Jaundice",
                "box",
                "Rashes",
                "box",
                "Lesions, specify:"
            ],
            0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,200),$x,$GLOBALS['y'],
        [
            "",
            "Others:",
        ],
        0,'',$con_font_size,$position);
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);

    $GLOBALS['y'] = $temp;
    $description = "skin";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,false,array(45,5,40,5,40,5,40,5,40,5,40),$x,$GLOBALS['y'],
    [
        "HEENT:",
        "box",
        "No significant findings",
        "box",
        "Visual Acuity:___________",
        "box",
        "Cleft lip",
        "box",
        "Enlarged tonsils",
        "box",
        "Others, specify:"
    ],
    0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,5,40,5,40,5,40,5,40,5,40),$x,$GLOBALS['y'],
        [
            "",
            "box",
            "Yellowish sclerae",
            "box",
            "Alar flaring",
            "box",
            "Cleft palate",
            "box",
            "Enlarged thyroid",
            "box",
            "___________________"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,5,40,5,40,5,40,5,85),$x,$GLOBALS['y'],
        [
            "",
            "box",
            "Pale conjunctiva",
            "box",
            "Nasal disharge",
            "box",
            "Ear discharge",
            "box",
            "Palpable mass, specify site:",
        ],
        0,'',$con_font_size,$position);
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);

    $GLOBALS['y'] = $temp;
    $description = "CHEST";
    $GLOBALS[$description.'_y'] = $GLOBALS['y'];
    $GLOBALS[$description.'_h'] = 0;
    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,false,array(67,5,63,5,62,67),$x,$GLOBALS['y'],
        [
            "CHEST AND LUNGS:",
            "box",
            "No Significant findings",
            "box",
            "Crackles/Rales/Harsh breath sounds",
            "- Breast mass/discharge",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(67,5,63,5,62,67),$x,$GLOBALS['y'],
        [
            "",
            "box",
            "Chest retractions",
            "box",
            "Wheezes",
            "- Others, specify:",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,5,40,5,40,5,40,5,40,5,40),$x,$GLOBALS['y'],
        [
            "HEART:",
            "box",
            "No Significant findings",
            "box",
            "Irregular pulse",
            "box",
            "Cyanosis (lips, nails)",
            "box",
            "murmur, specify:",
            "box",
            "Others, specify:"
        ],
        1,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(54,5,49,5,49,5,49,5,49),$x,$GLOBALS['y'],
        [
            "ABDOMEN:",
            "box",
            "No Significant findings",
            "box",
            "Tenderness",
            "box",
            "Palpable mass, specify site:",
            "box",
            "Others, specify:",
        ],
        1,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(45,5,40,5,40,5,40,5,40,5,40),$x,$GLOBALS['y'],
        [
            "EXTREMITIES:",
            "box",
            "Abnormal gait",
            "box",
            "Edema",
            "box",
            "Joint swelling",
            "box",
            "Gross deformity, describe:",
            "box",
            "Others, specify:"
        ],
        1,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,115,5,55,5,55),$x,$GLOBALS['y'],
        [
            "box",
            "Enzymes Based Rapid Diagnostic Test for Dengue, Specify result:",
            "box",
            "IgG Positive",
            "box",
            "IgM Positive"
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,200),$x,$GLOBALS['y'],
        [
            "box",
            "NS1 Test",
        ],
        0,'',$con_font_size,$position);
    rowCell($pdf,$description,false,array(5,200),$x,$GLOBALS['y'],
        [
            "box",
            "PCR",
        ],
        0,'',$con_font_size,$position);

    $temp = $GLOBALS['y'];
    rowCell($pdf,$description,true,array(270),$x,$GLOBALS[$description.'_y'],
        [""],
        0,'',$con_font_size,$position);


