<?php
use App\Province;
$provinces = Province::orderBy('description','asc');
$user= Auth::user();
if($user->user_priv==3){
    $provinces = $provinces->where('id',$user->province);
}
$provinces = $provinces->get();
?>
<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Filter Result</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline form-submit" method="POST" action="{{ asset('download') }}">
                {{ csrf_field() }}
                <table width="100%">
                    <tr>
                        <td>
                            <label>Provinces</label>
                            <select name="province_id" class="form-control select2 filterProvince" id="province" style="width: 100%" required>
                                <option value="">Select Province</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->id }}"
                                            @if($province_id==$p->id)
                                            selected
                                            @endif
                                    >{{ $p->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <label>Municipality / City</label>
                            <select name="muncity_id" class="form-control select2 filterMuncity" style="width: 100%" required>
                                <option value="">Select Municipality / City</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <button type="submit" class="btn btn-success col-sm-12 btn-submit"><i class="fa fa-filter"></i> Filter</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
