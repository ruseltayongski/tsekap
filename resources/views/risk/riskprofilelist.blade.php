@php
    use Carbon\Carbon;
    // $priv_fact= Auth::user()->facility_id;
@endphp
@foreach ($riskprofiles as $profile)
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th></th>
                <th></th>
                {{-- Commented out health facility --}}
                {{-- @if ($user_priv->user_priv !== 6)
                    <th>Facility Name</th>
                @endif --}}
                <th>Full Name<br>&nbsp;</th>
                <th>Age<br>&nbsp;</th>
                <th>Sex<br>&nbsp;</th>
                <th>Civil Status<br>&nbsp;</th>
                <th>Province/HUC<br>&nbsp;</th>
                <th>Municipal<br>&nbsp;</th>
                <th>Barangay<br>&nbsp;</th>
                <th>Date Inputted<br>&nbsp;</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td nowrap="TRUE">
                    <a href="{{ asset('sublist-risk-patient/' . $profile->id) }}" class="btn btn-xs btn-success">
                        <i class="fa fa-eye"></i> View
                    </a>
                </td>
                <td nowrap="TRUE">
                    <form action="{{ route('patientrisk.delete', $profile->id) }}" method="POST"
                        onsubmit="return confirm('Are you sure you want to delete this record?');">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-xs btn-danger">
                            <i class="fa fa-trash"></i> Delete
                        </button>
                    </form>
                </td>
                {{-- Commented out health facility  --}}
                {{-- @if ($user_priv->user_priv !== 6)
                    <td>{{ $profile->facility->name ? $profile->facility->name : 'N/A' }}</td>
                @endif --}}
                <td>{{ $profile->fname }} {{ $profile->mname }} {{ $profile->lname }}</td>
                <td>{{ Carbon::parse($profile->dob)->age }}</td>
                <td>{{ $profile->sex }}</td>
                <td>{{ $profile->civil_status }}</td>
                <td>{{ $profile->province->description ? $profile->province->description : 'N/A' }}</td>
                <td>{{ $profile->muncity->description ? $profile->muncity->description : 'N/A' }}</td>
                <td>{{ $profile->barangay->description ? $profile->barangay->description : 'N/A' }}</td>
                <td>{{ $profile->created_at ? Carbon::parse($profile->created_at)->format('F j, Y') : 'N/A' }}</td>
            </tr>
        </tbody>
@endforeach
