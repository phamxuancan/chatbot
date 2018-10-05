@extends('admin')

@section('content')
    <div class="x_title">
        <h2>
        </h2>
        <ul class="nav navbar-right">
            <li>
                <a href="Fanpage/add_pages">
                    <button type="button" class="btn btn-primary btn-sm">Add Facebook Page</button>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">
    @include("Elements.error")
        <div class="row">
            @if($facebookPages && count($facebookPages) > 0)
                @foreach($facebookPages as $page)
                    @php
                        $id= $page->id;
                        $id_fanpage= $page->fanpage_id;
                        $imgURL = empty($page->avatar)
                        ? \Illuminate\Support\Facades\URL::asset('/images/default_facebook_image.png')
                        : $page->avatar;

                        $name = $page->name;
                        $selectURL = 'fbpage?action=select&id='.$id.'&fanpage_id='.$id_fanpage;
                    @endphp
                    <div style="float:left;width:50%;">
                        <a href="{{ $selectURL }}">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="x_panel fanpage_class">
                                        <div class="x_title">
                                            <h2>{{$name}}</h2>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="x_content">
                                            <img src="{{$imgURL}}" style="width: 200px; margin: 5px auto;">
                                            <i class="btn-option" style="display:none;">
                                                <a href="Fanpage/hello/{{ $id_fanpage  }}" type="button" class="btn btn-success">Hello</a>
                                                <a href="Fanpage/edit/{{ $id  }}" type="button" class="btn btn-warning">Edit</a>
                                                <a href="Fanpage/delete/{{ $id  }}" type="button" class="btn btn-danger">Delete</a>
                                            </i>    
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            @else
                <h4>Không có Facebook Page nào!!!</h4>
            @endif

        </div>
    </div>
@stop
@section('custom-script')
<script>
    $(document).ready(function() {
        $('.fanpage_class').hover(function() {
           $(this).find(".btn-option").toggle();
        });
    });   
</script>
@stop    