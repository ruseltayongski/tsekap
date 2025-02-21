@php
    use Carbon\Carbon;
    use App\Facilities;
    use App\UserHealthFacility;
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $userHealthFacilityMapping = UserHealthFacility::where('user_id', $user->id)->first();
    $facility = $userHealthFacilityMapping 
        ? Facilities::where('id', $userHealthFacilityMapping->facility_id)
            ->select('id', 'name', 'address', 'hospital_type')
            ->first()
        : null;
@endphp

<style>
    .table {
        border-collapse: collapse;
        width: 100%;
        border: 1px solid #ddd;
    }
    .table th, .table td {
        border: 1px solid #ddd;
        padding: 12px;
        text-align: left;
    }
    .table th {
        background-color: #f4f4f4;
    }
    .btn {
        padding: 10px 15px;
        font-size: 14px;
    }
</style>

@foreach ($riskprofiles as $profile)
    <table class="table table-hover table-striped">
        <thead>
            <tr>
                <th rowspan="2"><b>ACTIONS</b></th>
                <th>Full Name</th>
                <th>Age</th>
                <th>Sex</th>
                <th>Civil Status</th>
                <th>Province/HUC</th>
                <th>Municipal</th>
                <th>Barangay</th>
                <th>Date Inputted</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td nowrap="TRUE">
                    <a href="{{ url('sublist-risk-patient/' . $profile->id) }}" class="btn btn-sm btn-success">
                        <i class="fa fa-eye"></i> View
                    </a>
                </td>
                <td nowrap="TRUE">
                    @if ($user->priv == 1)
                        <form action="{{ url('patientrisk/delete/' . $profile->id) }}" method="POST"
                            onsubmit="return confirm('Are you sure you want to delete this record?');">
                            {{ csrf_field() }}
                            <button type="submit" class="btn btn-sm btn-danger">
                                <i class="fa fa-trash"></i> Delete
                            </button>
                        </form>
                    @endif
                </td>
                <td>{{ $profile->fname }} {{ $profile->mname }} {{ $profile->lname }}</td>
                <td>{{ Carbon::parse($profile->dob)->age }}</td>
                <td>{{ $profile->sex }}</td>
                <td>{{ $profile->civil_status }}</td>
                <td>{{ isset($profile->province->description) ? $profile->province->description : 'N/A' }}</td>
                <td>{{ isset($profile->muncity->description) ? $profile->muncity->description : 'N/A' }}</td>
                <td>{{ isset($profile->barangay->description) ? $profile->barangay->description : 'N/A' }}</td>
                <td>{{ isset($profile->created_at) ? Carbon::parse($profile->created_at)->format('F j, Y') : 'N/A' }}</td>
            </tr>
        </tbody>
    </table>
@endforeach
