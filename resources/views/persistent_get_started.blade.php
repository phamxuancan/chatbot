@extends('admin')

@section('content')
    <div class="row">
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Chỉnh sửa Get Stared Button</h2>
                    <ul class="nav navbar-right">
                        <li>
                            <a href="{{\App\Helper::makeURL('persistent')}}">
                                <button type="button" class="btn btn-warning btn-sm">Quay lại
                                </button>
                            </a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <form id="demo-form2"  method="post"
                          class="form-horizontal form-label-left" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="payload">
                                Nội dung
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="content" name="content"
                                       value="<?php echo  isset($start_menu->content)?$start_menu->content:''; ?>"
                                       class="form-control col-md-7 col-xs-12" required>
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

    </div>
@endsection

@section('custom-script')
    <script type="text/javascript">
        $(document).ready(function () {
            $('input[type=radio][name=keyword]').change(function () {
                var value = this.value;
                console.log(value);
                $('#payload').val(value);
            });
        });
    </script>

@endsection