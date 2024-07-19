@extends('resu/app1')
@section('content')

    @include('resu.accident.safetyform')

    <div class="col-md-9 wrapper">
                <div class="alert alert-jim">
                    <h2 class="page-header">Safety Type</h2>
                    <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                                <thead>
                                <tr>
                                    <th>Description</th>  
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($safetytype as $safe)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{ $safe->name }}</font>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                       {{ $safetytype->links() }}

                </div>
            </div>

@endsection