@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
<div class="header">
    <span class="">Kho từ</span>
    <span class="pull-right"><a href="add" title="Thêm từ"><i class="fa fa-plus-circle"></i></a></span>
</div>
<hr/>
<div>
<form class="form-inline" method="GET">
  <div class="form-group">
    <label for="qword">Từ tìm kiếm</label>
    <input type="text" class="form-control" id="qword" name="qword">
  </div>
  <div class="form-group">
  <select class="form-control" id="category" name="category_id">
    <option value="" >Chọn category</option>
    @foreach($categories as $cate)
        <option value="{{ $cate->id }}" >{{ $cate->title }}</option>
    @endforeach
  </select>
</div>
  <button style="margin-bottom:0px;" type="submit" class="btn btn-default"><i class="fa fa-search"></i></button>
</form>
</div>
<hr/>
<div class="content">
@include('Elements.error')
<div class="col-sm-12">

    <table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
            <th>Từ khóa</th>
			<th>Category</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($words as $word) 
		<tr>
            <td>{{ $word->id }}</td>
			<td>{{ $word->word }}</td>
            <td>{{ $word->title }}</td>
            <td >
                <a href="edit/{{$word->id}}" class="btn btn-xs btn-warning">Sửa</a>
                <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$word->id}}" class="btn btn-xs btn-danger">Delete</a>
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $words->links() }}
</div>
</div>
</div>
</div>
@stop