@extends('resu/app1')
@section('content')

    @include('resu.hospital.hospitalform')

    <div class="col-md-9 wrapper">
                <div class="alert alert-jim">
                    <h2 class="page-header">Hospital/Facility Category</h2>
                    <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                                <thead>
                                <tr>
                                    <th>Description</th>  
                                </tr>
                                </thead>
                                <tbody>
                                   @foreach($hospital as $hos)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{ $hos->category_name}}</font>
                                        </td>
                                        
                                    </tr>
                                    @endforeach                                  
                                </tbody>
                            </table>
                        </div>
                       {{ $hospital->links() }}

                </div>
            </div>

@endsection