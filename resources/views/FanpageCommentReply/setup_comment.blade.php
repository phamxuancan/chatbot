@extends('../admin')
@section('content')
<div class="col-md-12">
        <div class="x_panel">
           
<div class="header">
    <span class="">Cài đặt post</span>
    <hr/>
</div>
<div class="content">
    <form role="form" method="post">
        @include("Elements.error")
        <div class="text form-group">
            <label for="text_comment">Fanpage:</label>
            <input type="text"  class="form-control" name="title" id="title_comment" disabled value="{{$fanpage->name}} - {{$fanpage->fanpage_id}}" />
            <label for="title_comment">Tiêu đề:</label>
            <input type="text"  class="form-control" name="title" id="title_comment" required="required" value="{{isset($fanpage_replies->title)?$fanpage_replies->title:''}}" />
            <label for="text_comment">Text comment(Cụm từ user comment):</label>
            <textarea  class="form-control text_comment" id="text_comment" rows="5" name="text_comment">{{isset($fanpage_replies->keywords)?$fanpage_replies->keywords:''}}</textarea>
            <small><i>
                Chú ý : Các cụm từ khác nhau cách nhau bới dấu phẩy (,)
            </i></small>
        </div>
        <div class="form-group" id="div_reply_comment">
            <label for="reply_comment">Comment reply(Cụm từ trả lời lại cho user):</label>
            <textarea class="form-control" rows="5" name="reply_comment" id="reply_comment">{{isset($fanpage_replies->message)?$fanpage_replies->message:''}}</textarea>
        </div>
        <div class="form-group">
            <label for="is_giftcode">Giftcode</label>
            @if(isset($fanpage_replies->is_giftcode))
                <input type="checkbox" name="is_giftcode" id="is_giftcode" {{!empty($fanpage_replies->is_giftcode)?'checked':''}} />
            @else
            <input type="checkbox" name="is_giftcode" id="is_giftcode"/>
            @endif
            <div style="display:none;" id="select_type">
            Nếu là Giftcode hay chọn loại giftcode được nhận:
                <select class="form-control" id="page_giftcode_id" name="page_giftcode_id">
                    <option value='' selected>Chọn Giftcode</option>
                    @foreach($giftcodes as $code)
                        <option value="{{ $code->id }}">{{ $code->title }}</option>
                    @endforeach
                </select>
            </div>    
        </div>
        <input name="_token" value="{{csrf_token() }}" type="hidden" />
        <div class="form-group">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
    <hr/>
    <div class="container">
    <div style="width:70%;">
    <h4>Kho từ</h4>
    <select class="custom-select" id="category">
        <option value='' selected>Chọn category</option>
        @foreach($categories as $cate)
            <option value="{{ $cate->id }}">{{ $cate->title }}</option>
       @endforeach
    </select>
    <input type="text" id="word_search" placeholder="Search.." name="search">
    <button type="button" id="search_btn"><i class="fa fa-search"></i></button>
    <button id="them_button">
        Thêm
    </button>
  <table class="table" style="width:70%;">
    <thead>
      <tr>
        <th style="width:10%;"><input type="checkbox" id="check_all" class="custom-control-input"> <span class="custom-control-indicator"></span></th>
        <th>Từ</th>
      </tr>
    </thead>
    <tbody id='tbody'>
    
    </tbody>    
  </table>
</div>
    </div>
    
</div>
</div>
</div>
@stop
@section('custom-script')
<script>
$(document).ready(function() {
    
    // var chkArray = [];
    // $('body').on('change','#tbody input',function(){
	// 	chkArray.push($(this).val());
    //     var selected;
    //     selected = chkArray.join(',') ;
    //     alert(selected);
    // })
    $('#check_all').change(function() {
        var checkboxes = $("#tbody").find(':checkbox');
        checkboxes.prop('checked', $(this).is(':checked'));
    });
    $('#is_giftcode').change(function() {
        $('#select_type').toggle()
        $('#div_reply_comment').toggle()
    });
    $("#category").on('change', function(){
        text_search = $('#word_search').val();   
        cate_id = $("#category").val();
        $.ajax({
            url: "./word/getWordByCategory?category_id="+cate_id+"&qword="+text_search,
            method : 'GET',
            success: function( data ) {
                $('#tbody').html(data);;
            },
            error : function(){
                alert('error');
            }
        })
    });
    $('#them_button').on('click',function(){
        var valor = [];
        $('#tbody input[type=checkbox]').each(function () {
            if (this.checked)
                valor.push($(this).val());
        });
        selected = valor.join(',') ;
        var text_comment = $('#text_comment').val();
        if(text_comment != ''){
            value_add = text_comment + ',' + selected;
           
        }else{
            value_add = selected;
        }
        var uniquevalue = [];
        $.each(value_add.split(','), function(i, el){
            if($.inArray(el, uniquevalue) === -1) uniquevalue.push(el);
        });
        result = uniquevalue.join(',') ;
        $('#text_comment').val(result);
    });
    $('#search_btn').on('click',function(){
        text_search = $('#word_search').val();   
        cate_id = $("#category").val(); 
        $.ajax({
            url: "./word/getWordByCategory?category_id="+cate_id+"&qword="+text_search,
            method : 'GET',
            success: function( data ) {
                $('#tbody').html(data);;
            },
            error : function(){
                alert('error');
            }
        })
    });
});
</script>
@stop