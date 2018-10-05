@extends('../admin')
@section('content')
           
<div class="header ">
    <span class="">Thêm Fanpage</span>
    <span class="pull-right"><a href="list" title="Thêm fanpage"><i class="fa fa-list"></i></a></span>
</div>
@include('Elements.error')
<hr/>
<div>
    <form class="form-horizontal" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="name">Name:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="name" id="name" placeholder="fanpage name" value="{{isset($fanpage->name)?$fanpage->name:''}}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="fanpageId">Fanpage Id:</label>
            <div class="col-sm-9"> 
                <input type="text" class="form-control" name="fanpage_id" id="fanpageId" placeholder="FanpageId" value={{isset($fanpage->fanpage_id)?$fanpage->fanpage_id:''}}>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="page_access_token">Page AccessToken:</label>
            <div class="col-sm-9"> 
                <input type="text" class="form-control" name="page_access_token" id="page_access_token" placeholder="Page access token" value={{isset($fanpage->page_accesstoken)?$fanpage->page_accesstoken:''}}>
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
@stop