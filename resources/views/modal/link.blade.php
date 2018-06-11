<?php
    $status_dengvaxia = \App\dengvaxia\Profile::where('tsekap_id',$info->profile_id)->orderBy('id','desc')->first();
?>
<div class="modal fade" role="dialog" id="link">
    <div class="modal-dialog modal-sm" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4><i class="fa fa-user-md"></i> SELECT PROGRAM</h4>
            </div>
            <div class="modal-body">
                <a href="{{ url('user/malasakit/add/'.$info->profile_id) }}" class="btn btn-primary btn-block">
                    Malasakit Center
                </a>
                @if(!$status_dengvaxia)
                <a href="{{ url('user/dengvaxia/add/'.$info->profile_id) }}" class="btn btn-warning btn-block">
                    Dengvaxia Patients
                </a>
                @else
                    @if($status_dengvaxia->status=='pending' || $status_dengvaxia->status=='refuse')
                        <div class="btn btn-block" style="border:2px solid #d58512;">
                            <div class="text-center">
                                <span class="text-warning">
                                    <strong>Dengvaxia Status : {{ strtoupper($status_dengvaxia->status) }}</strong>
                                </span>
                            </div>
                        </div>
                    @endif
                @endif
            </div>
            <div class="modal-footer"></div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->