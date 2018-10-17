<div>
    @if(count($dengvaxia))
        <table class="table table-hover table-striped">
            <thead>
            <tr>
                <th></th>
                <th>FullName</th>
                <th>Birth of Date</th>
                <th>Gender</th>
                <th>Age</th>
            </tr>
            </thead>
            <tbody>
            @foreach($dengvaxia as $row)
                <?php $fullname = $row->lname.', '.$row->fname.' '.$row->mname; ?>
                <tr>
                    <td style="width: 10%">
                        <a href="{{ asset('form_dengvaxia').'/'.$row->id.'/'.$unique_id }}" class="btn btn-xs btn-info">
                            <i class="fa fa-user-plus"></i> Update
                        </a>
                    </td>
                    <td>
                        <a href="#"><font class="title-info">{{ mb_substr($fullname, 0, 30)  }}</font></a><br />
                        <small class="text-info">
                            {{ \App\Barangay::find($row->barangay_id)->description }},
                            {{ \App\Muncity::find($row->muncity_id)->description }},
                            {{ \App\Province::find($row->province_id)->description }}
                        </small>
                    </td>
                    <td>
                        <?php $tmp_date = date('M-Y',strtotime($row->dob)); ?>
                        @if($row->dob==='0000-00-00' || $tmp_date==='Jan-1970')
                            <span class="text-danger">Not Set</span>
                        @else
                            {{ date('M d, Y',strtotime($row->dob)) }}
                        @endif

                    </td>
                    <td>{{ $row->sex }}</td>
                    <td>{{ $row->gen_age }}</td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @else
        <div class="alert alert-info">
            <p class="text-info"><i class="fa fa-info-circle fa-lg text-bold"></i> No data found!</p>
        </div>
    @endif
</div>