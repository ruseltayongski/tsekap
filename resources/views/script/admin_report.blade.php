<script>
    $('#select_year').on('change', function() {
        $('.year_selected').val($(this).val());
    });

    function getClass(percentage) {
        if(percentage >= 0 && percentage <= 20)
            return 'bg-danger';
        else if(percentage > 20 && percentage <= 40)
            return 'bg-warning';
        else if(percentage > 40 && percentage <= 60)
            return 'bg-info';
        else if(percentage > 60 && percentage <= 80)
            return 'bg-success';
        else if(percentage > 80)
            return 'bg-aqua';
    }

    $.ajax({
        url: "{{ asset('home/count/province/1/'.$year) }}",
        type: 'GET',
        success: function(result) {
            console.log('----------------bohol----------------');
            console.log(result);
            $('#prov_profile1').html(result.countPopulation);
            $('#prov_percentage1').html(result.profilePercentage + "%");
            $('#percent_class1').addClass(getClass(result.profilePercentage));
        }
    });
    $.ajax({
        url: "{{ asset('home/count/province/2/'.$year) }}",
        type: 'GET',
        success: function(result) {
            console.log('----------------cebu----------------');
            console.log(result);
            $('#prov_profile2').html(result.countPopulation);
            $('#prov_percentage2').html(result.profilePercentage + "%");
            $('#percent_class2').addClass(getClass(result.profilePercentage));
        }
    });
    $.ajax({
        url: "{{ asset('home/count/province/3/'.$year) }}",
        type: 'GET',
        success: function(result) {
            console.log('----------------negros----------------');
            console.log(result);
            $('#prov_profile3').html(result.countPopulation);
            $('#prov_percentage3').html(result.profilePercentage + "%");
            $('#percent_class3').addClass(getClass(result.profilePercentage));
        }
    });
    $.ajax({
        url: "{{ asset('home/count/province/4/'.$year) }}",
        type: 'GET',
        success: function(result) {
            console.log('----------------siquijor----------------');
            console.log(result);
            $('#prov_profile4').html(result.countPopulation);
            $('#prov_percentage4').html(result.profilePercentage + "%");
            $('#percent_class4').addClass(getClass(result.profilePercentage));
        }
    });
    $('.loading').show();
    $('.btn-submit').on('click',function(){
        $('.loading').show();
    });
    $(window).on('load',function(){
        $('.loading').fadeOut('slow');
    });
    <?php if(isset($province_id)): ?>
    <?php echo 'var tmp = '.$province_id.';'; ?>
    <?php echo 'var muncity_id = "'.$muncity_id.'";'; ?>
    filterProvince(tmp,muncity_id);
    <?php endif; ?>
    $('.filterProvince').on('change',function(){
        var id = $(this).val();
        filterProvince(id,'');
    });
    function filterProvince(id,muncity_id)
    {
            <?php echo 'var link="'.asset('location/muncity').'";'; ?>
        var url = link+'/'+id;
        $('.filterMuncity').html('<option value="all">Select All...</option>').trigger('change');
        if(id){
            $('.loading').show();
            $.ajax({
                url: url,
                type: 'GET',
                success: function(data) {
                    var content = '';
                    jQuery.each(data, function(i,val){
                        content += '<option value="'+val.id+'">' +
                            val.description +
                            '</option>'
                    });
                    $('.filterMuncity').append(content).trigger("chosen:updated");
                    if(muncity_id>0){
                        $('.filterMuncity').val(muncity_id).trigger("chosen:updated");
                    }else{
                        $('.filterMuncity').val('all').trigger("chosen:updated");
                    }
                    $('.loading').hide();
                }
            });
        }
    }

    function filterMuncity(prov_id) {
        muncity_id = $('#muncity_select'+prov_id).val();
        $('#municipality'+prov_id).val(muncity_id);
        $('#barangay'+prov_id).val('');
        var year = $('#select_year').val();
        if(muncity_id !== '') {
            // Disable downloading entire data of HUCs
            // IDs of HUCs: Cebu City - 63, Mandaue - 80, Lapu-lapu 76
            if(muncity_id === '63' || muncity_id === '80' || muncity_id === '76') {
                $('#dl_btn'+prov_id).attr('disabled', true);
            }
            else {
                $('#dl_btn'+prov_id).attr('disabled', false);
            }

            var url = "{{ asset('population/target/getMuncityTotal') }}";
            $.ajax({
                url: url+'/'+muncity_id+'/'+year,
                type: 'GET',
                success: function(data){
                    index = data.prov;
                    console.log("index: " + index);
                    $('#bar_select'+index).empty()
                        .append($('<option>', {
                                value: '',
                                text : 'Select Barangay...',
                                selected: 'true'
                            }
                        ));
                    jQuery.each(data.barangay, function(i,val){
                        $('#bar_select'+index).append($('<option>', {
                            value: val.id,
                            text : val.description
                        }));
                    });
                    $('#bar_select'+prov_id).trigger('change');
                }
            });
        } else {
            $('#dl_btn'+prov_id).attr('disabled', true);
            $('#bar_select'+prov_id).empty().append($('<option>', {
                    value: '',
                    text : 'Select Barangay...'
                }
            )).trigger('change');
        }
    }

    function setBarangay(prov_id) {
        var bar = $('#bar_select'+prov_id).val();
        $('#barangay'+prov_id).val(bar);
        if(bar !== '') {
            $('#dl_btn'+prov_id).attr('disabled', false);
        } else {
            muncity_id = $('#muncity_select'+prov_id).val();
            if(muncity_id === '63' || muncity_id === '80' || muncity_id === '76') {
                $('#dl_btn' + prov_id).attr('disabled', true);
            }
        }
    }

    function showDetails(prov_id) {
        var muncity = $('#municipality'+prov_id).val();
        var barangay = $('#barangay'+prov_id).val();
        console.log('barangay: ' + barangay);
        if(barangay === '') {
            barangay = 0;
        }
        if(muncity !== '' && muncity !== null) {
            $('.details_body').html(loadingState);
            $('#details_btn'+prov_id).attr('href','#stat_details');

            var link = "{{ asset('admin/report/statdetails') }}";
            link += '/'+muncity+'/'+barangay;
            console.log('link: ' + link);
            $.ajax({
                url: link,
                type: 'GET',
                success: function(data){
                    $('.details_body').html(data);
                }
            });
        } else {
            $('#stat_details').modal('hide');
            $('#details_btn'+prov_id).attr('href','');
        }
    }
</script>