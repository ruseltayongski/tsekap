<form action="{{ asset('sitio/add') }}" method="POST">
    {{ csrf_field() }}
    <input type="hidden" name="sitio_id" value="<?php if(isset($sitio->sitio_id)) echo $sitio->sitio_id; ?>">
    <div class="modal-body">
        <table class="table table-hover table-striped">
            <tr>
                <td>Barangay</td>
                <td>
                    <select name="barangay_id" id="" class="form-control" required>
                        @if(!isset($sitio))<option value="">Select Option</option>@endif
                        @foreach($user_brgy as $brgy)
                            <option value="{{ $brgy->barangay_id }}" <?php if(isset($sitio->sitio_barangay_id)){if($sitio->sitio_barangay_id==$brgy->barangay_id) echo 'selected';} ?> >{{ \App\Barangay::find($brgy->barangay_id)->description }}</option>
                        @endforeach
                    </select>
                </td>
            </tr>
            <tr>
                <td>Name</td>
                <td><input type="text" name="name" value="<?php if(isset($sitio->sitio_name)) echo $sitio->sitio_name; ?>" class="form-control" required></td>
            </tr>
            <tr>
                <td>Target</td>
                <td><input type="number" name="target" value="<?php if(isset($sitio->sitio_target)) echo $sitio->sitio_target; ?>" class="form-control"></td>
            </tr>
        </table>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn-sm btn-default" data-dismiss="modal">Close</button>
        <button type="submit" class="btn-sm btn-success">Save changes</button>
        @if(isset($sitio->sitio_id))
            @if($sitio->sitio_id)
                <button type="button" class="btn-sm btn-danger" onclick="removeSitio({{ $sitio->sitio_id }})">Remove</button>
            @endif
        @endif
    </div>
</form>