<?php
    use App\Muncity;
    use App\Province;
    $muncity = Muncity::orderBy('province_id','asc')
            ->where('province_id',2)
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
                        <th>Province</th>
                        <th>Municipality / City</th>
                        <th class="text-right">Users</th>
                        <th class="text-right">PHA</th>
                        <th class="text-right">NDP</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        $holder = 0;
                        $count = 1;

                    ?>
                    @foreach($muncity as $m)
                    <tr>
                        <td>
                            @if($holder!=$m->province_id)
                            {{ Province::find($m->province_id)->description }}
                                <?php $holder = $m->province_id; ?>
                            @endif
                        </td>
                        <td>{{ Muncity::find($m->id)->description }}</td>

                        <td class="text-right">
                            <?php
                                $count = \App\User::where('muncity',$m->id)->count();
                            ?>
                            {{ $count }}
                        </td>
                        <td class="text-right">
                            {{ \App\User::where('muncity',$m->id)->where('user_priv',0)->count() }}
                        </td>
                        <td class="text-right">
                            {{ \App\User::where('muncity',$m->id)->where('user_priv',2)->count() }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>