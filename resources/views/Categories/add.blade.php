@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
           
<div class="header ">
    <span class="">Thêm Category</span>
    <span class="pull-right"><a href="list" title="Thêm fanpage"><i class="fa fa-list"></i></a></span>
</div>
@include('Elements.error')
<hr/>
<div>
    <form class="form-horizontal" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Title:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value={{isset($category->title)?$category->title:''}}>
            </div>
        </div>    
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-9">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
@stop