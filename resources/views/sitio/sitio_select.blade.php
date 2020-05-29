<form action="{{ asset('sitio/select/post') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="familyID" value="{{ $familyID }}">
    <div class="modal-body">
        @if(count($sitio) >= 1)
        <table class="table table-hover table-striped">
            <tr>
                <td>Sitio</td>
                <td>
                    <select name="sitio_id" class="form-control" required>
                        @foreach($sitio as $row)
                            <option value="{{ $row->sitio_id }}" <?php if($row->sitio_id == $sitio_choose) echo 'selected'; ?>>{{ $row->sitio_name }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
        </table>
        @else
            <div class="alert alert-info text-blue">
                <i class="fa fa-info-circle"></i> Base the barangay on this profile, No directory found on this sitio
            </div>
        @endif
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-sm btn-default" data-dismiss="modal">Close</button>
        @if(count($sitio) >= 1)
        <button type="submit" class="btn-sm btn-success">Select</button>
        @endif
    </div>
</form>