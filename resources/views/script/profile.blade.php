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

               if(age>14 && age<50){
                    if(sex==='Female'){
                        $('.unmetClass').removeClass('hide');
                        $('.pregnant_lmp').removeClass('hide');
                    }else{
                        $('.unmetClass').addClass('hide');
                        $('.pregnant_lmp').addClass('hide');
                        $('#unmet').val('0');
                        $('#unmet2').val('Not set');
                    }

               }else{
                   $('.unmetClass').addClass('hide');
                   $('#unmet').val('0');
                   $('#unmet2').val('Not set');
               }
            }
        });
    }
</script>