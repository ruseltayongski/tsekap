<div class="modal fade" role="dialog" id="update_target">
    <div class="modal-dialog modal-md" role="document">
        <div class="modal-content">
            <div class="modal-body target_body">
                <form action="{{ asset('population/update') }}" method="POST">
                    {{ csrf_field() }}
                    <input type="hidden" name="barangay_id" id="barangay_id">
                    <fieldset>
                        <legend><i class="fa fa-pencil"></i> Update Target Population</legend>
                    </fieldset>
                    <div class="form-group">
                        <label>Barangay:</label>
                        <input type="text" class="form-control" style="background-color: white" id="barangay_name" name="barangay_name" required readonly>
                    </div>
                    <div class="form-group">
                        <label>Target Population:</label>
                        <input class="form-control" id="target_count" oninput="formatTarget()" type="text" name="target">
                    </div>
                    <div class="pull-right">
                        <button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> Cancel </button>
                        <button type="submit" class="btn btn-success btn-sm buttonsubmit"><i class="fa fa-check"></i> Update </button>
                    </div><br><br>
                </form>
            </div><!-- /.modal-content -->
        </div>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->

{{--<div class="modal fade" role="dialog" id="delete_target">--}}
    {{--<div class="modal-dialog modal-sm" role="document">--}}
        {{--<div class="modal-content">--}}
            {{--<div class="modal-body">--}}
                {{--<form action="{{ asset('population/target/delete') }}" method="POST">--}}
                    {{--{{ csrf_field() }}--}}
                    {{--<input type="hidden" name="id_delete" id="id_delete">--}}
                    {{--<fieldset>--}}
                        {{--<legend><i class="fa fa-trash"></i> Reset Target Population</legend>--}}
                    {{--</fieldset>--}}
                    {{--<div class="alert alert-danger">--}}
                        {{--<label for="" class="text-danger">Are you sure you want to reset--}}
                            {{--<b><small id="bar_desc_delete"></small>'s</b> target population?--}}
                        {{--</label>--}}
                    {{--</div>--}}
                    {{--<div class="modal-footer">--}}
                        {{--<button type="button" class="btn btn-default btn-sm" data-dismiss="modal"><i class="fa fa-times"></i> No</button>--}}
                        {{--<button type="submit" class="btn btn-danger btn-sm"><i class="fa fa-check"></i> Yes</button>--}}
                    {{--</div>--}}
                {{--</form>--}}
            {{--</div><!-- /.modal-content -->--}}
        {{--</div>--}}
    {{--</div><!-- /.modal-dialog -->--}}
{{--</div><!-- /.modal -->--}}

<script>
    function formatTarget(){
        str = $('#target_count').val();
        str = str.replace(/[^0-9]/g, '');
        final = str.replace(/(\d)(?=(\d\d\d)+(?!\d))/g, "$1,");
        $('#target_count').val(final);
    }
</script>