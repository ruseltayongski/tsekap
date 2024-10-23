<!-- resources/views/resu/admin/userUpdate.blade.php -->

@extends('resu/app1')

@section('content')

<div class="container">
    <h2 class="page-header">Update User</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form id="updateUserForm" method="POST" action="{{ route('user.update') }}">
    {{ csrf_field() }}
        <input type="hidden" name="user_id" value="{{ $user->id }}">

        <div class="form-group">
            <label for="fname">First Name</label>
            <input type="text" class="form-control" name="fname" id="fname" value="{{ $user->fname }}" required>
            @error('fname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="mname">Middle Name</label>
            <input type="text" class="form-control" name="mname" id="mname" value="{{ $user->mname }}">
            @error('mname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="lname">Last Name</label>
            <input type="text" class="form-control" name="lname" id="lname" value="{{ $user->lname }}" required>
            @error('lname')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="contact">Contact Number</label>
            <input type="text" class="form-control" name="contact" id="contact" value="{{ $user->contact }}" required>
            @error('contact')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" id="username" value="{{ $user->username }}" required>
            @error('username')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="user_priv">User Level</label>
            <select name="user_priv" id="user_priv" class="form-control" required>
                <option value="6" {{ $user->user_priv == 6 ? 'selected' : '' }}>Facility</option>
                <option value="7" {{ $user->user_priv == 7 ? 'selected' : '' }}>Region</option>
                <option value="3" {{ $user->user_priv == 3 ? 'selected' : '' }}>Provincial</option>
                <option value="8" {{ $user->user_priv == 8 ? 'selected' : '' }}>HUC</option>
                <option value="10" {{ $user->user_priv == 10 ? 'selected' : '' }}>DSO</option>
                <option value="11" {{ $user->user_priv == 11 ? 'selected' : '' }}>Staff DSO</option>
            </select>
            @error('user_priv')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="province">Province</label>
            <select name="province" id="province" class="form-control" required>
                @foreach($provinces as $province)
                    <option value="{{ $province->id }}" {{ $user->province == $province->id ? 'selected' : '' }}>{{ $province->description }}</option>
                @endforeach
            </select>
            @error('province')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="muncity">Municipal / City</label>
            <select name="muncity" id="muncity" class="form-control" required>
                @foreach($muncities as $muncity)
                    <option value="{{ $muncity->id }}" {{ $user->muncity == $muncity->id ? 'selected' : '' }}>{{ $muncity->description }}</option>
                @endforeach
            </select>
            @error('muncity')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <div class="form-group">
            <label for="facilities">Facilities</label>
            <select name="facilities[]" id="facilities" class="form-control" multiple required>
                @foreach($facilities as $facility)
                    <option value="{{ $facility->id }}" {{ in_array($facility->id, $user->facilities->pluck('id')->toArray()) ? 'selected' : '' }}>{{ $facility->name }}</option>
                @endforeach
            </select>
            @error('facilities')
                <div class="text-danger">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="btn btn-success">Update User</button>
        <a href="{{ route('resu.admin.view_Users') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>

@endsection

@section('js')

<script>
$(document).ready(function() {
    $('#updateUserForm').on('submit', function(e) {
        e.preventDefault(); // Prevent default form submission

        $.ajax({
            type: 'POST',
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: function(response) {
                window.location.href = '{{ route("resu.admin.view_Users") }}'; // Redirect to the users list page
            },
            error: function(xhr) {
                // Handle validation errors or other errors
                var errors = xhr.responseJSON.errors;
                $.each(errors, function(key, value) {
                    alert(value[0]); 
                });
            }
        });
    });
});
</script>

@endsection
