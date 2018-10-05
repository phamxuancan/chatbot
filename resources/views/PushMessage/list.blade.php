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
            <th>Title</th>
			<th>FanpageId</th>
			<th>Message</th>
            <th>User pushed</th>
            <th>Time pushed</th>
            <th>Status</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($pushMessages as $page) 
		<tr>
            <td>{{ $page->id }}</td>
			<td>{{ $page->title }}</td>
            <td>{{ $page->fanpage_id }}</td>
            <td>{{ $page->message }}</td>
            <td>{{ $page->send_user}}</td>
            <td>{{ $page->pushed_time}}</td>
            @if(empty($page->status))
            <td class="">Chưa thể push</td>
            @endif
            @if(($page->status == 1))
            <td class="">Có thể push</td>
            @endif
            @if(($page->status == 2))
            <td class="">Đã push</td>
            @endif
            @if(($page->status == 3))
            <td class="">Đặt lịch</td>
            @endif
            <td style="text-align:left;">
                @if(empty($page->status))
                    <a href="publish/{{$page->id}}" class="btn btn-xs btn-default">Publish</a>
                @endif
                @if($page->status == 1)
                <a href="unpublish/{{$page->id}}" class="btn btn-xs btn-default">UnPublish</a>
                @endif
                <a href="edit/{{$page->id}}" class="btn btn-xs btn-warning">Sửa</a>
                <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$page->id}}" class="btn btn-xs btn-danger">Delete</a>
                @if(!empty($page->status) && $page->status == 1 )
                | <a href="send/{{$page->id}}" class="btn btn-xs btn-success">Gửi</a>
                @endif
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $pushMessages->links() }}
</div>
</div>
</div>
</div>

@stop