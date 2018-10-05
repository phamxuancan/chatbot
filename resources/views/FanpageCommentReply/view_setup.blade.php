@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
           
<div class="header">
    <span class="">Cài đặt comment</span>
    <!-- <span class="pull-right"><a href="view_setup" title="Thêm fanpage"><i class="fa fa-plus-circle"></i></a></span> -->
    <hr/>
</div>
<div class="content">
    @include("Elements.error")
    <form class="form-inline" method="POST">
        <select name="fanpage_id" class="form-control" id="sel1">
            <option value="0">Hãy chọn fanpage</option>
            @foreach($fanpages as $fanpage)
                <option value="{{$fanpage->fanpage_id}}">{{$fanpage->name}}</option>
            @endforeach
        </select>
        <label for="from_time">From time</label>
        <input type="date" class="form-control" id="from_time" name="from_time" placeholder="From time">
        <label for="from_time">To time</label>
        <input type="date" class="form-control" id="to_time" name="to_time" placeholder="To time">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    <table class="table table-hover table-bordered">
	<thead>
		<tr>
            <th>Id Post</th>
            <th>Message</th>
			<th>Created</th>
		</tr>
	</thead>
	<tbody>
    @foreach($datas as $data) 
        @if(isset($data['message']))
		<tr>
            <td>{{ $data['id'] }}</td>
            <td>{{ $data['message'] }}</td>
            <td>{{ $data['created_time']}}</td>
            <td>
                <a href="setting_post/{{$data['id']}}" class="btn btn-xs btn-warning">Setup</a>
            </td>
		</tr>
        @endif
    @endforeach
	</tbody>
</table>
</div>
</div>
</div>
@stop