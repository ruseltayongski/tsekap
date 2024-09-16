@extends('resu/app1')
@section('content')

    @include('resu.accident.accidentSide')

    <div class="col-md-9 wrapper">
                <div class="alert alert-jim">
                    <h2 class="page-header">Accident Type</h2>
                    <div class="clearfix"></div>
                        <div class="table-responsive">
                            <table class="table table-striped table-hover" style="border: 1px solid #d6e9c6">
                                <thead>
                                <tr>
                                    <th>Description</th>  
                                    <th></th>
                                </tr>
                                </thead>
                                <tbody>
                                  @foreach($accidentType as $act_type)
                                    <tr>
                                        <td>
                                            <font class="text-success text-bold">{{$act_type->description}}</font>
                                        </td>
                                        <td>
                                            <form action="{{ route('delete-accident-type') }}" method="POST">
                                                    {{ csrf_field() }}
                                                    <input type="hidden" name="id" value="{{ $act_type->id }}"> <!-- Pass the ID here -->
                                                    <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this accident?')">Delete</button>
                                             </form>
                                        </td>
                                    </tr>
                                 @endforeach
                                </tbody>
                            </table>
                        </div>
                        {{ $accidentType->links() }}

                </div>
            </div>

    @endsection