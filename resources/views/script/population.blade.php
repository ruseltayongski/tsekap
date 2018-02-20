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
                    content += val.lname+', '+val.fname+' '+val.mname+' '+val.suffix;
                    content += '<br/><small>('+val.relation+', '+val.sex+')</small>';
                    content += '</li>';
                });
                content += '</ul>';

                content += '<ul class="list-group family">';
                content += '<li class="list-group-item"><label>Month Family Income:</label><br />';
                content += '<span class="info">'+jim.details.income+'</span>';
                content += '<br/><span class="sub-info">('+jim.details.familyClass+')</span>';
                content += '</li>';

                content += '<li class="list-group-item"><label>Unmet Need : </label>';
                content += '<span class="info"> '+jim.details.unmet+' </span>';
                content += '</li>';

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