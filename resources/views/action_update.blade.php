@extends('admin')

@section('content')
    @php
        $id = $action->id;
        $name = $action->name;
        $title = $action->title;
        $desc = $action->desc;
        $manage_url = \App\Helper::makeURL('actionvalue?action='.$id);
    @endphp
    <div class="col-md-12">
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
                        <a href="{{$manage_url}}">
                            <button type="button" class="btn btn-info btn-sm">Xem
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

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="name">
                            Tên menu <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="name" required="required" name="name"
                                   value="{{ old('name', $name) }}"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
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