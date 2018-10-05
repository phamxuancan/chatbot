@extends('admin')

@section('content')

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                </h2>
                <ul class="nav navbar-right">
                    <li>
                        <a href="{{\App\Helper::makeURL('keyword/update')}}">
                            <button type="button" class="btn btn-primary btn-sm">Thêm từ khóa
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
                        <td>Nội dung</td>
                        <td>Cách phản hồi</td>
                        <td>Chỉnh sửa</td>
                    </tr>
                    </thead>
                    <tbody>
                    @if($keywords && count($keywords) > 0)
                        @foreach($keywords as $keyword)
                            @php
                                $id = $keyword->id;
                                $name = $keyword->name;
                                $value = $keyword->value;
                                $type = $keyword->getType();
                                $actionName = \App\Helper::getKeywordAction($type);

                                $update_path = 'keyword/update?id='.$id;
                                $delete_path = 'keyword/delete?id='.$id;
                            @endphp
                            <tr>
                                <td>{{$id}}</td>
                                <td>{{$name}}</td>
                                <td style="max-width: 200px;">{{$value}}</td>
                                <td>{{$actionName}}</td>
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