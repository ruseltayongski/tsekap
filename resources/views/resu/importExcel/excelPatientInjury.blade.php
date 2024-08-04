@extends('resu/app1')
@section('content')

<div class="row">
    <div class="col-md-4 col-md-offset-4 col-xs-12 text-center" style="margin-top: 20px;">
        <form action="{{ route('import.excel') }}" method="POST" enctype="multipart/form-data">
            {{ csrf_field() }}
            <input type="file" name="file" required>
            <button type="submit" class="btn btn-primary">Import Excel</button>
        </form>
    </div>
</div>




@endsection