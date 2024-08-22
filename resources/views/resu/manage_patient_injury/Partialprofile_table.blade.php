@php
    use Carbon\Carbon;
    use App\Facility;
    use App\ResuReportFacility;
    
    $priv_fact= Auth::user()->facility_id;

@endphp

@foreach($profiles as $p)
    @php
        $province = null;
        $muncity = null;
        $barangay = null;
        if($p->preadmission->POIProvince_id == $p->province->id){
            $province = $p->province->description;
        }
        if($p->preadmission->POImuncity_id == $p->muncity->id){
            $muncity = $p->muncity->description;
        }
        if($p->preadmission->POIBarangay_id == $p->barangay->id){
            $barangay = $p->barangay->description;
        }
    @endphp
    <tr>
        <td nowrap="TRUE">
            <a href="{{ asset('sublist-patient/'.$p->id) }}" class="btn btn-xs btn-success">
                <i class="fa fa-eye"></i> View
            </a>
        </td>
        @if($user->user_priv !== 6)
            <td>
                @php
                    $facility = Facility::find(
                        ResuReportFacility::where('id', $p->report_facilityId)
                            ->pluck('facility_id')
                            ->first()
                    );
                @endphp
                {{ $facility ? $facility->name : Facility::find($p->report_facilityId)->name }}
            </td>
        @endif
        <td class="{{ $p->head=='YES' ? 'text-bold text-primary' : '' }}">
            {{ $p->fname.' '.$p->mname.' '.$p->lname.' '.$p->suffix }}
        </td>
        <td>
            @php
                $dob = Carbon::parse($p->dob);
                $age = $dob->diffInYears(Carbon::now());
            @endphp
            {{ $age }}
        </td>
        <td>{{ $p->sex }}</td>
        <td>{{ $p->province ? $p->province->description : 'N/A' }}</td>
        <td>{{ $p->muncity ? $p->muncity->description : 'N/A' }}</td>
        <td>{{ $p->barangay ? $p->barangay->description : 'N/A' }}</td>
        <td>{{ $province. ' , ' . $muncity. ' , ' . $barangay. ' , ' . $p->preadmission->POIPurok }}</td>
        <td>{{ $p->preadmission->dateInjury . ' '. $p->preadmission->timeInjury }}</td>
        @if($user->user_priv !== 6)
            <td>{{ $p->nameof_encoder }}</td>
        @endif
    </tr>
@endforeach
