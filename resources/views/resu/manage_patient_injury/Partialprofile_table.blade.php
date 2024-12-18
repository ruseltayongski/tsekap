@php
    use Carbon\Carbon;
    use App\Facility;
    use App\ResuReportFacility;

    $priv_fact= Auth::user()->facility_id;
@endphp

@if($profiles->isEmpty())
    <tr>
        <td colspan="12" class="text-center">No data found</td>
    </tr>
@else
    @foreach($profiles as $p)
    
                @php
                    $province = null;
                    $muncity = null;
                    $barangay = null;
                    $ad = $p->preadmission;   

                    if($p->preadmission->POIProvince_id == $p->province->id){
                        $province = $p->province->description;
                    }
                    if($p->preadmission->POImuncity_id == $p->muncity->id){
                        $muncity = $p->muncity->description;
                    }
                    if($p->preadmission->POIBarangay_id == $p->barangay->id){
                        $barangay = $p->barangay->description;
                    }
                    $preprovince = $ad->POIProvince_id ? $ad->province->description : 'N/A';
                    $premuncity = $ad->POImuncity_id ? $ad->muncity->description : 'N/A';
                    $prebarangay = $ad->POIBarangay_id ? $ad->barangay->description : 'N/A';
                @endphp
             <tr>
             <td nowrap="TRUE">
                <a href="{{ asset('sublist-patient/'.$p->id) }}" class="btn btn-xs btn-success">
                    <i class="fa fa-eye"></i> View
                </a>
             </td>
             <td nowrap="TRUE">
                <form action="{{ route('patient.delete', $p->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this record?');">
                    {{ csrf_field() }}
                    <button type="submit" class="btn btn-xs btn-danger">
                        <i class="fa fa-trash"></i> Delete
                    </button>
                </form>
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
                    $ageYears = $dob->diffInYears(Carbon::now());
                    $ageMonths = $dob->diffInMonths(Carbon::now()) % 12;

                    $age = $ageYears > 0 
                            ? "{$ageYears} years old"   
                            : "{$ageMonths} months old";
                @endphp

                {{ $age }}
                </td>
                <td>{{ $p->sex }}</td>
                <td>{{ $p->province ? $p->province->description : 'N/A' }}</td>
                <td>{{ $p->muncity ? $p->muncity->description : 'N/A' }}</td>
                <td>{{ $p->barangay ? $p->barangay->description : 'N/A' }}</td>
                <td>{{ $preprovince. ' , ' . $premuncity. ' , ' . $prebarangay. ' , ' . $p->preadmission->POIPurok }}</td>
                <td>{{ $p->preadmission->dateInjury . ' '. $p->preadmission->timeInjury }}</td>
                
                @if($user->user_priv !== 6)
                <td>
                    {{ $p->name_of_encoder }}
                </td>
            @endif
        </tr>
    @endforeach
@endif
