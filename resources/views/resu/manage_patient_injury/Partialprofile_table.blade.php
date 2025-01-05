@php
    use Carbon\Carbon;
    use App\Facility;
    use App\ResuReportFacility;

    $priv_fact = Auth::user()->facility_id;
@endphp

@if($profiles->isEmpty())
    <tr>
        <td colspan="12" class="text-center">No data found</td>
    </tr>
@else
    @foreach($profiles as $p)
        @php
            $province = $p->province ? $p->province->description : 'N/A';
            $muncity = $p->muncity ? $p->muncity->description : 'N/A';
            $barangay = $p->barangay ? $p->barangay->description : 'N/A';
            $preadmission = $p->preadmission;
            $preprovince = $preadmission ? $preadmission->province->description : 'N/A';
            $premuncity = $preadmission ? $preadmission->muncity->description : 'N/A';
            $prebarangay = $preadmission ? $preadmission->barangay->description : 'N/A';
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
                    {{ $p->facility ? $p->facility->name : 'N/A' }}
                </td>
            @endif

            <td class="{{ $p->head == 'YES' ? 'text-bold text-primary' : '' }}">
                {{ $p->fname.' '.$p->mname.' '.$p->lname.' '.$p->suffix }}
            </td>
            <td>
                @php
                    $dob = Carbon::parse($p->dob);
                    $ageYears = $dob->diffInYears(Carbon::now());
                    $ageMonths = $dob->diffInMonths(Carbon::now()) % 12;
                    $age = $ageYears > 0 ? "{$ageYears} years old" : "{$ageMonths} months old";
                @endphp
                {{ $age }}
            </td>
            <td>{{ $p->sex }}</td>
            <td>{{ $province }}</td>
            <td>{{ $muncity }}</td>
            <td>{{ $barangay }}</td>
            <td>
                {{ $preprovince . ' , ' . $premuncity . ' , ' . $prebarangay . ' , ' . ($preadmission ? $preadmission->POIPurok : 'N/A') }}
            </td>
            <td>
                {{ $preadmission ? $preadmission->dateInjury . ' ' . $preadmission->timeInjury : 'N/A' }}
            </td>

            @if($user->user_priv !== 6)
                <td>{{ $p->name_of_encoder }}</td>
            @endif
        </tr>
    @endforeach
@endif
