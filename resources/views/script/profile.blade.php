<script>
    $('#checkProfile').modal({backdrop: 'static', keyboard: false});
    $.validator.setDefaults({
        errorElement: "span",
        errorClass: "help-block",
        //	validClass: 'stay',
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass); //.removeClass(errorClass);
            $(element).closest('.has-group').removeClass('has-success').addClass('has-error');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass); //.addClass(validClass);
            $(element).closest('.has-group').removeClass('has-error').addClass('has-success');
        },
        errorPlacement: function (error, element) {
            if (element.parent('.input-group').length) {
                error.insertAfter(element.parent());
            } else if (element.hasClass('select2')) {
                error.insertAfter(element.next('span'));
            }else if (element.hasClass('chosen-select')) {
                error.insertAfter(element.next('div'));
            }else if (element.hasClass('sex')) {
                error.insertAfter('.span');
            } else {
                error.insertAfter(element);
            }
        }
    });

    $('.chosen-select').on('change', function () {
        $(this).valid();
    });
    //
    //        $("#relation").select2();

    $.validator.setDefaults({ ignore: ":hidden:not(.chosen-select)" })
    var validator = $("#form-submit").validate();

    $('.btn-unmet').on('click',function(){
        var value = $(this).data('id');
        $('#unmet').val(value);
        $('#unmet2').val('Option '+value);
    });

    $('.btn-water').on('click',function(){
        var value = $(this).data('id');
        $('#water').val(value);
        if(value === 4)
            $('#water2').val('None of the above');
        else
            $('#water2').val('Level '+value);
        console.log("water value: " + $('#water').val());
    });

    $('#4ps_num').hide();
    @if($info->four_ps=='yes')
        $('#4ps_num').show();
    @else
        $('#4ps_num').hide();
    @endif

    $('#4ps').on('change', function() {
        if(this.checked === true) {
            $('#4ps_num').attr('required', true).show();
        } else {
            @if($info->four_ps == 'yes')
                $('#4ps_num').val('{{ $info->fourps_num }}');
            @else
                $('#4ps_num').val(null);
            @endif
            $('#4ps_num').attr('required', false).hide();
        }
    });

    function unmet_need()
    {
        $('#unmet').val(0);
        $('#unmet2').val('Not set');
    }


    $('.btn-checkProfile').on('click',function(){
        $('.loading').show();
        var content ='';
        var form = $('#form-submit');
        var data = {
            'fname' : $('#checkProfile').find('.fname').val(),
            'mname' : $('#checkProfile').find('.mname').val(),
            'lname' : $('#checkProfile').find('.lname').val(),
            'dob' : $('#checkProfile').find('.dob').val()
        };

        form.find('.fname').val(data.fname);
        form.find('.mname').val(data.mname);
        form.find('.lname').val(data.lname);
        form.find('.dob').val(data.dob);

        $.ajax({
            url: "{{ url('user/profile/verify') }}",
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': "{{ csrf_token() }}"
            },
            data: data,
            success: function(record){
                if(record.length > 0){
                    content += '<table class="table table-hover table-striped">' +
                        '<thead>' +
                        '<tr>' +
                        '<th>First Name</th>' +
                        '<th>Middle Name</th>' +
                        '<th>Last Name</th>' +
                        '<th>Date of Birth</th>' +
                        '<th>Update</th>' +
                        '</tr></thead>' +
                        '<tbody>';
                    jQuery.each(record, function(i,val){
                        content += '<tr>' +
                            '<td>'+val.fname+'</td>' +
                            '<td>'+val.mname+'</td>' +
                            '<td>'+val.lname+'</td>' +
                            '<td>'+val.dob+'</td>' +
                            '<td><a class="btn btn-xs btn-success" href="{{ url('user/population/info') }}/'+val.id+'"><i class="fa fa-pencil"></i> Update</a></td>' +
                            '</tr>';
                    });

                    content += '</tbody></table>';
                    $('#checkProfile').find('.modal-body').html(content);
                    $('#checkProfile').find('.btn-checkProfile').hide();
                }else{
                    $('#checkProfile').modal('hide');
                }

                $('.loading').hide();
            }
        });
    });
    calculateAge();
    $('#dob').on('keyup','keydown',function(){
        calculateAge();
    });
    var age_year = -1;

    function calculateAge(){
        var dob = $('#dob').val();
        var sex = $('input[name="sex"]:checked').val();
        if(!dob){
            dob = "{{ date('Y-m-d') }}";
        }
        console.log(dob);

        $.ajax({
            url : "{{ url('user/profile/age/') }}/"+dob,
            type : 'GET',
            success: function(age){
                age_year = age;
                console.log("age:" + age);
                if(age >= 10 && age <= 49) {
                    if(sex === "Female") {
                        $('.unmetClass').removeClass('hide');
                        $('.sexuallyActiveClass').removeClass('hide');
                        $('.pregnant_lmp').removeClass('hide');
                    } else if(sex === 'Male') {
                        $('.unmetClass').addClass('hide');
                        $('.sexuallyActiveClass').addClass('hide');
                        $('.pregnant_lmp').addClass('hide');
                        $('#unmet').val('0');
                        $('#unmet2').val('Not set');
                    }
                } else {
                    $('.pregnant_lmp').addClass('hide');
                    $('#unmet').val('0');
                    $('#unmet2').val('Not set');
                }

                if(age >= 6 && sex === "Female") {
                    $('.menarcheClass, .famPlan').removeClass('hide');
                } else {
                    $('.menarcheClass, .famPlan').addClass('hide');
                }

                if(age < 5) {
                    $('.hypertensionClass, .diabetesClass').addClass('hide');
                    $('.nutritionClass, .immuClass, .newbornClass').removeClass('hide');
                } else {
                    $('.hypertensionClass, .diabetesClass').removeClass('hide');
                    $('.nutritionClass, .immuClass, .newbornClass').addClass('hide');
                }
                setHealthGroup();
            }
        });
    }

    function setHealthGroup(){
        var dob = $('#dob').val();
        $.ajax({
            url : "{{ url('user/profile/age/day') }}/"+dob,
            type : "GET",
            success: function(day) {
                var age = age_year;
                console.log("health group: " + age + " year, " + day + " day/s");
                if(age === 0 && day <= 28)
                    $('#health_group, #hg').val('N');
                else if(age <= 1 && day > 28)
                    $('#health_group, #hg').val('I');
                else if(age >= 1 && age <= 4)
                    $('#health_group, #hg').val('PSAC');
                else if(age >= 5 && age <= 9)
                    $('#health_group, #hg').val('SAC');
                else if(age >= 10 && age <= 19)
                    $('#health_group, #hg').val('AD');
                else if(age >= 20 && age <= 59)
                    $('#health_group, #hg').val('A');
                else if(age >= 60)
                    $('#health_group, #hg').val('SC');
                else
                    $('#health_group, #hg').val('none');
            }
        });
    }

    $('#fam_plan_other_method, #fam_plan_other_status').hide();
    showFamPlan();
    function showFamPlan(){
        var plan = $('input[name="fam_plan"]:checked').val();
        if(plan === "yes") {
            $('.famPlanClass').removeClass('hide');
        } else {
            $('#fam_plan_method, #fam_plan_other_method, #fam_plan_status, #fam_plan_other_status').val(null);
            $('.famPlanClass').addClass('hide');
        }
    }

    @if($info->fam_plan_method == 'other')
        $('#fam_plan_other_method').show();
    @endif

    $('#fam_plan_method').on('change', function() {
        var method = $(this).val();
        if(method === 'other') {
            $('#fam_plan_other_method').show();
        } else {
            $('#fam_plan_other_method').hide();
        }
    });

    @if($info->fam_plan_status == 'other')
        $('#fam_plan_other_status').show();
    @endif
    $('#fam_plan_status').on('change', function() {
        var stat = $(this).val();
        if(stat === 'other') {
            $('#fam_plan_other_status').show();
        } else {
            $('#fam_plan_other_status').hide();
        }
    });

    showMenarche();
    function showMenarche() {
        var menarche = $('input[name="menarche"]:checked').val();
        if( menarche === "yes") {
            $('.menarche_age').show();
            $('.menarche_age').html("Age of Menarche: <input type='number' value='{{ $info->menarche_age }}' name='menarche_age' style='width:30%;' min='9'>");
        } else {
            $('.menarche_age').html('');
            $('.menarche_age').hide();
        }
    }

    showNewborn();
    function showNewborn() {
        var nb = $('input[name="newborn_screen"]:checked').val();
        if( nb === 'yes') {
            $('.newbornYes').show();
            $('.newbornYes').html("Result: <input type='text' value='{{ $info->newborn_text }}' name='newborn_text' style='width:30%;'>");
        } else {
            $('.newbornYes').html('');
            $('.newbornYes').hide();
        }
    }

    $('input[name="cancer"]').on('click', function() {
        var val = $(this).val();
        if(val === 'yes') {
            $('.cancer_type').html("Type: <input type='text' value='{{ $info->cancer_type }}' name='cancer_type' style='width:50%;'>").show();
        } else {
            $('.cancer_type').html('').hide();
        }
    });

    $('input[name="pwd"]').on('click', function() {
        var val = $(this).val();
        if(val === 'yes') {
            $('.pwd_description').html("Specify: <input type='text' value='{{ $info->pwd_desc }}' name='pwd_desc' style='width:60%;'>").show();
        } else {
            $('.pwd_description').html('').hide();
        }
    });

    $('.other_religion').hide();
    @if($info->religion == 'other')
        $('.other_religion').html("<br><input required type='text' style='width:75%; margin-top: 5px' name='other_religion' value='{{ $info->other_religion }}' placeholder='Specify other religion' class='form-control'/>").show();
    @else
        $('.other_religion').html("").hide();
    @endif
    $('#religion').on('change', function() {
        var val = $('#religion').val();
        console.log("religion: " +  val);
        if(val === "other") {
            $('.other_religion').html("<br><input required type='text' style='width:75%; margin-top: 5px' name='other_religion' value='{{ $info->other_religion }}' placeholder='Specify other religion' class='form-control'/>").show();
        } else {
            $('.other_religion').html("").hide();
        }
    });

    $('input[name="deceased"]').on('click', function() {
        var val = $(this).val();
        if(val === 'yes') {
            $('.deceased_date').html("Date of Death: <input type='date' value='{{ $info->deceased_date }}' name='deceased_date' style='width:30%;' min='1910-05-11'>").show();
        } else {
            $('.deceased_date').html('').hide();
        }
    });

    populateNutriStat();
    function populateNutriStat() {
        @foreach($nutri_stat as $nutri)
            var n = <?php echo $nutri?>;
            if(n.nutri === 'Deworming')
                $('.nutri_deworm').prop('checked', true);
            if(n.nutri === 'Vitamin A Supplement')
                $('.nutri_vitamina').prop('checked', true);
        @endforeach
    }

    populateImmunization();
    function populateImmunization() {
        @foreach($immu_stat as $i)
            var im = <?php echo $i?>;
            if(im.immu === 'BCG')
                $('.immu_bcg').prop('checked', true);
            if(im.immu === 'HEP B')
                $('.immu_hepb').prop('checked', true);
            if(im.immu === 'Penta 1')
                $('.immu_penta1').prop('checked', true);
            if(im.immu === 'Penta 2')
                $('.immu_penta2').prop('checked', true);
            if(im.immu === 'Penta 3')
                $('.immu_penta3').prop('checked', true);
            if(im.immu === 'OPV 1')
                $('.immu_opv1').prop('checked', true);
            if(im.immu === 'OPV 2')
                $('.immu_opv2').prop('checked', true);
            if(im.immu === 'OPV 3')
                $('.immu_opv3').prop('checked', true);
            if(im.immu === 'IPV 1')
                $('.immu_ipv1').prop('checked', true);
            if(im.immu === 'IPV 2')
                $('.immu_ipv2').prop('checked', true);
            if(im.immu === 'MMR 1')
                $('.immu_mmr1').prop('checked', true);
            if(im.immu === 'MMR 2')
                $('.immu_mmr2').prop('checked', true);
        @endforeach
    }

    var dropdown = "<option value=''>Select...</option>\n" +
        "           <option value='BHS'>BHS</option>\n" +
        "           <option value='RHU'>RHU</option>\n" +
        "           <option value='Public Hospital'>Public Hospital</option>\n" +
        "           <option value='Private Clinic'>Private Clinic</option>\n" +
        "           <option value='Private Hospital'>Private Hospital</option>\n" +
        "           <option value='Personal Expenses'>Personal Expenses</option>\n";

    $('#clear_hypertension, #clear_diabetic, #clear_mental, #clear_tb, #clear_cvd').hide();

    $('input[name="hypertension"]').on('click', function() {
        var val = $(this).val();
        if(val === 'Medication Avail') {
            setHyperRemarks('dropdown');
            $('#clear_hypertension').show();
        } else if(val === 'No Medication Avail') {
            setHyperRemarks('reason');
            $('#clear_hypertension').show();
        } else {
            $('.hypertension_remarks').html('').hide();
            $('#clear_hypertension').hide();
        }
    });

    function setHyperRemarks(type){
        if(type === 'dropdown')
            $('.hypertension_remarks').html("Type of Facility: <small class='text-info'><em>(where medicine was availed) </em></small> " +
                "<select name='hyper_remarks' id='hyper_dropdown' class='form-control select'>\n" + dropdown + "</select>").show();
        else if(type === 'reason')
            $('.hypertension_remarks').html('Reason: <small class="text-info"><i>(for not availing medicine) </i></small> <br> <textarea rows="2"  name="hyper_remarks" id="hyper_reason" style="resize: none;width: 100%;">').show();
    }

    $('input[name="diabetic"]').on('click', function() {
        var val = $(this).val();
        if(val === 'Medication Avail') {
            setDiabRemarks('dropdown');
            $('#clear_diabetic').show();
        } else if(val === 'No Medication Avail') {
            setDiabRemarks('reason');
            $('#clear_diabetic').show();
        } else {
            $('.diabetic_remarks').html('').hide();
            $('#clear_diabetic').hide();
        }
    });

    function setDiabRemarks(type) {
        if(type === 'dropdown')
            $('.diabetic_remarks').html("Type of Facility: <small class='text-info'><em>(where medicine was availed) </em></small> " +
                "<select name='diabetic_remarks' id='diab_dropdown' class='form-control select'>\n" + dropdown + "</select>").show();
        else if(type === 'reason')
            $('.diabetic_remarks').html('Reason: <small class="text-info"><i>(for not availing medicine) </i></small> <br> <textarea rows="2"  name="diabetic_remarks" id="diab_reason" style="resize: none;width: 100%;">').show();
    }

    $('input[name="mental_med"]').on('click', function() {
        var val = $(this).val();
        if(val === 'Medication Avail') {
            setMentalRemarks('dropdown');
            $('#clear_mental').show();
        } else if(val === 'No Medication Avail') {
            setMentalRemarks('reason');
            $('#clear_mental').show();
        } else {
            $('.mental_remarks').html('').hide();
            $('#clear_mental').hide();
        }
    });

    function setMentalRemarks(type) {
        if(type === 'dropdown')
            $('.mental_remarks').html("Type of Facility: <small class='text-info'><em>(where medicine was availed) </em></small> " +
                "<select name='mental_remarks' id='mental_dropdown' class='form-control select'>\n" + dropdown + "</select>").show();
        else if(type === 'reason')
            $('.mental_remarks').html('Reason: <small class="text-info"><i>(for not availing medicine) </i></small> <br> <textarea rows="2"  name="mental_remarks" id="mental_reason" style="resize: none;width: 100%;">').show();
    }

    $('input[name="tbdots_med"]').on('click', function() {
        var val = $(this).val();
        if(val === 'Medication Avail') {
            setTBRemarks('dropdown');
            $('#clear_tb').show();
        } else if(val === 'No Medication Avail') {
            setTBRemarks('reason');
            $('#clear_tb').show();
        } else {
            $('.tb_remarks').html('').hide();
            $('#clear_tb').hide();
        }
    });

    function setTBRemarks(type) {
        if(type === 'dropdown')
            $('.tb_remarks').html("Type of Facility: <small class='text-info'><em>(where medicine was availed) </em></small> " +
                "<select name='tb_remarks' id='tb_dropdown' class='form-control select'>\n" + dropdown + "</select>").show();
        else if(type === 'reason')
            $('.tb_remarks').html('Reason: <small class="text-info"><i>(for not availing medicine) </i></small> <br> <textarea rows="2"  name="tb_remarks" id="tb_reason" style="resize: none;width: 100%;">').show();
    }

    $('input[name="cvd_med"]').on('click', function() {
        var val = $(this).val();
        if(val === 'Medication Avail') {
            setCvdRemarks('dropdown');
            $('#clear_cvd').show();
        } else if(val === 'No Medication Avail') {
            setCvdRemarks('reason');
            $('#clear_cvd').show();
        } else {
            $('.cvd_remarks').html('').hide();
            $('#clear_cvd').hide();
        }
    });

    function setCvdRemarks(type) {
        if(type === 'dropdown')
            $('.cvd_remarks').html("Type of Facility: <small class='text-info'><em>(where medicine was availed) </em></small> " +
                "<select name='cvd_remarks' id='cvd_dropdown' class='form-control select'>\n" + dropdown + "</select>").show();
        else if(type === 'reason')
            $('.cvd_remarks').html('Reason: <small class="text-info"><i>(for not availing medicine) </i></small> <br> <textarea rows="2"  name="cvd_remarks" id="cvd_reason" style="resize: none;width: 100%;">').show();
    }

    function clearMedication(type) {
        $('.' + type).attr('checked', false);
        $('.' + type + '_remarks').html('').hide();
        $('#clear_' + type).hide();
    }

    @if(isset($hyper_status))
        @if($hyper_status === 'Medication Avail')
            setHyperRemarks('dropdown');
            $('#hyper_dropdown').val('{{ $hyper_remarks }}');
        @elseif($hyper_status === 'No Medication Avail')
            setHyperRemarks('reason');
            $('#hyper_reason').val('{{ $hyper_remarks }}');
        @endif
        $('#clear_hypertension').show();
    @endif

    @if(isset($diab_status))
        @if($diab_status === 'Medication Avail')
            setDiabRemarks('dropdown');
            $('#diab_dropdown').val('{{ $diab_remarks }}');
        @elseif($diab_status === 'No Medication Avail')
            setDiabRemarks('reason');
            $('#diab_reason').val('{{ $diab_remarks }}');
        @endif
        $('#clear_diabetic').show();
    @endif

    @if(isset($mental_status))
        @if($mental_status === 'Medication Avail')
            setMentalRemarks('dropdown');
            $('#mental_dropdown').val('{{ $mental_remarks }}');
        @elseif($mental_status === 'No Medication Avail')
            setMentalRemarks('reason');
            $('#mental_reason').val('{{ $mental_remarks }}');
        @endif
        $('#clear_mental').show();
    @endif

    @if(isset($tb_status))
        @if($tb_status === 'Medication Avail')
            setTBRemarks('dropdown');
            $('#tb_dropdown').val('{{ $tb_remarks }}');
        @elseif($tb_status === 'No Medication Avail')
            setTBRemarks('reason');
            $('#tb_reason').val('{{ $tb_remarks }}');
        @endif
        $('#clear_tb').show();
    @endif

    @if(isset($cvd_status))
        @if($cvd_status === 'Medication Avail')
            setCvdRemarks('dropdown');
            $('#cvd_dropdown').val('{{ $cvd_remarks }}');
        @elseif($cvd_status === 'No Medication Avail')
            setCvdRemarks('reason');
            $('#cvd_reason').val('{{ $cvd_remarks }}');
        @endif
        $('#clear_cvd').show();
    @endif
</script>