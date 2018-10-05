@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
<div class="header">
    <span class="">Dánh sách Giftcode Fanpage</span>
    <span class="pull-right"><a href="add" title="Thêm code"><i class="fa fa-plus-circle"></i></a></span>
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
			<th>StartTime</th>
            <th>EndTime</th>
            <th>Action</th>
		</tr>
	</thead>
	<tbody>
    @foreach($giftcodes as $giftcode) 
		<tr>
            <td>{{ $giftcode->id }}</td>
			<td>{{ $giftcode->title }}</td>
            <td>{{ $giftcode->fanpage_id }}</td>
            <td>{{ $giftcode->start_time }}</td>
            <td>{{ $giftcode->end_time }}</td>
            <td>{{ $giftcode->created_at}}</td>
            <td style="text-align:left;">
                <a href="edit/{{$giftcode->id}}" class="btn btn-xs btn-warning">Sửa</a>
                <a onclick="return confirm('Bạn có chắc chắn muốn xóa?')" href="delete/{{$giftcode->id}}" class="btn btn-xs btn-danger">Delete</a>
            </td>
		</tr>
    @endforeach
	</tbody>
</table>
{{ $giftcodes->links() }}
</div>
</div>
</div>
</div>

@stop