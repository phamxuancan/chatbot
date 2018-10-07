@extends('admin')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Danh sách Menu persistent con
                    </h2>
                    <ul class="nav navbar-right">
                        <li>
                            <a href="{{\App\Helper::makeURL('add_persistent')}}">
                                <button type="button" class="btn btn-primary btn-sm">Thêm mới
                                </button>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table class="table table-striped">
                        <thead>
                        <tr>
                            <td>#</td>
                            <td>Tiêu đề</td>
                            <td>Loại</td>
                            <td>Nội dung</td>
                            <td>Status</td>
                            <td>Thao tác</td>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach($menu_childs as $menu)
                            @php
                                $update_path = 'menuchild/update?id='.$menu->id;
                                $delete_path = 'menuchild/delete?id='.$menu->id;
                                $publish_path = 'menuchild/publish?id='.$menu->id .'&status='.$menu->status;
                                $type = $menu->type=='1'?'Phản hồi':'URL';
                                $status = $menu->status=='1'?'Đang hoạt động':'Chưa hoạt động';
                            @endphp
                            <tr>
                                <td>{{$menu->id}}</td>
                                <td>{{$menu->title}}</td>
                                <td>{{$type}}</td>
                                <td>{{$menu->content}}</td>
                                <td>{{$status}}</td>
                                <td>
                                    <ul class="tool-box">
                                    @if($menu->status == 1)
                                    <li>
                                            <a href="{{$publish_path}}">
                                                <button type="button"
                                                        class="btn btn-success btn-xs">Unpublish
                                                </button>
                                            </a>
                                        </li>
                                    @else
                                    <li>
                                            <a href="{{$publish_path}}">
                                                <button type="button"
                                                        class="btn btn-success btn-xs">Publish
                                                </button>
                                            </a>
                                        </li>
                                    @endif
                                        <li>
                                            <a href="{{$update_path}}">
                                                <button type="button"
                                                        class="btn btn-success btn-xs">Sửa
                                                </button>
                                            </a>
                                        </li>
                                        <li>
                                            <a href="{{$delete_path}}"
                                               onclick="return confirm('Bạn có chắc chắn muốn xóa ko?')">
                                                <button type="button"
                                                        class="btn btn-danger btn-xs">Xóa
                                                </button>
                                            </a>
                                        </li>
                                    </ul>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection