@extends('admin')

@section('content')

    <div class="col-md-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>
                </h2>
                <ul class="nav navbar-right">
                    <li>
                        <a href="{{\App\Helper::makeURL('persistent?action=menu')}}">
                            <button type="button" class="btn btn-warning btn-sm">Quay lại
                            </button>
                        </a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <form id="demo-form2"  method="post"
                      class="form-horizontal form-label-left">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">

                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="title">
                            Tiêu đề
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="title" name="title"
                                   class="form-control col-md-7 col-xs-12">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="type">
                            Loại
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="form-control" id="isChild" name="isChild" required>
                                <option value="">Chọn loại menu</option>
                                <option value="1">Menu chính</option>
                                <option value="0">Menu Cha</option>
                            </select>
                        </div>
                    </div>
                    <div id="type_reply">
                        <div class="form-group" >
                            <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Chọn loại
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="radio" name="type_reply" value="1" checked>Phản hồi
                                    <br/>
                                    <input type="radio" name="type_reply" value="2">URL
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="content">
                                Nội dung
                            </label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                                <input type="text" id="title" name="content"
                                    class="form-control col-md-7 col-xs-12">
                            </div>
                        </div>
                    </div>
                    <div class="form-group" id="child_menu">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">
                            Chọn menu con
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            @foreach($menu_childs as $child)
                                <input type="checkbox" name="child_menu[]" value="{{ $child->id }}">{{ $child->title }}<br/>
                            @endforeach
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
<script>
$(document).ready(function(){
    $('#type_reply').hide();
    $('#child_menu').hide();
    $('#isChild').on('change',function(){
        var value = $('#isChild').val();
        if(value == '1'){
            $('#type_reply').show();
            $('#child_menu').hide();
        }else{
            if(value == '0'){
                $('#type_reply').hide();
                $('#child_menu').show();
            }else{
                $('#type_reply').hide();
                $('#child_menu').hide();
            }
           
        }
    })

});
</script>
@endsection