<?php
use App\Muncity;
use App\Province;
use App\Barangay;
$muncity = Muncity::where('province_id',1)
        ->orderBy('description','asc')
        ->get();
$barangay = Barangay::where('province_id',1)
        ->orderBy('muncity_id','asc')
        ->orderBy('description','asc')
        ->get();
?>
        <!DOCTYPE html>
<html>
<head>
    <title>Tsekap Report</title>
    <link href="{{ asset('resources/assets/css/bootstrap.min.css') }}" rel="stylesheet">
    <style>
        body {
            background: #c0c0c0;
        }
        .wrapper {
            margin-top: 30px;
        }
    </style>
</head>
<body>
<div class="col-xs-8 col-xs-offset-2 alert wrapper" style="background: white;">
    <h3>User Accounts</h3>
    <hr />
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
            <tr>
                <th>Municipality / City</th>
                <th>Barangay</th>
                <th>Username</th>
                <th>Password</th>
            </tr>
            </thead>
            <tbody>
            <?php
            $holder = 0;
            $count = 1;

            ?>
            @foreach($barangay as $m)
                <tr>
                    <td>
                        @if($holder!=$m->muncity_id)
                            {{ Muncity::find($m->muncity_id)->description }}
                            <?php $holder = $m->muncity_id; ?>
                        @endif
                    </td>
                    <td>{{ $m->description }}</td>

                    <td>
                        <?php
                        $user = str_pad($count, 2, '0', STR_PAD_LEFT);
                        $count++;
                        ?>
                        {{ 'NDP_USER'.$user }}
                    </td>
                    <td>
                        {{ 'USER' }}
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
</div>
</body>
</html>