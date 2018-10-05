@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
           
<div class="header">
    <span class="">Cài đặt comment</span>
    <span class="pull-right"><a href="setup_comment" title="Thêm fanpage"><i class="fa fa-plus-circle"></i></a></span>
</div>
<div class="content">
@include('Elements.error')
<div class="col-sm-12">
    <table class="table table-hover table-bordered">
	<thead>
		<tr>
			<th>ID</th>
            <th>Title</th>
            <th>Fanpage_id</th>
            <th>Keywords</th>
            <th>message</th>
            <th>Giftcode</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($comment_replies as $comment_replie) 
		<tr>
            <td>{{ $comment_replie->id }}</td>
			<td title="{{ $comment_replie->title }}">{{ substr($comment_replie->title,0,25) }}</td>
            <td>{{ $comment_replie->fanpage_id }}</td>
            <td title="{{ $comment_replie->keywords }}">{{ substr($comment_replie->keywords,0,25) }}</td>
            <td title="{{ $comment_replie->message }}">{{ substr($comment_replie->message,0,25) }}</td>
            <td>
                @if(!empty($comment_replie->is_giftcode))
                    <i class="fa fa-check"></i>
                @else
                <i class="fa fa-remove"></i>
                @endif
            </td>
            <td>
                <a href="edit/{{$comment_replie->id}}" class="btn btn-xs btn-warning">Sửa</a>
                <a  onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$comment_replie->id}}" class="btn btn-xs btn-danger">Delete</a>
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $comment_replies->links() }}
</div>
</div>
</div>
</div>
@stop