<style>
    #tayong tr td:first-child {
        background: #f5f5f5;
        text-align: right;
        vertical-align: middle;
        font-weight: bold;
        padding: 3px;
        width:30%;
    }
</style>
<div>
    @if(count($dengvaxia))
        <table class="table table-hover table-striped" id="tayong">
            <thead>
            <tr>
                <th></th>
                <th>FullName</th>
                <th>Gender</th>
                <th>Age</th>
                <th>Platform</th>
            </tr>
            </thead>
            <tbody>
            <?php $fullname = $dengvaxia->lname.', '.$dengvaxia->fname.' '.$dengvaxia->mname; ?>
            <tr>
                <td style="width: 10%">
                    <a href="{{ asset('form_dengvaxia').'/'.$dengvaxia->id.'/'.$unique_id.'/'.$tsekap_id }}" class="btn btn-xs btn-info">
                        <i class="fa fa-user-plus"></i> Update
                    </a>
                    <a href="#" data-backdrop="static" style="width: 100%;text-align: left" class="btn btn-xs btn-success" onclick="print_dengvaxia()">
                        <i class="fa fa-print"></i>  Print
                    </a>
                </td>
                <td>
                    <a href="#"><font class="title-info">{{ mb_substr($fullname, 0, 30)  }}</font></a><br />
                    <small class="text-info">
                        {{ \App\Barangay::find($dengvaxia->barangay_id)->description }},
                        {{ \App\Muncity::find($dengvaxia->muncity_id)->description }},
                        {{ \App\Province::find($dengvaxia->province_id)->description }}
                    </small>
                </td>
                <td>{{ $dengvaxia->sex }}</td>
                <td>{{ $dengvaxia->gen_age }}</td>
                <td style="color: #ff3774"><b>{{ $dengvaxia->platform }}</b></td>
            </tr>
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found! Click here to add new...
                <a href="{{ asset('form_dengvaxia_add').'/'.$unique_id.'/'.$tsekap_id }}" target="_blank" style="color: #ff5862">
                    <i class="fa fa-arrow-right"></i> <i class="fa fa-arrow-right"></i> <b>ADD</b>
                </a>
            </p>
        </div>
    @endif
</div>

<script>
    function print_dengvaxia(){
        var unique_id = "<?php echo $unique_id ?>";
        console.log(unique_id);
        event.preventDefault();
        $.get("<?php echo asset('sessionProcessPrint').'/' ?>"+unique_id,function(result){
            var win = window.open("<?php echo asset('print/print_dengvaxia_form.php'); ?>");
            if (win) {
                win.focus();
            } else {
                //Browser has blocked it
                alert('Please allow popups for this website');
            }
        });
    }
</script>