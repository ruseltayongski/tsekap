<label class="text-green">PERSONAL/SOCIAL HISTORY</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small>
                <b>Smoking:</b><br>
                Have you tried smoking?
            </small>
            <select name="smoking"  class="form-control">
                <option value="never_smoked">Never Smoked</option>
                <option value="current_smoker">Current Smoker</option>
                <option value="former_smoker">Former Smoker</option>
                <option value="secondhand_smoker">Secondhand Smoker</option>
                <option value="thirdhand_smoker">Thirdhand Smoker</option>
            </select>
        </td>
        <td>
            <small><br>Age started</small>
            <input type="text" name="smoking_age_started" class="form-control" >
        </td>
        <td>
            <small><br>Age quit</small>
            <input type="text" name="smoking_age_quit" class="form-control" >
        </td>
        <td>
            <small><br>No. of stick/s per day</small>
            <input type="text" name="smoking_stick" class="form-control" >
        </td>
        <td>
            <small><br>No. of Pack-Years</small>
            <input type="text" name="smoking_pack" class="form-control" >
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small>
                <b>High Fat / High salt Intake:</b><br>
                Do you eat fast food/street food (e.g instant noodles, canned goods, fries, fried chicken skin, etc) weekly?
            </small>
            <select name="high_fat"  class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
        <td>
            <small>
                <b>Dietary Fiber Intake:</b><br>
                Do you eat 3 servings of vegetable daily?
            </small>
            <select name="dietary_fiber"  class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
        <td>
            <small>
                <br>
                Do you eat 2-3 servings of fruits daily?
            </small>
            <select name="dietary_fiber_fruits"  class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
        <td>
            <small>
                <b>Physical Activity</b>
                <br>
                Does at least 30 minutes per day of moderate - to vigorous-intensity physical activity?
            </small>
            <select name="physical_activity"  class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small>
                <b>Alcohol Intake:</b><br>
                Have you tried drinking alcohol?
            </small>
            <select name="alcohol_tried"  class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
        <td>
            <small>
                <br>In the past 5 months, have you drunk alcohol?
            </small>
            <select name="alcohol_past"  class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
        <td>
            <small>
                <b>Substance Abuse:</b><br>
                Ever tried any illicit drug/substance?
            </small>
            <select name="drugs" class="form-control">
                <option value="">Select option</option>
                <option value="yes">Yes</option>
                <option value="no">No</option>
            </select>
        </td>
    </tr>
</table>

<label class="text-green">MENSTRUAL AND GYNECOLOGICAL HISTORY (for female vaccinee only)</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <small>Age of Menarche</small>
            <input type="text" name="menstrual_age" class="form-control" >
        </td>
        <td>
            <small>Date of Last Menstrual Period:</small>
            <input type="date" name="menstrual_date" class="form-control" >
        </td>
        <td>
            <small>Duration (number of days)</small>
            <input type="number" name="menstrual_duration" class="form-control" >
        </td>
        <td>
            <small>Interval/Cycle</small>
            <input type="number" name="menstrual_interval" class="form-control" >
        </td>
        <td>
            <small>No. of pads per day</small>
            <input type="number" name="menstrual_per_day" class="form-control" >
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td colspan="3">
            <small><b>Gyne History</b></small><br>
            <small>Abnormal signs and symptoms: (tick all that apply)</small>
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="abnormal" name="gyne[]"> Abnormal Vaginal/Utering Bleeding
        </td>
        <td>
            <input type="checkbox" value="dyssmenorrhea" name="gyne[]"> Dysmenorrhea
        </td>
        <td>
            <input type="checkbox" value="dyspareunia" name="gyne[]"> Dyspareunia
        </td>
    </tr>
    <tr>
        <td>
            <input type="checkbox" value="foul_smelling" name="gyne[]"> Foul-smelling vaginal discharge
        </td>
        <td>
            <input type="checkbox" value="vaginal_pruritus" name="gyne[]"> Vaginal Pruritus
        </td>
        <td>
            <input type="checkbox" value="others" name="gyne[]">Others, specify
            <input type="text" name="gyne_others" >
        </td>
    </tr>
</table>

<label class="text-green">VACCINATION HISTORY</label>
<table class="table table-hover table-striped">
    <tr>
        <td style="width: 15%">
            <small><b>Vaccinee/s received</b></small><br>
            <input type="checkbox" value="mr" name="vaccinee_received[]"> MR
        </td>
        <td>
            <br>
            <input type="checkbox" value="diphtheria" name="vaccinee_received[]"> Diphtheria/Tetanus
        </td>
        <td>
            <br>
            <input type="checkbox" value="mmr" name="vaccinee_received[]"> MMR
        </td>
        <td>
            <br>
            <input type="checkbox" value="hpv" name="vaccinee_received[]"> HPV
        </td>
        <td>
            <br>
            <input type="checkbox" value="tetanus" name="vaccinee_received[]"> Tetanus Toxoid,
        </td>
        <td colspan="2">
            <small>No. of doses</small>
            <input type="number" name="vaccinee_received_doses" class="form-control" >
        </td>
    </tr>
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    @for($i=1;$i<=3;$i++)
        <tr>
            <td>
                <br>
                Dengvaxia {{ $i }}
            </td>
            <td>
                <small>Date received</small>
                <input type="date" name="dengvaxia_date[]" class="form-control" >
            </td>
            <td>
                <small>Place Received</small>
                <input type="text" name="dengvaxia_received[]" class="form-control" >
            </td>
            <td>
                <br>
                <input type="checkbox" name="dengvaxia_school[]"> School
            </td>
            <td>
                <br>
                <input type="checkbox" name="dengvaxia_health[]"> Health Center/Community
            </td>
            <td>
                <br>
                <input type="checkbox" name="dengvaxia_md[]"> Priv. MD
            </td>
        </tr>
    @endfor
</table>
<table class="table table-hover table-striped" style="margin-top: -25px">
    <tr>
        <td>
            <small>
                <b>For Adolescent Girls:</b><br>
                Given Ferrous sulfate supplementation, Date
            </small>
            <input type="date" name="adolescent_ferrous" class="form-control" >
        </td>
        <td>
            <small>
                <br>
                Given Iodized Oil Capsule, Date
            </small>
            <input type="date" name="adolescent_iodized" class="form-control" >
        </td>
    </tr>
    <tr>
        <td>
            <small>
                <b>Dewormed?</b><br>
                Yes, Date last dewormed?
            </small>
            <input type="date" name="dewormed_yes" class="form-control" >
        </td>
        <td>
            <br><br>
            <input type="checkbox" name="dewormed_no"> No
        </td>
    </tr>
</table>

<label class="text-green">OTHER PROCEDURES DONE</label>
<table class="table table-hover table-striped">
    <tr>
        <td>
            <input type="checkbox" value="cbc" name="other_procedure[]"> CBC
        </td>
        <td>
            <input type="checkbox" value="urinalysis" name="other_procedure[]"> Urinalysis
        </td>
        <td>
            <input type="checkbox" value="chest_xray" name="other_procedure[]"> Chest X-ray<br>
            <small>Specify result</small>
            <input type="text" class="form-control" name="other_procedure_chest">
        </td>
        <td>
            <input type="checkbox" value="enzymes"> Enzymes Based Rapis Diagnosis Test for Dengue,<br>
            <small>Specify result:</small> &nbsp;&nbsp;&nbsp;
            <input type="radio" value="irg_positive" name="other_procedure_enzymes"> IrG Positive &nbsp;&nbsp;&nbsp;
            <input type="radio" value="irm_positive" name="other_procedure_enzymes"> IrM Positive
        </td>
        <td>
            <input type="checkbox" value="ns_test" name="other_procedure[]"> NS1 Test
        </td>
        <td>
            <input type="checkbox" value="pcr" name="other_procedure[]"> PCR
        </td>
    </tr>
</table>