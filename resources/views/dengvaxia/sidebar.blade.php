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
            <form class="form-inline form-submit" method="POST" action="{{ asset($sidebar) }}">
                {{ csrf_field() }}
                <table width="100%">
                    @if($sidebar=='dengvaxia/profile')
                    <tr>
                        <td>
                            <label>Name</label>
                            <input type="text" class="form-control" name="name" autofocus style="width: 100%" value="{{ $post->name }}" />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <label>Linked</label>
                            <select name="linked" class="form-control chosen-select" style="width: 100%">
                                <option value="">Select All</option>
                                <option value="yes" {{ ($post->linked=='yes') ? 'selected':'' }}>Yes</option>
                                <option value="no" {{ ($post->linked=='no') ? 'selected':'' }}>No</option>
                            </select>
                        </td>
                    </tr>
                    @endif
                    <tr>
                        <td>
                            <br />
                            <label>Provinces</label>
                            <select name="province_id" class="form-control chosen-select filterProvince" id="province" style="width: 100%">
                                <option value="">Select All</option>
                                @foreach($provinces as $p)
                                    <option value="{{ $p->id }}"
                                        @if($p->id == $post->province_id)
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
                            <select name="muncity_id" class="form-control chosen-select filterMuncity" style="width: 100%">
                                <option value="">Select All...</option>

                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <button type="submit" class="btn btn-success col-xs-12 btn-submit"><i class="fa fa-search"></i> Search</button>
                        </td>
                    </tr>
                    @if($sidebar=='dengvaxia/profile')
                    <tr>
                        <td style="padding-top: 10px;">
                            <a href="{{ url('dengvaxia/link') }}" class="btn btn-warning col-xs-12 btn-submit"><i class="fa fa-link"></i> Link Dengvaxia Profiles</a>
                        </td>
                    </tr>
                    @else
                    <tr>
                        <td style="padding-top: 10px;">
                            <a href="{{ url('dengvaxia/profile') }}" class="btn btn-warning col-xs-12 btn-submit"><i class="fa fa-group"></i> Dengvaxia Profiles</a>
                        </td>
                    </tr>
                    @endif
                </table>
            </form>
        </div>
    </div>
</div>
