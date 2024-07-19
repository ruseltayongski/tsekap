<div class="col-md-3 wrapper">
    <div class="panel panel-jim">
        <div class="panel-heading">
            <h3 class="panel-title">Add Hospital facility Category</h3>
        </div>
        <div class="panel-body">
            <form method="POST" action="{{ route('add-hospital') }}">
                {{ csrf_field() }}
                <div class="form-group">
                    <label>Name</label>
                    <input type="text" style="width: 100%;" class="form-control" placeholder="Input name..." name="name" required>
                </div>
        
                <div class="form-group">
                    <button type="submit" style="margin-top:10px;  background-color:#727DAB; color:#ffff" class="col-xs-12 btn"><i class="fa fa-paper-plane"></i> Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>