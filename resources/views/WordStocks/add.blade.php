@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
           
<div class="header ">
    <span class="">Thêm Từ</span>
    <span class="pull-right"><a href="list" title="Danh sách"><i class="fa fa-list"></i></a></span>
</div>
@include('Elements.error')
<hr/>
<div>
    <form class="form-horizontal" method="POST">
        
        
        <div class="form-group ">
            <label class="control-label col-sm-2" for="title">Category:</label>
            <div class="col-sm-9">
                <select name="category_id" class="form-control col-sm-9">
                    <option value="{{isset($category->id)?$category->id:0}}">{{isset($category->title)?$category->title:'Hãy chọn Category'}}</option>
                    @foreach($categories as $category)
                        <option value="{{$category->id}}">{{$category->title}}</option>
                    @endforeach
                </select>
            </div>
            <label class="control-label col-sm-2" for="title">Từ khóa:</label>
            <div class="col-sm-9">
                <input type="text" class="form-control" name="word" id="word" placeholder="Title" value={{isset($word->word)?$word->word:''}}>
            </div>
        </div>
       
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="col-sm-offset-2">
                <button type="submit" class="btn btn-default">Submit</button>
            </div>
        </div>
    </form>
</div>
</div>
</div>
@stop