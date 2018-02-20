<?php
    use App\Bracket;
    use App\Barangay;
    use App\Service;
    use App\UserBrgy;

    $bracket = Bracket::orderBy('id','asc')->get();
    $barangay = Barangay::where('muncity_id',Auth::user()->muncity);

    if(Auth::user()->user_priv==2){
        $tmpBrgy = UserBrgy::where('user_id',Auth::user()->id)->get();
        $barangay = $barangay->where(function($q) use ($tmpBrgy){
            foreach($tmpBrgy as $tmp){
                $q->orwhere('id',$tmp->barangay_id);
            }
        });
        if(count($tmpBrgy)==0){
            $barangay = $barangay->where('id',0);
        }
    }
    $barangay = $barangay->orderBy('description','asc')->get();
    $service = Service::orderBy('description','asc')->get();
?>
<span id="url" data-link="{{ asset('date_in') }}"></span>
<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Filter Result</h3>
        </div>
        <div class="panel-body">
            <form class="form-inline" method="POST" action="{{ asset('user/report') }}">
            {{ csrf_field() }}
                <table width="100%">
                    <tr>
                        <td>
                            <label>Select Year</label>
                            <?php $years = \App\Http\Controllers\ParameterCtrl::getYear(); ?>
                            <select name="year" class="form-control" style="width: 100%">
                                @foreach($years as $y)
                                    <option {{ ($year==$y) ? 'selected' : '' }}>{{ $y }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td><br />
                            <label>From</label>
                            <?php
                                $months = \App\Http\Controllers\ParameterCtrl::getMonth();
                                $i = 1;
                                if(!$monthF){
                                    $monthF = 1;
                                }
                            ?>
                            <select name="monthF" class="monthF form-control" style="width: 100%">
                                @foreach($months as $m)
                                    <option {{ ($monthF==$i) ? 'selected' : '' }} value="{{ $i }}">{{ $m }}</option>
                                    <?php $i++; ?>
                                @endforeach
                            </select>
                        </td>
                    </tr>

                    <tr>
                        <td><br />
                            <label>To</label>
                            <?php
                                $months = \App\Http\Controllers\ParameterCtrl::getMonth();
                                $i = 1;
                                if(!$monthT){
                                    $monthT = 12;
                                }
                            ?>
                            <select name="monthT" class="monthT form-control" style="width: 100%">
                                @foreach($months as $m)
                                    <option {{ ($monthT==$i) ? 'selected' : '' }} value="{{ $i }}">{{ $m }}</option>
                                    <?php $i++; ?>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <hr />
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label>Name</label>
                            <div class="input-group col-xs-12">
                                <div class="input-group-addon">
                                    <i class="fa fa-user"></i>
                                </div>
                                <input type="text" class="form-control" name="name" value="{{ $name }}" placeholder="Input name" autocomplete="off">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br>
                            <label>Age Bracket</label>
                            <select name="bracket_id" class="form-control" style="width: 100%">
                                <option value="">Select All</option>
                                @foreach($bracket as $b)
                                <option value="{{ $b->id }}"
                                    @if($bracket_id==$b->id)
                                        selected
                                    @endif
                                >{{ $b->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <label>Barangay</label>
                            <select name="barangay_id" class="form-control" style="width: 100%">
                                <option value="">Select All</option>
                                @foreach($barangay as $b)
                                <option value="{{ $b->id }}"
                                    @if($barangay_id==$b->id)
                                        selected
                                    @endif
                                >{{ $b->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <label>Service Availed</label>
                            <select name="service_id" class="form-control" style="width: 100%">
                                <option value="">Select All</option>
                                @foreach($service as $s)
                                <option value="{{ $s->id }}"
                                    @if($service_id==$s->id)
                                        selected
                                    @endif
                                >{{ $s->description }}</option>
                                @endforeach
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <br />
                            <button type="submit" class="btn btn-success col-xs-12"><i class="fa fa-filter"></i> Filter</button>
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>
</div>
