@extends('resu.app1')

@section('content')
@include('resu.accident.accidentSide')
    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Edit</h2>
            <!-- resources/views/shared/edit-form.blade.php -->
            <form action="{{ route($updateRoute, ['id' => $entity->id]) }}" method="POST">
                {{ csrf_field() }}
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" class="form-control" id="description" name="description" value="{{ $entity->description }}" required>
                </div>
                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to update?')">Update</button>
                <button type="button" class="btn btn-primary" onclick="window.history.back()">Back</button>
            </form>
        </div>
    </div>
@endsection
