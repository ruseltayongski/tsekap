<script>
    $('input[type="checkbox"]').on('change',function(){
        var status = this.checked ? true : false;
        var code = $(this).data('code');

        if(code=='WM'){
            if(status==true){
                $('.weight_option').removeClass('hide');
            }else{
                $('.weight_option').addClass('hide');
            }
        }
        if(code=='HM'){
            if(status==true){
                $('.height_option').removeClass('hide');
            }else{
                $('.height_option').addClass('hide');
            }
        }
        if(code=='BP'){
            if(status==true){
                $('.bp_option').removeClass('hide');
            }else{
                $('.bp_option').addClass('hide');
            }
        }
        console.log(code);
    });
</script>