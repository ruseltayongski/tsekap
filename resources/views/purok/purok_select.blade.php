<form action="{{ asset('purok/select/post') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="familyID" value="{{ $familyID }}">
    <div class="modal-body">
        @if(count($purok) >= 1)
            <table class="table table-hover table-striped">
                <tr>
                    <td>Purok</td>
                    <td>
                        <select name="purok_id" class="form-control" required>
                            @foreach($purok as $row)
                                <option value="{{ $row->purok_id }}" <?php if($row->purok_id == $purok_choose) echo 'selected'; ?>>{{ $row->purok_name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            </table>
        @else
            <div class="alert alert-info text-blue">
                <i class="fa fa-info-circle"></i> Base the barangay on this profile, No directory found on this purok
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-sm btn-default" data-dismiss="modal">Close</button>
        @if(count($purok) >= 1)
            <button type="submit" class="btn-sm btn-success">Select</button>
        @endif
    </div>
</form>