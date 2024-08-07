@extends('resu/app1')
@section('content')

    @if($user_priv->user_priv == 10)
        @include('resu.injury.sidebar1')

            <div class="col-md-9 wrapper">
                <div class="alert alert-jim">
                    <h2 class="page-header">Nature Injury</h2>

                    <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                                <thead>
                                <tr>
                                    <th>Nature Injury Name</th>  
                                </tr>
                                </thead>
                                <tbody>
                                    @foreach($injured as $injury)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{ $injury->name }}</font>
                                        </td>
                                        
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    {{ $injured->links() }}<!-- Pagination links -->
                
                </div>
            </div>

    @endif

@endsection
