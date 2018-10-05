@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
<div class="header ">
    <span class="">Thêm Giftcode</span>
    <span class="pull-right"><a href="list" title="Giftcode"><i class="fa fa-list"></i></a></span>
</div>
@include('Elements.error')
<hr/>
<div>
    <form class="form-horizontal" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label class="control-label col-sm-2" for="fanpageId">Fanpage Id:</label>
            <div class="col-sm-9"> 
                <input type="text" class="form-control" disabled name="fanpage_id" id="fanpageId" placeholder="FanpageId" value="{{isset($fanpage->name)?$fanpage->name:''}} - {{isset($fanpage->fanpage_id)?$fanpage->fanpage_id:'' }}">
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Title:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="title" id="title" placeholder="Title" value={{isset($fanpage_giftcodes->title)?$fanpage_giftcodes->title:''}}>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Mô tả:</label>
            <div class="col-sm-9">
                <textarea class="form-control" rows="5" name="description" id="description">{{isset($fanpage_giftcodes->description)?$fanpage_giftcodes->description:''}} </textarea>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Ngày bắt đầu:</label>
            <div class="col-sm-9">
                <input class="form-control" type="date" name="start_time" id="start_time" value="{{isset($fanpage_giftcodes->start_time)?$fanpage_giftcodes->start_time:''}}" />
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">Ngày kết thúc:</label>
            <div class="col-sm-9">
                <input class="form-control" type="date" name="end_time" id="end_time" value="{{isset($fanpage_giftcodes->end_time)?$fanpage_giftcodes->end_time:''}}"/>
            </div>
        </div>
        @if(!isset($fanpage_giftcodes->id)){
        <div class="form-group">
            <label class="control-label col-sm-2" for="title">File Giftcode:</label>
            <div class="col-sm-9">
                <input class="form-control" type='file' name="giftcode" id="giftcode" />
            </div>    
        </div>
        @endif

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