<form action="{{ asset('purok/add') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="purok_id" value="{{ $purok->purok_id }}">
    <div class="modal-body">
        <table class="table table-hover table-striped">
            <tr>
                <td>Barangay</td>
                <td>
                    <select name="barangay_id" id="" class="form-control">
                        @if(!isset($purok))<option value="">Select Option</option>@endif
                        @foreach($user_brgy as $brgy)
                            <option value="{{ $brgy->barangay_id }}" @if($purok->purok_barangay_id==$brgy->barangay_id){{ 'selected' }}@endif >{{ \App\Barangay::find($brgy->barangay_id)->description }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="{{ $purok->purok_name }}" class="form-control"></td>
            </tr>
            <tr>
                <td>Target</td>
                <td><input type="number" name="target" value="{{ $purok->purok_target }}" class="form-control"></td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-sm btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn-sm btn-success">Save changes</button>
        @if($purok->purok_id)
        <button type="button" class="btn-sm btn-danger" onclick="removePurok({{ $purok->purok_id }})">Remove</button>
        @endif
    </div>
</form>