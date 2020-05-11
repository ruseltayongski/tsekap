<div class="page_break"></div>
<table class="table1" border="0" style="margin-top: 5px;">
    <tr>
        <td>
            <b>PERSONAL/SOCIAL HISTORY</b>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="170px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px"> <!-- PERSONAL row 1 -->
    <tr>
        <td width="33.2%"></td>
        <td width="52%"><?php if($profile->per_smoking=='never_smoked') echo '<span>&#10004;</span>'; ?></td>
        <td width="7%"><?php if($profile->per_alcohol=='yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_alcohol=='no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 13px"> <!-- PERSONAL row 2 -->
    <tr>
        <td width="17.2%"></td>
        <td width="16%"><?php if($profile->per_smoking=='never_smoked') echo '<span>&#10004;</span>'; ?></td>
        <td width="52%"><?php if($profile->per_smoking=='secondhand_smoker') echo '<span>&#10004;</span>'; ?></td>
        <td width="7%"><?php if($profile->per_drunk=='yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_drunk=='no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 33px"> <!-- PERSONAL row 3 -->
    <tr>
        <td width="17.2%"></td>
        <td width="16%"><?php if($profile->per_smoking=='current_smoker') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_smoking=='thirdhand_smoker') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 53px"> <!-- PERSONAL row 4 -->
    <tr>
        <td width="8%"></td>
        <td width="22%"><?php if($profile->per_age_started) echo $profile->per_age_started; ?></td>
        <td width="44.2%"><?php if($profile->per_age_quit) echo $profile->per_age_quit; ?></td>
        <td width="9%"><?php if($profile->per_drugs == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($profile->per_drugs_yes)) echo $profile->per_drugs_yes; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 76px"> <!-- PERSONAL row 5 -->
    <tr>
        <td width="12%"></td>
        <td width="23%"><?php if($profile->per_stick_day) echo $profile->per_stick_day; ?></td>
        <td ><?php if($profile->per_pack_years) echo $profile->per_pack_years; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 72px"> <!-- PERSONAL row 5 check box-->
    <tr>
        <td width="74.2%"></td>
        <td ><?php if($profile->per_drugs == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 90px"> <!-- PERSONAL row 6 check box-->
    <tr>
        <td width="85.3%"></td>
        <td width="6.9%"><?php if($profile->per_high_fat == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_high_fat == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 108px"> <!-- PERSONAL row 7 check box-->
    <tr>
        <td width="44.3%"></td>
        <td width="6.9%"><?php if($profile->per_fiber_vegetable == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_fiber_vegetable == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 127px"> <!-- PERSONAL row 7 check box-->
    <tr>
        <td width="44.3%"></td>
        <td width="6.9%"><?php if($profile->per_fiber_fruits == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_fiber_fruits == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 147px"> <!-- PERSONAL row 7 check box-->
    <tr>
        <td width="68.3%"></td>
        <td width="6.9%"><?php if($profile->per_physical_activity == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if($profile->per_physical_activity == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="33%">&nbsp;&nbsp;<b>Smoking: </b> Have you tried smoking?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="17%">Former Smoker</td>
        <td width="33%%"><b>Alcohol Intake:</b> Have you tried smoking drinking alcohol?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="17%"></td>
        <td width="2%"><div class="box"></div></td>
        <td width="14%">Never Smoked</td>
        <td width="2%"><div class="box"></div></td>
        <td width="17%">Secondhand Smoker</td>
        <td width="33%">in the past 5months, have you drunk alcohol?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
    <tr>
        <td width="17%"></td>
        <td width="2%"><div class="box"></div></td>
        <td width="14%">Current Smoked</td>
        <td width="2%"><div class="box"></div></td>
        <td width="17%">Thirdhand Smoker</td>
        <td width="33%"><b>Substance Abuse:</b></td>
        <td colspan="4"></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td>&nbsp;&nbsp;Age started: __________________</td>
        <td>Age quit:___________________</td>
        <td>Ever tried any illicit drug/substance?</td>
        <td width="2%"><div class="box"></div></td>
        <td>Yes, specify: _________________</td>
    </tr>
    <tr>
        <td>&nbsp;&nbsp;No. of stick/s per day: _________________</td>
        <td>No. of Pack-Years:_________________</td>
        <td></td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="18%">&nbsp;&nbsp;High Fat / High Salt intake</td>
        <td width="67%">Do you eat fast food/street (e.g instant noodles, canned goods, fries, fried chicken skin, etc) weekly?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="18%">&nbsp;&nbsp;Dietary Fiber intake:</td>
        <td width="26%">Do you eat 3 servings of vegetable daily?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
    <tr>
        <td></td>
        <td>Do you eat 2-3 servings of fruits daily?</td>
        <td ><div class="box"></div></td>
        <td >Yes</td>
        <td ><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="18%">&nbsp;&nbsp;Physical Activity:</td>
        <td width="50%">Does ar least 30 minutes per day of moderate-to vigorous-intensity physical activity?</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">Yes</td>
        <td width="2%"><div class="box"></div></td>
        <td>No</td>
    </tr>
</table>
<table class="table1" border="0" style="margin-top: 5px;">
    <tr>
        <td>
            <b>MENSTRUAL AND GYNECOLOGICAL HISTORY (for female vaccinee only)</b>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="60px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 4px"> <!-- MENSTRUAL row 1 -->
    <tr>
        <td width="10%"></td>
        <td ><?php if($profile->menst_age) echo $profile->menst_age; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 24px"> <!-- MENSTRUAL row 2 -->
    <tr>
        <td width="27.4%"></td>
        <td width="1.7%"><?php if($profile->menst_date_period) echo date('m',strtotime($profile->menst_date_period))[0]; ?></td>
        <td width="2.3%"><?php if($profile->menst_date_period) echo date('m',strtotime($profile->menst_date_period))[1]; ?></td>
        <td width="1.9%"><?php if($profile->menst_date_period) echo date('d',strtotime($profile->menst_date_period))[0]; ?></td>
        <td width="4%"><?php if($profile->menst_date_period) echo date('d',strtotime($profile->menst_date_period))[1]; ?></td>
        <td width="1.7%"><?php if($profile->menst_date_period) echo date('Y',strtotime($profile->menst_date_period))[2]; ?></td>
        <td width="20%"><?php if($profile->menst_date_period) echo date('Y',strtotime($profile->menst_date_period))[3]; ?></td>
        <td width="21%"><?php if($profile->menst_duration_days) echo $profile->menst_duration_days; ?></td>
        <td ><?php if($profile->menst_interval_days) echo $profile->menst_interval_days; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 41px"> <!-- MENSTRUAL row 3 -->
    <tr>
        <td width="12%"></td>
        <td ><?php if($profile->menst_pads) echo $profile->menst_pads; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0" style="margin-top: 5px">
    <tr>
        <td>&nbsp;&nbsp;Age of menarche: _____________________________ yrs old</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="30%">&nbsp;&nbsp;Date of Last Menstrual Period:</td>
        <td width="2%"><div class="box"></div></td>
        <td width="2%"><div class="box"></div></td>
        <td width="1">/</td>
        <td width="2%"><div class="box"></div></td>
        <td width="2%"><div class="box"></div></td>
        <td width="1%">/</td>
        <td width="1%">20</td>
        <td width="2%"><div class="box"></div></td>
        <td width="7%"><div class="box"></div></td>
        <td width="30%">Duration(number of days):  ________________</td>
        <td>Interval/Cycle:  ________________ days</td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td colspan="8">&nbsp;&nbsp;No. of pads per day: _____________________________________</td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="margin-top: 4.5px">
    <tr>
        <td>&nbsp;&nbsp;<b>Gyne History:</b></td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="75px"></td>
    </tr>
</table>
<table>
    <tr>
        <td><div style="margin-left: 26px;">Abnormal signs and symptoms: (Tick all that apply.)</div></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -5px"> <!-- GYNE HISTORY row 1 -->
    <tr>
        <td width="2.6%"></td>
        <td width="42.7%"><?php if(isset($gyne_history['gyne_description_abnormal'])) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($gyne_history['gyne_description_foul'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 13px"> <!-- GYNE HISTORY row 2-->
    <tr>
        <td width="2.6%"></td>
        <td width="42.7%"><?php if(isset($gyne_history['gyne_description_dyssmenorrhea'])) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($gyne_history['gyne_description_vaginal'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 33px"> <!-- GYNE HISTORY row 3 -->
    <tr>
        <td width="2.6%"></td>
        <td width="42.7%"><?php if(isset($gyne_history['gyne_description_dyspareunia'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="11%"><?php if(isset($gyne_history['gyne_description_others'])) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($gyne_history['gyne_specify_others'])) echo $gyne_history['gyne_specify_others']; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="2%"><div class="box" style="margin-left: 26px;"></div></td>
        <td><div style="margin-left: 17px;">Abnormal Vaginal/Uterine Bleeding</div></td>
        <td width="2%"><div class="box"></div></td>
        <td>Foul-smelling vaginal discharge</td>
    </tr>
    <tr>
        <td ><div class="box" style="margin-left: 26px;"></div></td>
        <td><div style="margin-left: 17px;">Dysmenorrhea</div></td>
        <td ><div class="box"></div></td>
        <td>Vaginal Pruritus</td>
    </tr>
    <tr>
        <td ><div class="box" style="margin-left: 26px;"></div></td>
        <td><div style="margin-left: 17px;">Dyspareunia</div></td>
        <td ><div class="box"></div></td>
        <td>Others, specify: ________________________________</td>
    </tr>
</table>
<table class="table1" border="0" style="margin-top: 5px;">
    <tr>
        <td>
            <b>VACCINATION HISTORY</b>
        </td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="90px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -5px"> <!-- VACCINATION HISTORY row 1 -->
    <tr>
        <td width="18.2%"></td>
        <td width="7%"><?php if($profile->vacc_rec_mr) echo '<span>&#10004;</span>'; ?></td>
        <td width="17%"><?php if($profile->vacc_rec_diphtheria) echo '<span>&#10004;</span>'; ?></td>
        <td width="7%"><?php if($profile->vacc_rec_mmr) echo '<span>&#10004;</span>'; ?></td>
        <td width="7%"><?php if($profile->vacc_rec_hpv) echo '<span>&#10004;</span>'; ?></td>
        <td width="18%"><?php if($profile->vacc_rec_tetanus) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($profile->vacc_rec_doses)) echo $profile->vacc_rec_doses; ?></td>
    </tr>
</table>
<table class="table1" border="0" cellspacing="0">
    <tr>
        <td width="18%"><b>&nbsp;&nbsp;Vacinne/s received:</b></td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">MR</td>
        <td width="2%"><div class="box"></div></td>
        <td width="15%">Diphtheria/Tetanus</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">MMR</td>
        <td width="2%"><div class="box"></div></td>
        <td width="5%">HPV</td>
        <td width="2%"><div class="box"></div></td>
        <td>Tetanus Toxoid, No. of Doses: _______________________</td>
    </tr>
</table><br>
<table class="table1" border="0" cellspacing="0">
    @if(count($vacc_history) >= 1)
        @foreach($vacc_history as $row)
            <tr>
                <td width="2%"><div class="box" style="margin-left: 26px;"><p style='margin-top: -6px;margin-left: 2px;'><span>&#10004;</span></p></div></td>
                <td width="12%"><div style="margin-left: 2px;">Dengvaxia {{ $row->vacc_deng_count }}</div></td>
                <td width="9%">Date Received:</td>
                <td width="2%"><div class="box"><b style="margin-left: 2px;font-size: 9pt">{{ date('m',strtotime($row->vacc_date))[0] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 2px;font-size: 9pt">{{ date('m',strtotime($row->vacc_date))[1] }}</b></div></td>
                <td width="1.5%">&nbsp;/</td>
                <td width="2%"><div class="box"><b style="margin-left: 2px;font-size: 9pt">{{ date('d',strtotime($row->vacc_date))[0] }}</b></div></td>
                <td width="2%"><div class="box"><b style="margin-left: 2px;font-size: 9pt">{{ date('m',strtotime($row->vacc_date))[1] }}</b></div></td>
                <td width="1.5%">&nbsp;/</td>
                <td width="1.5%">20</td>
                <td width="2%"><div class="box"><b style="margin-left: 2px;font-size: 9pt">{{ date('Y',strtotime($row->vacc_date))[2] }}</b></div></td>
                <td width="7%"><div class="box"><b style="margin-left: 2px;font-size: 9pt">{{ date('Y',strtotime($row->vacc_date))[3] }}</b></div></td>
                <td width="12%">Place Received:</td>
                <td width="2%"><div class="box"><?php if($row->vacc_place == 'school') echo "<p style='margin-top: -6px;margin-left: 2px;'><span>&#10004;</span></p>"; ?></div></td>
                <td width="5%">School</td>
                <td width="2%"><div class="box"><?php if($row->vacc_place == 'health') echo "<p style='margin-top: -6px;margin-left: 2px;'><span>&#10004;</span></p>"; ?></div></td>
                <td width="15%">Health Center/Community</td>
                <td width="2%"><div class="box"><?php if($row->vacc_place == 'privmd') echo "<p style='margin-top: -6px;margin-left: 2px;'><span>&#10004;</span></p>"; ?></div></td>
                <td>Priv. MD</td>
            </tr>
        @endforeach
    @else
        @foreach(range(1,3) as $index)
            <tr>
                <td width="2%"><div class="box" style="margin-left: 26px;"></div></td>
                <td><div style="margin-left: 17px;">Dengvaxia {{ $index }}</div></td>
                <td width="9%">Date Received:</td>
                <td width="2%"><div class="box"></div></td>
                <td width="2%"><div class="box"></div></td>
                <td width="1.5%">&nbsp;/</td>
                <td width="2%"><div class="box"></div></td>
                <td width="2%"><div class="box"></div></td>
                <td width="1.5%">&nbsp;/</td>
                <td width="2%">20</td>
                <td width="2%"><div class="box"></div></td>
                <td width="7%"><div class="box"></div></td>
                <td width="12%">Place Received:</td>
                <td width="2%"><div class="box"></div></td>
                <td width="5%">School</td>
                <td width="2%"><div class="box"></div></td>
                <td width="15%">Health Center/Community</td>
                <td width="2%"><div class="box"></div></td>
                <td>Priv. MD</td>
            </tr>
        @endforeach
    @endif
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 4px;"> <!-- Adolescent row 1 -->
    <tr>
        <td width="23.5%"></td>
        <td width="25%"><?php if(isset($profile->adol_supplementation)) echo '<span>&#10004;</span>'; ?></td>
        <td width="9%"><div style="margin-top: 5px;"><?php echo date('m/d/Y',strtotime($profile->adol_supplementation)); ?></div></td>
        <td width="19%"><?php if(isset($profile->adol_capsule)) echo '<span>&#10004;</span>'; ?></td>
        <td ><div style="margin-top: 5px;"><?php echo date('m/d/Y',strtotime($profile->adol_capsule)); ?></div></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 24px;"> <!-- Adolescent row 2 -->
    <tr>
        <td width="23.5%"></td>
        <td width="15%"><?php if($profile->dewormed == 'yes') echo '<span>&#10004;</span>'; ?></td>
        <td width="19%"><div style="margin-top: 3px;"><?php echo date('m/d/Y',strtotime($profile->dewormed_date)); ?></div></td>
        <td ><?php if($profile->dewormed == 'no') echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="margin-top:10px;">
    <tr>
        <td width="23%"><b>&nbsp;&nbsp;For Adolescent Girls:</b></td>
        <td width="2%"></td>
        <td width="32%">&nbsp;&nbsp;Given Ferrous sulfate supplementation, Date:</td>
        <td width="2%"></td>
        <td>&nbsp;&nbsp;Given Iodized Oil Capsule, Date:</td>
    </tr>
    <tr>
        <td><b>&nbsp;&nbsp;Dewormed?</b></td>
        <td></td>
        <td>&nbsp;&nbsp;Yes,Date last dewormed:</td>
        <td></td>
        <td>&nbsp;&nbsp;No</td>
    </tr>
</table>

<table class="table1" border="0" cellspacing="0" style="margin-top: 5px">
    <tr>
        <td><b>OTHER PRCEDURES DONE</b></td>
    </tr>
</table>
<table class="table1" border="1" cellspacing="0" style="position:absolute;;">
    <tr>
        <td height="125px"></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: -4px;"> <!-- OTHER PROCEDURE row 1 -->
    <tr>
        <td width="0.4%"></td>
        <td ><?php if(isset($other_procedure['other_tick_cbc'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 16px;"> <!-- OTHER PROCEDURE row 2 -->
    <tr>
        <td width="0.4%"></td>
        <td ><?php if(isset($other_procedure['other_tick_urinalysis'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 38px;"> <!-- OTHER PROCEDURE row 3 -->
    <tr>
        <td width="0.4%"></td>
        <td ><?php if(isset($other_procedure['other_tick_chest'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 60px;"> <!-- OTHER PROCEDURE row 4 -->
    <tr>
        <td width="0.4%"></td>
        <td width="41.9%"><?php if(isset($other_procedure['other_tick_enzymes'])) echo '<span>&#10004;</span>'; ?></td>
        <td width="11.9%"><?php if(isset($other_procedure['other_tick_enzymes_igg'])) echo '<span>&#10004;</span>'; ?></td>
        <td ><?php if(isset($other_procedure['other_tick_enzymes_igm'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 82px;"> <!-- OTHER PROCEDURE row 5 -->
    <tr>
        <td width="0.4%"></td>
        <td ><?php if(isset($other_procedure['other_tick_ns'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0" id="fetch_data" cellspacing="0" style="position:absolute;margin-top: 102px;"> <!-- OTHER PROCEDURE row 6 -->
    <tr>
        <td width="0.4%"></td>
        <td ><?php if(isset($other_procedure['other_tick_pcr'])) echo '<span>&#10004;</span>'; ?></td>
    </tr>
</table>
<table class="table1" border="0">
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td colspan="5">CBC</td>
    </tr>
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td colspan="5">Urinalysis</td>
    </tr>
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td colspan="5">Chest X-ray, Specify Findings (result):</td>
    </tr>
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td width="40%">Enzymes Based Rapid Diagnostic Test for Dengue, Specify result:</td>
        <td width="2%"><div class="box"></div></td>
        <td width="10%">IgG Positive</td>
        <td width="2%"><div class="box"></div></td>
        <td>IgM Positive</td>
    </tr>
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td colspan="5">NS1 Test</td>
    </tr>
    <tr>
        <td width="2%"><div class="box"></div></td>
        <td colspan="5">PCR</td>
    </tr>
</table>

<div class="footer">
    <div class="page_number">Page </div>
</div>