@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
           
<div class="header">
    <span class="">Categories</span>
    <span class="pull-right"><a href="add" title="Thêm Category"><i class="fa fa-plus-circle"></i></a></span>
</div>
<div class="content">
@include('Elements.error')
<div class="col-sm-12">
    <table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>ID</th>
            <th>Title</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($categories as $category) 
		<tr>
            <td>{{ $category->id }}</td>
			<td>{{ $category->title }}</td>
            <td style="text-align:center;">
                <a href="edit/{{$category->id}}" class="btn btn-xs btn-warning">Sửa</a>
                <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$category->id}}" class="btn btn-xs btn-danger">Delete</a>
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $categories->links() }}
</div>
</div>
</div>
</div>
@stop