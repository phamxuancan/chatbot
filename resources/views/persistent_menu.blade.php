@extends('admin')

@section('content')
    @php
        $configureGetStaredButtonURL = \App\Helper::makeURL('persistent?action=get_stared');
        $configureMenuURL = \App\Helper::makeURL('persistent?action=menu');

    @endphp
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                        Danh sách Menu
                    </h2>
                    <ul class="nav navbar-right">
                        <li>
                            <a href="{{\App\Helper::makeURL('persistent/menu/update?action=menu')}}">
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
                            <td>Status</td>
                            <td>Thao tác</td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($menuList && count($menuList) > 0)
                            @foreach($menuList as $item)
                                @php
                                    $id = $item->id;
                
                                    $type = $item->isChild==0?'Menu Cha':'Menu button';
                                    $title = $item -> title;
                                    $action_id = $item->action_id;
                                    $edit_path = "persistent/menu/edit/$id";
                                    $delete_path = "persistent/menu/delete/$id";
                                    $publish_path = 'persistent/menu/publish?id='.$item->id .'&status='.$item->status;
                                    $status = $item->status=='1'?'Đang hoạt động':'Chưa hoạt động';
                                @endphp
                                <tr>
                                    <td>{{$id}}</td>
                                    <td>{{$title}}</td>
                                    <td>{{$type}}</td>
                                    <td>{{$status}}</td>
                                    <td>
                                        <ul class="tool-box">
                                        @if($item->status == 1)
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
                                                <a href="{{$edit_path}}">
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
                            <tr>
                                <td colspan="6">

                                </td>
                            </tr>
                        @else
                            <tr>
                                <td colspan="5">
                                    <h4>Chưa có menu nào!!!</h4>
                                </td>
                            </tr>

                        @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection