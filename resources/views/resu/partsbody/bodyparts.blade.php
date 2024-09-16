@extends('resu/app1')
@section('content')
    @include('resu.partsbody.sidebody')

    <div class="col-md-9 wrapper">
        <div class="alert alert-jim">
            <h2 class="page-header">Body Parts</h2>

            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                    <thead>
                        <tr>
                            <th>Body Name</th> 
                            <th></th> 
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($b_parts as $parts)
                        <tr>
                            <td>
                                <font class="text-success text-bold">{{ $parts->name }}</font>
                            </td>
                            <td>
                                <form action="{{ route('delete-body-parts') }}" method="POST">
                                    {{ csrf_field() }}
                                    <input type="hidden" name="id" value="{{ $parts->id }}"> <!-- Pass the ID here -->
                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this body part?')">Delete</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{ $b_parts->links() }}<!-- Pagination links -->
        </div>
    </div>
@endsection
