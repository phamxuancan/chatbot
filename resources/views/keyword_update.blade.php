@extends('admin')

@section('content')
    @php
        $hasMenu = $actionList && count($actionList) > 0;
        $id = $keyword->id;
        $name = $keyword->name;
        $content = $keyword->value;
        $desc = $keyword->desc;
        $action_id = $keyword->action_id;

        $action = $keyword->getAction();

        $action_type = \App\Constants::ACTION_TYPE_MESSAGE;
        $message = '';
        if($action){
            $action_type = $action->type;
            if($action_type == \App\Constants::ACTION_TYPE_MESSAGE){
                $actionValues = $action->getValues();
                if($actionValues && count($actionValues) > 0){
                    $message = $actionValues[0]->value;
                }
            }
        }
        $typeMessageChecked = $action_type == \App\Constants::ACTION_TYPE_MESSAGE ? 'checked': '';
        $typeButtonChecked = $action_type == \App\Constants::ACTION_TYPE_BUTTON ? 'checked': '';

        $typeMessageDisplay = $typeMessageChecked ? 'block' : 'none';
        $typeButtonDisplay = $typeButtonChecked ? 'block' : 'none';

    @endphp
    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                </h2>
                <ul class="nav navbar-right">
                    <li>
                        <a href="{{\App\Helper::makeURL('keyword')}}">
                            <button type="button" class="btn btn-warning btn-sm">Quay lại
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
                    <input type="hidden" name="id" value="{{ $id }}">
                    <input type="hidden" name="action_id" value="{{ $action_id }}">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            Tên <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" required="required" name="name"
                                   value="{{ old('name', $name)  }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="value">
                            Nội dung
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="value" name="value"
                                   value="{{ old('value', $content)  }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="desc">
                            Mô tả chức năng
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="desc" name="desc"
                                   value="{{ old('desc', $desc)  }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">
                            Cách phản hồi
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div class="radio">
                                <label>
                                    <input type="radio"
                                           {{$typeMessageChecked}}
                                           value="{{ \App\Constants::VALUE_TYPE_MESSAGE }}"
                                           id="type1" name="type"> Tin nhắn
                                </label>
                            </div>
                            <div class="radio">
                                <label>
                                    <input type="radio"
                                           {{$typeButtonChecked}}
                                           value="{{ \App\Constants::VALUE_TYPE_BUTTON }}"
                                           id="type2" name="type"> Các lựa chọn
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Nội dung phản hồi
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <div id="text-response" style="display: {{ $typeMessageDisplay }}">
                                <input type="text" id="text_value" name="keyword_message"
                                       value="{{ old('keyword_message', $message) }}"
                                       class="form-control col-md-7 col-xs-12">
                            </div>
                            <div id="menu-response" style="display: {{ $typeButtonDisplay }}">
                                <div class="ln_solid"></div>
                                @if($hasMenu)
                                    @foreach($actionList as $action)
                                        @php
                                            $current_id = $action -> id;
                                            $action_name = $action -> name;
                                            $action_desc = $action -> desc;
                                            $action_checked = $current_id == $action_id ? 'checked' : '';
                                        @endphp
                                        <div class="radio">
                                            <label>
                                                <input type="radio"
                                                       {{ $action_checked }}
                                                       value="{{ $current_id }}"
                                                       id="type1" name="keyword_action">
                                                {{$action_name}}
                                            </label>
                                            <div style="margin-left: 25px; font-size: 12px; font-style: italic; padding: 4px 0;">
                                                {{$action_desc}}
                                            </div>
                                        </div>

                                    @endforeach
                                @else
                                    <h2>Chưa có menu nào</h2>
                                @endif
                            </div>
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

@section('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[type=radio][name=type]').change(function () {
                var value = this.value;
                if (value == 1) {
                    $('#text-response').show(200);
                    $('#menu-response').hide();
                } else {
                    $('#text-response').hide();
                    $('#menu-response').show(200);
                }
            });
        });
    </script>

@endsection