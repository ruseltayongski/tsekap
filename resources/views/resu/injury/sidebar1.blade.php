<?php
// use App\Province;
// $provinces = Province::orderBy('description','asc');
// $user= Auth::user();
// if($user->user_priv==3){
//     $provinces = $provinces->where('id',$user->province);
// }
// $provinces = $provinces->get();
?>
<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Add Nature Injury</h3>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('add-nature-injury') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" style="width: 100%;" class="form-control" placeholder="Input name..." name="name" required>
                </div>
        
                <div class="form-group">
                    <button type="submit" style="margin-top:10px;" class="col-xs-12 btn btn-success"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>