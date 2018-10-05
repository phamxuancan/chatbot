@extends('admin')

@section('content')
    @php
        $action_id = $action -> id;
        $back_path = \App\Helper::makeURL('actionvalue?action='.$action_id);

        $id = $objValue -> id;
        $title = $objValue -> title;
        $type = $objValue -> type;
        $value = $objValue -> value;
        $desc = $objValue -> desc;

    @endphp
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                </h2>
                <ul class="nav navbar-right">
                    <li>
                        <a href="{{ $back_path }}">
                            <button type="button" class="btn btn-primary btn-sm">Quay lại
                            </button>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="demo-form2" data-parsley-validate="" method="post"
                      class="form-horizontal form-label-left" novalidate="">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="action_id" value="{{ $action_id }}">
                    <input type="hidden" name="id" value="{{ $id }}">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            Tiêu đề
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="last-name" name="title"
                                   value="{{ old('title', $title) }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">
                            Loại
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input type="radio"
                                           {{\App\Helper::getChecked($type, \App\Constants::VALUE_TYPE_MESSAGE)}}
                                           value="{{ \App\Constants::VALUE_TYPE_MESSAGE }}"
                                           id="type1" name="type"> Phản hồi
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio"
                                           {{\App\Helper::getChecked($type, \App\Constants::VALUE_TYPE_BUTTON)}}
                                           value="{{ \App\Constants::VALUE_TYPE_BUTTON }}"
                                           id="type2" name="type"> URL
                                    option
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="value">
                            Nội dung
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="value" name="value"
                                   value="{{ old('value', $value) }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc">
                            Mô tả chức năng
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="desc" name="desc"
                                   value="{{ old('desc', $desc) }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="ln_solid"></div>
                    <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                            <button type="submit" class="btn btn-success">Hoàn thành</button>
                        </div>
                    </div>

                </form>

            </div>
        </div>
    </div>
@endsection