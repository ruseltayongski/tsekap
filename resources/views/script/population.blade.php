<script>
    $('a[href="#familyProfile"]').on('click',function(){
        <?php echo 'var url="'.asset('user/population/member').'";';?>
        var id = $(this).data('id');
        $('.family-list').html('<center><img src="<?php echo asset('resources/img/spin.gif');?>" width="100"></center>');
        $.ajax({
            url: url+'/'+id,
            type: 'GET',
            success: function(jim){
                var content = '<ul class="list-group">';
                jQuery.each(jim.members,function(i,val){
                    console.log(val);
                    var headClass = 'list-group-item-success';
                    var genderClass = 'text-danger';
                    if(val.head=='NO'){
                        headClass='';
                    }
                    if(val.sex=='Male')
                    {
                        genderClass = 'text-success';
                    }
                    content += '<li class="list-group-item '+headClass+' '+genderClass+'">';
                    var url2 = "{{  asset ('user/population/info') }}";
                    url2 += "/" + val.id;
                    content += '<a href="'+url2;
                    if(val.deceased === 'yes') {
                        content += '" class="text-red';
                    }
                    content += '">' +val.lname+', '+val.fname+' '+val.mname+' '+val.suffix + '</a>';
                    content += '<br/><small>('+val.relation+', '+val.sex+')';
                    if(val.deceased === 'yes') {
                        content += ' <i class="text-red"> (Deceased)</i>';
                    }
                    content += '</small>';
                    var unmet = val.unmet;
                    if(unmet === 0) {
                        unmet = "Not set";
                    }
                    var age = ~~((new Date()-new Date(val.dob))/(31556952000));
                    if(age >= 15 && age <= 50) {
                        content += '<br><small>Unmet need: '+unmet+'</small>';
                    }
                    content += '</li>';
                });
                content += '</ul>';

                content += '<ul class="list-group family">';
                content += '<li class="list-group-item"><label>Monthly Family Income:</label><br />';
                content += '<span class="info">'+jim.details.income+'</span>';
                content += '<br/><span class="sub-info">('+jim.details.familyClass+')</span>';
                content += '</li>';

//                content += '<li class="list-group-item"><label>Unmet Need : </label>';
//                content += '<span class="info"> '+jim.details.unmet+' </span>';
//                content += '</li>';

                content += '<li class="list-group-item"><label>Safe Water Supply : </label>';
                content += '<span class="info"> '+jim.details.water+' </span>';
                content += '</li>';

                content += '<li class="list-group-item"><label>Sanitary Toilet : </label>';
                content += '<span class="info"> '+jim.details.toilet+' </span>';
                content += '</li>';

                content += '</ul>';
                console.log(jim.details);
                $('.family-list').html(content);
            }
        });

    });
</script>