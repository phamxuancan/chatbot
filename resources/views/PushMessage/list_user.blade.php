@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
<div class="header">
    <span class="">Push Message</span>
    <span class="pull-right"><a href="add" title="Thêm fanpage"><i class="fa fa-plus-circle"></i></a></span>
</div>
<div class="content">
@include('Elements.error')
<div class="col-sm-12">
    <table class="table table-hover">
	<thead>
		<tr>
			<th>ID</th>
            <th>Fanpage</th>
			<th>facebookId</th>
            <th>Created</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($users as $user) 
		<tr>
            <td>{{ $user->id }}</td>
			<td>{{ $user->fanpage_id }}</td>
            <td>{{ $user->facebook_id }}</td>
            <td>{{ $user->created_at}}</td>
            <td>
                <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$user->id}}" class="btn btn-xs btn-danger">Delete</a>
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $users->links() }}
</div>
</div>
</div>
</div>
@stop