@php
    use Carbon\Carbon;
    use App\Facility;
    use App\ResuReportFacility;
    
    $priv_fact= Auth::user()->facility_id;

@endphp
@foreach($riskprofiles as $profile)
    <tr>
        <td nowrap="TRUE">
            <a href="{{ asset('sublist-patient/'.$profile->id) }}" class="btn btn-xs btn-success">
                <i class="fa fa-eye"></i> View
            </a>
        </td>
        {{-- @if($user_priv->user_priv !== 6)
            <td>{{ $profile->facility->name ?? 'N/A' }}</td>
        @endif --}}
        <td>{{ $profile->fname }} {{ $profile->mname }} {{ $profile->lname }}</td>
        <td>{{ \Carbon\Carbon::parse($profile->dob)->age }}</td>
        <td>{{ $profile->sex }}</td>
        <td>{{ $profile->civil_status }}</td>
        <td>{{ $profile->province->description ?? 'N/A' }}</td>
        <td>{{ $profile->muncity->description ?? 'N/A' }}</td>
        <td>{{ $profile->barangay->description ?? 'N/A' }}</td>
        <td>{{ $profile->created_at ? \Carbon\Carbon::parse($profile->created_at)->format('F j, Y') : 'N/A' }}</td>
    </tr>
@endforeach
