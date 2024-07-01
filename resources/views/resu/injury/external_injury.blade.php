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
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($external as $ex)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{ $ex->name }}</font>
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