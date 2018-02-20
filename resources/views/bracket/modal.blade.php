<?php
    use App\Bracket;
    use App\Service;

    $brackets = Bracket::orderBy('id','asc')->get();
    $services = Service::orderBy('description','asc')->get();
?>
<div class="modal fade" tabindex="-1" role="dialog" id="assignService">
    <div class="modal-dialog modal-sm" role="document">
        <form method="POST" action="{{ asset('bracket/assign') }}">
            {{ csrf_field() }}
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class=""><i class="fa fa-stethoscope"></i> Assign Services</h4>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Age Bracket</label>
                        <select name="bracket" class="chosen-select form-control form-submit" required>
                            <option value="">Select Age Bracket...</option>
                            @foreach($brackets as $b)
                            <option value="{{ $b->id }}"
                                @if(Session::get('bracket_id')==$b->id)
                                    selected
                                @endif
                            >{{ $b->description }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label>Services</label>
                        <select name="services" class="chosen-select form-control" required>
                            <option value="">Select Services...</option>
                            @foreach($services as $s)
                                <option value="{{ $s->id }}">{{ $s->description }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal"><i class="fa fa-times"></i> Cancel</button>
                    <button type="submit" class="btn btn-success btn-submit"><i class="fa fa-pencil"></i> Update</button>
                </div>
            </div><!-- /.modal-content -->
        </form>
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
