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
        <label for="text_comment">Fanpage ID:</label>
        <input type="text"  class="form-control" name="post_id" disabled value="{{isset($fanpage_replies->fanpage_id)?$fanpage_replies->fanpage_id:''}}"/>
        <label for="text_comment">Tiêu đề:</label>
        <input type="text"  class="form-control" name="title" required="required" value="{{isset($fanpage_replies->title)?$fanpage_replies->title:''}}" />
        <label for="text_comment">Text comment:</label>
        <textarea  class="form-control text_comment" rows="5" name="text_comment">{{isset($fanpage_replies->keywords)?$fanpage_replies->keywords:''}}</textarea>
        <small><i>
            Chú ý : Các cụm từ khác nhau cách nhau bới dấu xuống dòng
        </i></small>
    </div>
    <div class="form-group">
        <label for="reply_comment">Comment reply:</label>
        <textarea class="form-control" rows="5" name="reply_comment" id="reply_comment">{{isset($fanpage_replies->message)?$fanpage_replies->message:''}}</textarea>
    </div>
    <input name="_token" value="{{csrf_token() }}" type="hidden" />
    <div class="form-group">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
    </form>
</div>
</div>
</div>
<script>
$(document).ready(function() {
    var max_fields      = 10;
    var wrapper         = $(".text");
    var add_button      = $(".add_form_field");
  
    var x = 1;
    $(add_button).click(function(e){
        e.preventDefault();
        if(x < max_fields){
            x++;
            $(wrapper).append('<div ><input type="text" class="form-control text_comment" name="text_comment[]"><a style="float:left" href="#" class="delete">Delete</a></div>'); //add input box
        }
  else
  {
  alert('You Reached the limits')
  }
    });
  
    $(wrapper).on("click",".delete", function(e){
        e.preventDefault(); $(this).parent('div').remove(); x--;
    })
});
</script>
@stop