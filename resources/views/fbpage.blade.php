@extends('admin')

@section('content')
    <div class="x_title">
        <h2>
        </h2>
        <ul class="nav navbar-right">
            <li>
                <a href="Fanpage/add_pages">
                    <button type="button" class="btn btn-primary btn-sm">Thêm Facebook Page</button>
                </a>
            </li>
        </ul>
        <div class="clearfix"></div>
    </div>
    <div class="x_content">

        <div class="row">
            @if($facebookPages && count($facebookPages) > 0)
                @foreach($facebookPages as $page)
                    @php
                        $id= $page->id;
                        $id_fanpage= $page->fanpage_id;
                        $imgURL = $page->avatar == null
                        ? \Illuminate\Support\Facades\URL::asset('/images/default_facebook_image.png')
                        : $page->avatar;

                        $name = $page->name;
                        $selectURL = 'fbpage?action=select&id='.$id.'&fanpage_id='.$id_fanpage;
                    @endphp
                    <a href="{{ $selectURL }}">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="x_panel">
                                    <div class="x_title">
                                        <h2>{{$name}}</h2>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="x_content">
                                        <img src="{{$imgURL}}"
                                             style="width: 200px; margin: 5px auto;">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                @endforeach
            @else
                <h4>Không có Facebook Page nào!!!</h4>
            @endif

        </div>
    </div>
@endsection