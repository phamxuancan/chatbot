@extends('admin')

@section('content')
    @php
        $action_id = $action -> id;
        $action_name = $action -> name;
        $action_title = $action -> title;
        $action_desc = $action -> desc;

        $create_path = \App\Helper::makeURL('actionvalue/update?action='.$action_id);

    @endphp
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>{{ $action_name }}</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul>
                        <li>
                            {{$action_title}}
                        </li>
                        <li>
                            {{$action_desc}}
                        </li>
                    </ul>
                </div>
            </div>
        </div>

        <div class="col-md-8 col-sm-8 col-xs-8">
            <div class="x_panel">
                <div class="x_title">
                    <h2>
                    </h2>
                    <ul class="nav navbar-right tool-box">
                        <li>
                            <a href="{{\App\Helper::makeURL('action')}}">
                                <button type="button" class="btn btn-warning btn-sm">Quay lại
                                </button>
                            </a>

                        </li>

                        <li>
                            <a href="{{ $create_path }}">
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
                            <td>Mô tả</td>
                            <td>Thao tác</td>
                        </tr>
                        </thead>
                        <tbody>
                        @if($values && count($values) > 0)
                            @foreach($values as $value)
                                @php
                                    $id = $value->id;
                                    $title = $value->title;
                                    $type = $value->type;
                                    $type_name = \App\Helper::getValueType($type);
                                    $content = $value->value;
                                    $desc = $value -> desc;

                                    $updatePath = 'actionvalue/update?action='.$action_id.'&id='.$id;
                                    $deletePath = 'actionvalue/delete?action='.$action_id.'&id='.$id;
                                @endphp
                                <tr>
                                    <td>{{$id}}</td>
                                    <td>{{$title}}</td>
                                    <td>{{$type_name}}</td>
                                    <td>{{$content}}</td>
                                    <td>{{$desc }}</td>
                                    <td>
                                        <ul class="tool-box">
                                            <li>
                                                <a href="{{$updatePath}}">
                                                    <button type="button"
                                                            class="btn btn-success btn-xs">Sửa
                                                    </button>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="{{$deletePath}}"
                                                   onclick="return confirm('Bạn có chắc chắn muốn xóa ko?')">
                                                    <button type="button"
                                                            class="btn btn-warning btn-xs">Xóa
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
                                <td colspan="6">
                                    <h4>Chưa có nội dung !!!</h4>
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