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
        $('#water2').val('Level '+value);
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
                console.log("Age : " + age);
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
                    $('.menarcheClass').removeClass('hide');
                } else {
                    $('.menarcheClass').addClass('hide');
                }

                if(age < 5) {
                    $('.hypertensionClass, .diabetesClass').addClass('hide');
                    $('.nutritionClass, .immuClass, .newbornClass').removeClass('hide');
                } else {
                    $('.hypertensionClass, .diabetesClass').removeClass('hide');
                    $('.nutritionClass, .immuClass, .newbornClass').addClass('hide');
                }
            }
        });
    }

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
            $('.cancer_type').show();
            $('.cancer_type').html("Type: <input type='text' value='{{ $info->cancer_type }}' name='cancer_type' style='width:50%;'>");
        } else {
            $('.cancer_type').html('');
            $('.cancer_type').hide();
        }
    });

    $('input[name="pwd"]').on('click', function() {
        var val = $(this).val();
        if(val === 'yes') {
            $('.pwd_description').show();
            $('.pwd_description').html("Specify: <input type='text' value='{{ $info->pwd_desc }}' name='pwd_desc' style='width:60%;'>");
        } else {
            $('.pwd_description').html('');
            $('.pwd_description').hide();
        }
    });

    $('input[name="religion"]').on('click', function() {
       var val = $(this).val();
       if(val === "other") {
           console.log("yow");
           $('.other_religion').show();
           $('.other_religion').html("<input type='text' style='width:50%;' name='other_religion' value='{{ $info->other_religion }}' class='form-control'/>");
       } else {
           $('.other_religion').html("");
           $('.other_religion').hide();
       }
    });

    $('input[name="deceased"]').on('click', function() {
        var val = $(this).val();
        if(val === 'yes') {
            $('.deceased_date').show();
            $('.deceased_date').html("Date of Death: <input type='date' value='{{ $info->deceased_date }}' name='deceased_date' style='width:30%;' min='1910-05-11'>");
        } else {
            $('.deceased_date').html('');
            $('.deceased_date').hide();
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
</script>