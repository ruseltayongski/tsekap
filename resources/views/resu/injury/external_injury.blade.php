@extends('resu/app1')
@section('content')

    @include('resu.injury.external-side')

    <div class="col-md-9 wrapper">
                <div class="alert alert-jim">
                    <h2 class="page-header">External Injury</h2>
                    <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                                <thead>
                                <tr>
                                    <th>External Name</th>  
                                    <th></th>
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($external as $ex)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{ $ex->name }}</font>
                                        </td>
                                        <td>
                                             <a href="{{ route('injury-external-edit', ['id' => $ex->id]) }}" class="btn btn-primary">Edit</a>
                                        </td>
                                        <td>
                                            <!-- <form action="{{ route('delete-external') }}" method="POST">
                                            {{ csrf_field() }}
                                                <input type="hidden" name="name" value="{{ $ex->name }}">
                                                <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this injury?')">Delete</button>
                                            </form> -->
                                        </td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    {{ $external->links() }}<!-- Pagination links -->                

                </div>
            </div>

@endsection