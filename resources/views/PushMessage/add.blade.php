@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
<div class="header ">
    <span class="">Thêm Push</span>
    <span class="pull-right"><a href="list" title="Thêm fanpage"><i class="fa fa-list"></i></a></span>
</div>
@include('Elements.error')
<hr/>
<div>
    <form class="form-horizontal" method="POST">
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Title:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value={{isset($fanpage->title)?$fanpage->title:''}}>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="fanpageId">Fanpage Id:</label>
            <div class="col-sm-9"> 
                <input type="text" class="form-control" disabled name="fanpage_id" id="fanpageId" placeholder="FanpageId" value="{{isset($fanpage->fanpage_id)?$fanpage->fanpage_id:'' }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="message">Message:</label>
            <div class="col-sm-9"> 
                <textarea class="form-control" name="message" id="message" placeholder="Message push to users">{{isset($fanpage->message)?$fanpage->message:''}}</textarea>
            </div>
        </div>
        <div class="form-group"> 
        <label class="control-label col-sm-2" for="message">Đặt Lịch Push:</label>
            <div class="col-sm-9"> 
                <input class="form-control" type="datetime-local" name="schedule_time" id="schedule_time" placeholder="Message push to users">{{isset($fanpage->schedule_time)?$fanpage->schedule_time:''}}</textarea>
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