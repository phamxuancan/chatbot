@extends('layouts.dashboard')
@section('section')
           
<div class="header">
    <span class="">Fanpage</span>
    <span class="pull-right"><a href="add_pages" title="Thêm fanpage"><i class="fa fa-plus-circle"></i></a></span>
</div>
<div class="content">
@include('Elements.error')
<div class="col-sm-12">
    <table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
            <th>Name</th>
			<th>FanpageId</th>
            <th>PageAccessToken</th>
            <th>Created</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($fanpages as $page) 
		<tr>
            <td>{{ $page->id }}</td>
			<td>{{ $page->name }}</td>
            <td>{{ $page->fanpage_id }}</td>
			<td style="max-width:300px;word-wrap:break-word">{{ $page->page_accesstoken }}</td>
            <td>{{ $page->created_at}}</td>
            <td>
                <a href="edit/{{$page->id}}" class="btn btn-xs btn-warning">Sửa</a>
                <a href="hello/{{$page->fanpage_id}}" class="btn btn-xs btn-success">Nút hello</a>
                <a  onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$page->id}}" class="btn btn-xs btn-danger">Delete</a>
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $fanpages->links() }}
</div>
</div>
@stop