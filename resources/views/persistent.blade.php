@extends('admin')

@section('content')
    @php
        $configureGetStaredButtonURL = \App\Helper::makeURL('persistent?action=get_started');
        $configureMenuURL = \App\Helper::makeURL('persistent?action=menu');

        if($getStartedButton){

        }
    @endphp
    <div class="row">
        <div class="col-md-4 col-sm-4 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Cài đặt</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul class="tool-box">
                        <li style="margin: 25px 0;">
                            <a href="{{ $configureGetStaredButtonURL }}">
                                <button type="button" class="btn btn-success">Chỉnh sửa Get Stared
                                    Button
                                </button>
                            </a>
                        </li>

                        <li>
                            <a href="{{ $configureMenuURL }}">
                                <button type="button" class="btn btn-success">Chỉnh sửa Menu
                                </button>
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-8 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2>Thông tin menu</h2>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <ul>
                        <li>

                        </li>
                        <li>

                        </li>
                    </ul>
                </div>
            </div>
        </div>

    </div>
@endsection