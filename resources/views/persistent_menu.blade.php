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
                            <a href="{{\App\Helper::makeURL('persistent/menu/update')}}">
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
                            <td>Thao tác</td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($menuList && count($menuList) > 0)
                            @foreach($menuList as $item)
                                @php
                                    $id = $item->id;
                                    $parentId = $item->parentId;
                                    $type = $item->type;
                                    $title = $item -> title;
                                    $payload = $item->payload;
                                    $update_path = 'persistent/menu/update?id='.$id;
                                    $delete_path = 'persistent/menu/delete?id='.$id;
                                @endphp
                                <tr>
                                    <td>{{$id}}</td>
                                    <td>{{$title}}</td>
                                    <td>{{$type}}</td>
                                    <td>{{$payload}}</td>
                                    <td>
                                        <ul class="tool-box">
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