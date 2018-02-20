<script src="{{ asset('resources/assets/js/jquery.min.js') }}"></script>
<script>
    $('.loading').show();
    function senddata(filename,table){
        var file = filename;
        <?php echo 'var link="'.asset('user/report/send').'";';?>
        $.ajax({
            type: "GET",
            url: link+'/'+file+'/'+table,
            async: true,
            success: function(result){
                console.log(result);
            },
            error: function(){
                console.log(file);
            }
        });
    }
</script>

<?php
    use App\FamilyProfile;
    use Illuminate\Support\Facades\DB;
    $csv = array();
    $batchsize = 500;
    if($_FILES['file']['error'] == 0){
        $name = $_FILES['file']['name'];
        $ext = pathinfo($name, PATHINFO_EXTENSION);
        $tmpName = $_FILES['file']['tmp_name'];

        $addProfile = 0;
        $addService = 0;
        $addCase = 0;
        $addStatus = 0;
        $addServiceOption = 0;
        $user_id = Auth::user()->id;

        if($ext === 'DOH7'){
            if(($handle = fopen($tmpName, 'r')) !== FALSE){
                set_time_limit(0);
                $row=0;
                while(($data = fgetcsv($handle)) !== FALSE){
                    $col_count = count($data);
                    if($row % $batchsize == 0):
                        $file = fopen("minpoints$user_id$row.csv","w");
                    endif;

                    if($data[0]=='PROFILE')
                    {
                        $addProfile++;
                        continue;
                    }else if($data[0]=='SERVICES'){
                        $addProfile = 0;
                        $addService++;
                        continue;
                    }else if($data[0]=='CASES'){
                        $addService = 0;
                        $addCase++;
                        continue;
                    }else if($data[0]=='STATUS'){
                        $addCase = 0;
                        $addStatus++;
                        continue;
                    }else if($data[0]=='SERVICE OPTION'){
                        $addStatus = 0;
                        $addServiceOption++;
                        continue;
                    }

                    if($data[0]=='FAMILY ID' && $addProfile==1){
                        $addProfile++;
                        continue;
                    }else if($data[0]=='DATE CREATED' && $addService==1){
                        $addService++;
                        continue;
                    }else if($data[0]=='DATE CREATED' && $addStatus==1){
                        $addStatus++;
                        continue;
                    }else if($data[0]=='DATE CREATED' && $addCase==1){
                        $addCase++;
                        continue;
                    }else if($data[0]=='DATE CREATED' && $addServiceOption==1){
                        $addServiceOption++;
                        continue;
                    }
                    $profile = false;
                    if($addProfile==2 && $data[0]!=null){
                        $csv[$row]['col1'] = $data[10];
                        $csv[$row]['col2'] = $data[0];
                        $json = "'$data[10]','$data[0]'";
                        $q = "select id from familyprofile where description='$data[0]' and muncity_id='$data[10]'";

                        fwrite($file,$json.PHP_EOL);
                        if($row % $batchsize == 0):
                            echo "<script> senddata('minpoints$user_id$row.csv','familyprofile'); </script>";
                        endif;

                        $row++;
                    }

                    if($addProfile==2 && $profile){
                        $csv[$row]['col1'] = $data[0];
                        $csv[$row]['col2'] = $data[1];
                        $csv[$row]['col3'] = $data[2];
                        $csv[$row]['col4'] = $data[3];
                        $csv[$row]['col5'] = $data[4];
                        $csv[$row]['col6'] = $data[5];
                        $csv[$row]['col7'] = $data[6];
                        $csv[$row]['col8'] = $data[7];
                        $csv[$row]['col9'] = $data[8];
                        $csv[$row]['col10'] = $data[9];
                        $csv[$row]['col11'] = $data[10];
                        $csv[$row]['col12'] = $data[11];

                        $id = 0;

                        $json = "'$id','$data[1]','$data[2]','$data[3]','$data[4]','$data[5]','$data[6]','$data[7]','$data[8]','$data[9]','$data[10]','$data[11]'";
                        fwrite($file,$json.PHP_EOL);
                        if($row % $batchsize == 0):
                            echo "<script> senddata('minpoints$user_id$row.csv','profile'); </script>";
                        endif;
                        $row++;
                    }

                }
                fclose($file);
                fclose($handle);
            }else{
                echo 'Only DOH7 files are allowed!';
            }
           // echo "<script>$('.loading').hide();</script>";
        }
    }
?>
@extends('client')
@section('content')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Uploading Report...</h2>
            <div class="page-divider"></div>

        </div>
    </div>
    @include('sidebar')
@endsection

@section('js')
    <?php
    $status = session('status');
    ?>
    @if($status=='updated')
        <script>
            Lobibox.notify('success', {
                msg: 'Password successfully changed!'
            });
        </script>
    @endif
@endsection