<?php
$user = Auth::user();
?>

@extends($dashboard)

@section('content')
    <div class="col-md-12">
        <span> <b style="font-size: 20px">LIST OF FACILITIES</b>
            <div class="pull-right">
                <form action="{{ asset('facility') }}" method="POST" class="form-inline">
                    {{ csrf_field() }}
                    <div class="form-group" style="margin-bottom: 10px;">
                        <input type="text" class="form-control" placeholder="Search name..." name="keyword" value="{{ Session::get("keyword") }}" >
                        <button type="submit" class="btn btn-success btn-flat">
                            <i class="fa fa-search"></i> Search
                        </button>
                        <button type="submit" value="view_all" name="view_all" class="btn btn-warning btn-flat">
                            <i class="fa fa-eye"></i> View All
                        </button>
                        @if($user->user_priv == 0 || $user->user_priv == 2)
                            <a href="#facility_modal" data-toggle="modal" class="btn btn-info btn-flat" onclick="FacilityBody('')">
                                <i class="fa fa-hospital-o"></i> Add Facility
                            </a>
                        @endif
                    </div>
                </form>
            </div>
        </span>
    </div><br><br><br>

    @if(count($data)>0)
        <div class="table-responsive" style="background-color: whitesmoke; padding: 0.5px; width:100%; overflow-x: scroll">
            <table class="table table-fixed-header table-bordered table-striped table-hover" style="width:100%;">
                <thead class="header">
                    <tr class="bg-black-gradient">
                        <th style="vertical-align: middle;">Facility Name</th>
                        <th style="vertical-align: middle;">Facility Code</th>
                        <th style="vertical-align: middle;">Contact</th>
                        <th style="vertical-align: middle;">Email</th>
                        <th style="white-space: nowrap; vertical-align: middle;">Clinic Hours / Schedule</th>
                        <th style="white-space: nowrap; vertical-align: middle;">Head of Facility</th>
                        <th style="white-space: nowrap; vertical-align: middle;">Service Capability</th>
                        <th style="vertical-align: middle;">Available Services</th>
                        <th style="vertical-align: middle;">Ownership</th>
                        <th style="white-space: nowrap; vertical-align: middle;">PHIC <br>Accreditation Status</th>
                        <th style="white-space: nowrap;vertical-align: middle;">Availability and <br> Type of Transport</th>
                        <th style="white-space: nowrap; vertical-align: middle;">E-Referral <br>Hospital Status</th>
                    </tr>
                </thead>
                @foreach($data as $row)
                    <tr>
                       <th style="position: sticky; left: 0; z-index: 0; background-color: white">
                            <b>
                                @if($user->user_priv == 0 || $user->user_priv == 2)
                                    <a
                                        href="#facility_modal"
                                        data-toggle="modal"
                                        data-id = "{{ $row->id }}"
                                        onclick="FacilityBody('<?php echo $row->id ?>', '<?php echo $row->facility_code;?>')"
                                        class="update_info"
                                    >
                                        {{ $row->name }}
                                    </a>
                                @else
                                    <span class="text-info"> {{ $row->name }}</span>
                                @endif
                            </b><br>
                            <small class="text-success">
                                (
                                <?php
                                isset($row->muncity) ? $comma_mun = "," : $comma_mun = " ";
                                isset($row->barangay) ? $comma_bar = "," : $comma_bar = " ";
                                !empty($row->address) ? $concat_addr = " - " : $concat_addr = " ";

                                echo $row->province.$comma_mun.$row->muncity.$comma_bar.$row->barangay.$concat_addr.$row->address;
                                ?>
                                )
                            </small>
                        </th>
                        <td>
                            <b class="text-green">{{ $row->facility_code }}</b>
                        </td>
                        <td><small>{{ $row->contact }}</small></td>
                        <td><small>{{ $row->email }}</small></td>
                        <td style="overflow-wrap: break-word;">
                            @if($row->sched_day_from)
                                <small>{{ $row->sched_day_from }} to {{ $row->sched_day_to }} <br>
                                    @if($row->sched_time_from)
                                        {{ date('h:i a', strtotime($row->sched_time_from)) }} - {{ date('h:i a', strtotime($row->sched_time_to)) }}
                                    @endif
                                </small>
                                <br><br>
                            @endif
                            @if($row->sched_notes)
                                <small class="text-success"><i>{{ $row->sched_notes }}</i> </small>
                            @endif
                        </td>
                        <td><small>{{ $row->chief_hospital }}</small></td>
                        <td> {{--Service Capability--}}
                            <small>{{ $row->service_cap }}</small>
                        </td>
                        <td style="white-space: nowrap;"> {{--Available Services--}}
                            <?php
                            $prev_type = '';
                            foreach($avail_services as $s) {
                                if($s->facility_code == $row->facility_code) {
                                    if($prev_type != $s->type) {
                                        echo "<small><b>".$s->type.":</b></small><br>";
                                        $prev_type = $s->type;
                                    }
                                    if($s->service == 'Pharmacy')
                                        echo "<li> <small> $s->service </small></li>";
                                    else
                                        echo "<li> <small> $s->service - $s->costing </small></li>";
                                }
                            } ?>
                        </td>
                        <td>
                            <small><span>
                                @if($row->hospital_type == 'priv_birthing_home')
                                    Private Birthing Home
                                @elseif($row->hospital_type != 'private' && $row->hospital_type != 'government' && isset($row->hospital_type))
                                    (Government)
                                    @if($row->hospital_type == 'gov_birthing_home')
                                        Birthing Home
                                    @elseif($row->hospital_type == 'doh_hospital')
                                        DOH Hospital
                                    @elseif($row->hospital_type == 'lgu_owned')
                                        LGU Owned
                                    @elseif($row->hospital_type == 'city_owned')
                                        City Owned
                                    @else
                                        {{ ucfirst($row->hospital_type) }}
                                    @endif
                                @else
                                    {{ ucfirst($row->hospital_type) }}
                                @endif
                            </span></small>
                        </td>
                        <td> {{--PHIC ACCREDIATION STATUS--}}
                            <small>{{ $row->phic_status }}</small>
                        </td>
                        <td> {{--Availability and Type of Transport--}}
                            <small>{{ $row->transport }}</small>
                        </td>
                        <td>
                            <span class="text-center {{ $row->status ? 'badge bg-blue' : 'badge bg-red' }}">{{ $row->status ? 'Active' : 'Inactive' }}</span>
                        </td>
                    </tr>
                @endforeach
            </table>
            <div class="text-center">
                {{ $data->links() }}
            </div>
        </div>
    @else
        <div class="alert alert-warning">
            <span class="text-warning">
                <i class="fa fa-warning"></i> No Facility found!
            </span>
        </div>
    @endif
    <br><br>

    @include('facility.facility_modal')
@endsection

@section('js')
    <script>
        $(document).ready(function(){
            $('.table-fixed-header').fixedHeader();
        });

        <?php $user = Session::get('auth'); ?>
        function FacilityBody(data, code){
            console.log("code: " + code);
            $.ajax({
                url: "<?php echo asset('facility/body') ?>",
                type: 'GET',
                data: { "facility_id": data, "facility_code": code},
                success: function (data) {
                   $('.facility_body').html(data);
                }
            });
        }

        function FacilityDelete(facility_id){
            $(".facility_id").val(facility_id);
        }

        @if(Session::get('facility'))
        Lobibox.notify('success', {
            title: "",
            msg: "<?php echo Session::get("facility_message"); ?>",
            size: 'mini',
            rounded: true
        });
        <?php
        Session::put("facility",false);
        Session::put("facility_message",false)
        ?>
        @endif
    </script>
@endsection