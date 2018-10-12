<?php
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
            case 'Elementary':
                displayCheck($pdf,['15', '87']);
                return;
            case 'High School':
                displayCheck($pdf,['15', '91.5']);
                return;
            case 'Vocational':
                displayCheck($pdf,['88', '87']);
                return;
            case 'No Completed Schooling':
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
                displayCheck($pdf,['15', 112]);
                return;
            case 'Non-Member':
                displayCheck($pdf,['15', 118]);
                return;
            case 'Lifetime':
                displayCheck($pdf,['74', 102]);
                return;
            case 'Sponsored':
                displayCheck($pdf,['74', 107]);
                return;
            case 'Sponsored By DOH':
                displayCheck($pdf,['79', 112]);
                return;
            case 'Sponsored By PLGU':
                displayCheck($pdf,['94', 112]);
                return;
            case 'Sponsored By MLGU':
                displayCheck($pdf,['109', 112]);
                return;
            case 'Sponsored By Private':
                displayCheck($pdf,['125', 112]);
                return;
            case 'Sponsored By Others':
                displayCheck($pdf,['79', 118]);
                return;
            case 'Government':
                displayCheck($pdf,['178', 108]);
                return;
            case 'Yes':
                displayCheck($pdf,['211', 108]);
                return;
            case 'No':
                displayCheck($pdf,['229', 108]);
                return;
            case strpos($description,'Allergy_fam') !== false:
                displayCheck($pdf,['15', 130]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[40,130],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Asthma_fam') !== false:
                displayCheck($pdf,['15', 135]);
                return;
            case strpos($description,'Cancer_fam') !== false:
                displayCheck($pdf,['15', 140]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[47,140],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Immune_fam') !== false:
                displayCheck($pdf,['15', 145]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[65,145],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Epilepsy_fam') !== false:
                displayCheck($pdf,['115', 130]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[162,130],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Heart_fam') !== false:
                displayCheck($pdf,['115', 135]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[168,135],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Kidney_fam') !== false:
                displayCheck($pdf,['115', 145]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[150,145],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Mental_fam') !== false:
                displayCheck($pdf,['230', 130]);
                return;
            case strpos($description,'Thyroid_fam') !== false:
                displayCheck($pdf,['230', 134]);
                return;
            case strpos($description,'Tuberculosis_fam') !== false:
                displayCheck($pdf,['230', 140]);
                return;
            case strpos($description,'Allergy_med') !== false:
                displayCheck($pdf,['15', 159]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[40,159],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Asthma_med') !== false:
                displayCheck($pdf,['15', 164]);
                return;
            case strpos($description,'Tuberculosis_med') !== false:
                displayCheck($pdf,['15', 169]);
                return;
            case strpos($description,'Peptic') !== false:
                displayCheck($pdf,['15', 174]);
                return;
            case strpos($description,'Diabetes') !== false:
                displayCheck($pdf,['15', 179]);
                return;
            case strpos($description,'Urinary') !== false:
                displayCheck($pdf,['15', 184]);
                return;
            case strpos($description,'Malaria') !== false:
                displayCheck($pdf,['105', 159]);
                return;
            case strpos($description,'Pnuemonia') !== false:
                displayCheck($pdf,['105', 164]);
                return;
            case strpos($description,'Epilepsy_med') !== false:
                displayCheck($pdf,['105', 169]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[151,169],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Kidney_med') !== false:
                displayCheck($pdf,['105', 174]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[140,174],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Immune_med') !== false:
                displayCheck($pdf,['105', 179]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[154,179],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Hepatitis') !== false:
                displayCheck($pdf,['105', 184]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[132,184],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Heart_med') !== false:
                displayCheck($pdf,['205', 159]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[238,159],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Poisonin') !== false:
                displayCheck($pdf,['205', 164]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[233,164],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Stis') !== false:
                displayCheck($pdf,['205', 169]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[227,169],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Thyroid_med') !== false:
                displayCheck($pdf,['205', 174]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[231,174],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Cancer_med') !== false:
                displayCheck($pdf,['205', 179]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[238,179],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
            case strpos($description,'Others_med') !== false:
                displayCheck($pdf,['205', 184]);
                if(isset(explode(' - ',$description)[1]))
                    displayCell($pdf,[230,184],[0,0],explode(' - ',$description)[1],0,'L',7.5,'B');
                return;
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