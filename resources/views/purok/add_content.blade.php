<form action="{{ asset('purok/add') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="purok_id" value="<?php if(isset($purok->purok_id)) echo $purok->purok_id; ?>">
    <div class="modal-body">
        <table class="table table-hover table-striped">
            <tr>
                <td>Barangay</td>
                <td>
                    <select name="barangay_id" id="" class="form-control" required>
                        @if(!isset($purok))<option value="">Select Option</option>@endif
                        @foreach($user_brgy as $brgy)
                            <option value="{{ $brgy->barangay_id }}" <?php if(isset($purok->purok_barangay_id)){if($purok->purok_barangay_id==$brgy->barangay_id) echo 'slected';} ?> >{{ \App\Barangay::find($brgy->barangay_id)->description }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="<?php if(isset($purok->purok_name)) echo $purok->purok_name; ?>" class="form-control" required></td>
            </tr>
            <tr>
                <td>Target</td>
                <td><input type="number" name="target" value="<?php if(isset($purok->purok_target)) echo $purok->purok_target; ?>" class="form-control"></td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-sm btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn-sm btn-success">Save changes</button>
        @if(isset($purok->purok_id))
            @if($purok->purok_id)
            <button type="button" class="btn-sm btn-danger" onclick="removePurok({{ $purok->purok_id }})">Remove</button>
            @endif
        @endif
    </div>
</form>