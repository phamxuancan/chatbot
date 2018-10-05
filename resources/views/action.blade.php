@extends('admin')

@section('content')

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                </h2>
                <ul class="nav navbar-right">
                    <li>
                        <a href="{{\App\Helper::makeURL('action/update')}}">
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
                        <td>Tên</td>
                        <td>Tiêu đề</td>
                        <td>Mô tả</td>
                        <td>Số lượng</td>
                        <td>Thao tác</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if($actions && count($actions) > 0)
                        @foreach($actions as $action)
                            @php
                                $id = $action->id;
                                $name = $action->name;
                                $title = $action->title;
                                $desc = $action -> desc;
                                $count = $action->getValuesCount();
                                $update_path = 'action/update?id='.$id;
                                $delete_path = 'action/delete?id='.$id;
                                $manage_path = 'actionvalue?action='.$id;
                            @endphp
                            <tr>
                                <td>{{$id}}</td>
                                <td>{{$name}}</td>
                                <td>{{$title}}</td>
                                <td>{{$desc}}</td>
                                <td>{{$count }}</td>
                                <td>
                                    <ul class="tool-box">
                                        <li>
                                            <a href="{{$manage_path}}">
                                                <button type="button"
                                                        class="btn btn-info btn-xs">Xem
                                                </button>
                                            </a>
                                        </li>
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
                                <h4>Chưa có từ khóa nào!!!</h4>
                            </td>
                        </tr>

                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection